<?php
/**
 * Plugin Name: LMC Form MultiStep
 * Description: Formulaire multi-étapes en PHP.
 * Version: 1.0
 * Author: LMC
 * https://lepc.lmc-dev.fr/lmc-form/
 */

/**
 * https://ohme.welcome-ohme.fr/v1/docs/index.html#authentification
 */

if (!defined('ABSPATH')) exit;
function lmc_start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'lmc_start_session');

// Charger les scripts
function lmc_enqueue_assets() {
    wp_enqueue_style('lmc-tippycss', plugin_dir_url(__FILE__) . 'node_modules/tippy.js/dist/tippy.css');
    wp_enqueue_style('lmc-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('lmc-popperjs','https://unpkg.com/@popperjs/core@2' , false, true);
    wp_enqueue_script('lmc-tippyjs','https://unpkg.com/tippy.js@6' , false, true);
    wp_enqueue_script('lmc-recaptcha','https://www.google.com/recaptcha/api.js' , false, true);
    wp_enqueue_script('lmc-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'lmc_enqueue_assets');


require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


define('MailHOST', 'mail.gandi.net');
define('MailUSER', 'hebergement@lmcfrance.com');
define('MailPWD', '*xSe9r4BA0AndFUEu!0A');
define('MailSENDER', 'hebergement@lmcfrance.com');
define('MailNAME', 'lmc france');



function lmc_php_form() {

    // Exemple : Création de la base de données
    global $wpdb;
    $table_name = $wpdb->prefix . 'lmc_multistep_submissions';
    $wpdb->query("
        CREATE TABLE IF NOT EXISTS $table_name (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `cookie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
          `step1_nom` varchar(255) NOT NULL,
          `step1_siret` varchar(255) NOT NULL,
          `step1_logo` text NOT NULL,
          `step1_ca` varchar(255) NOT NULL,
          `step1_frais` varchar(255) NOT NULL,
          `step1_adherent` tinyint(1) NOT NULL,
          `step1_adresse` text NOT NULL,
          `step1_ville` varchar(255) NOT NULL,
          `step1_cp` varchar(10) NOT NULL,
          `step1_email` text NOT NULL,
          `step1_internet` text NOT NULL,
          `step1_collaborateurs` varchar(255) NOT NULL,
          `step1_activite` varchar(255) NOT NULL,
          `step1_structure` varchar(255) NOT NULL,
          `step1_connaissance` varchar(255) NOT NULL,
          `step1_politique` text NOT NULL,
          `step2_prenom_0` varchar(255) NOT NULL,
          `step2_nom_0` varchar(255) NOT NULL,
          `step2_fonction_0` varchar(255) NOT NULL,
          `step2_email_0` text NOT NULL,
          `step2_role_0` varchar(255) NOT NULL,
          `step2_signataire_0` varchar(10) NOT NULL,
          `step2_prenom_1` varchar(255) NOT NULL,
          `step2_nom_1` varchar(255) NOT NULL,
          `step2_fonction_1` varchar(255) NOT NULL,
          `step2_email_1` text NOT NULL,
          `step2_role_1` varchar(255) NOT NULL,
          `step2_signataire_1` varchar(10) NOT NULL,
          `step2_prenom_2` varchar(255) NOT NULL,
          `step2_nom_2` varchar(255) NOT NULL,
          `step2_fonction_2` varchar(255) NOT NULL,
          `step2_email_2` text NOT NULL,
          `step2_role_2` varchar(255) NOT NULL,
          `step2_signataire_2` varchar(10) NOT NULL,
          `step2_prenom_3` varchar(255) NOT NULL,
          `step2_nom_3` varchar(255) NOT NULL,
          `step2_fonction_3` varchar(255) NOT NULL,
          `step2_email_3` text NOT NULL,
          `step2_role_3` varchar(255) NOT NULL,
          `step2_signataire_3` varchar(10) NOT NULL,
          `step3_otp_hash` text NOT NULL,
          `step3_otp_expires` datetime NOT NULL,
          `step3_otp_used` int NOT NULL DEFAULT '0',
          `step4_engagement_1` text NOT NULL,
          `step4_engagement_2` text NOT NULL,
          `step4_engagement_3` text NOT NULL,
          `step4_engagement_4` text NOT NULL,
          `step4_engagement_5` text NOT NULL,
          `step4_engagement_6` text NOT NULL,
          `step5_paiement` varchar(255) NOT NULL,
          `step5_bc` varchar(255) NOT NULL,
          `step5_help` text NOT NULL,
          `step5_rgpd` tinyint(1) NOT NULL DEFAULT '0',
          `date_submitted` datetime DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    ");

    function getCurrentUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST'];

        $uri = $_SERVER['REQUEST_URI'];

        return $protocol . $host . $uri;
    }

    function getCurrentUrlWithoutQuery() {
        // Détermine le protocole
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // Récupère le nom d’hôte
        $host = $_SERVER['HTTP_HOST'];

        // Récupère le chemin sans la query string
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Reconstruit l’URL
        return $protocol . $host . $path;
    }


    function generate_otp(int $digits = 6): string {
        $min = (int) pow(10, $digits - 1);
        $max = (int) pow(10, $digits) - 1;
        return (string) random_int($min, $max); // cryptographically secure
    }

    // Enregistrement des tentatives suspectes
    $logFile = 'lmc-multistep-form.log';
    function logLmc($reason) {
        global $logFile;
        $entry = date('Y-m-d H:i:s') . " - IP: " . $_SERVER['REMOTE_ADDR'] . " - Motif: $reason\n";
        //file_put_contents($logFile, $entry, FILE_APPEND);
    }

    //Vérification du Referer pour bloquer les requêtes externes
    /*
    if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) !== $_SERVER['HTTP_HOST']) {
        logLmc("Requête suspecte (Referer invalide)");
        die("Erreur : Requête suspecte.");
    }
    */


    $client = new Client([
        'verify' => false, // pas sécurisé, uniquement pour test
        'headers' => [
            'Accept' => 'application/json',
            'client-name' => 'lepc',
            'client-secret' => '39a39fbf4a0944abfd57f1d14452c7cba242761035a3e8ab3356cbda7a1c5d0a'
        ]
    ]);

    include_once 'src/api/ohme.php';

    if (!isset($_SESSION['lmc_data'])) {
        $_SESSION['lmc_data'] = [];
    }

    if (!isset($_SESSION['lmc_data']['ohme_data'])) {
        $_SESSION['lmc_data']['ohme_data'] = $opt_ohme;
    }

    // Implémentation du compteur de tentatives
    if (!isset($_SESSION['lmc_data']['attempts'])) {
        $_SESSION['lmc_data']['attempts'] = 0;
        $_SESSION['lmc_data']['attempt_time'] = time();
    }

    // Le cookie
    if (!isset($_COOKIE["lmc-multistep-form"])) {

        // Génération du token côté serveur
        if (!isset($_SESSION['lmc_data']['csrf_token'])) {
            $_SESSION['lmc_data']['csrf_token'] = "lmc-multistep-form_" . bin2hex(random_bytes(32)) . "_" . time();
        }

        setcookie(
            "lmc-multistep-form",
            $_SESSION['lmc_data']['csrf_token'],
            [
                // 1 day = 86400 Seconds
                'expires' => time() + (86400 * 7), // 7 jours
                'path' => '/',
                'domain' => 'lmc-lepc.com',
                'secure' => true,     // envoyé seulement via HTTPS
                'httponly' => true,   // inaccessible en JavaScript
                'samesite' => 'Strict' // protège contre les attaques CSRF
            ]
        );

        // vérifier si existe
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

        if (count($results) != 1) {
            // Enregistrement la session en  base de données
            $wpdb->insert($table_name, [
                'cookie' => $_SESSION['lmc_data']['csrf_token']
            ]);
        }

    }else{

        // Récupération du token côté cookie
        if (!isset($_SESSION['lmc_data']['csrf_token'])) {
            $_SESSION['lmc_data']['csrf_token'] = $_COOKIE["lmc-multistep-form"];
        }

        // vérifier si existe
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

        if (count($results) != 1) {
            // Enregistrement la session en  base de données
            $wpdb->insert($table_name, [
                'cookie' => $_SESSION['lmc_data']['csrf_token']
            ]);
        }

    }


    $value_form = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );



    if(isset($_GET['reload_step']) && !empty($_GET['reload_step'])){
        $_SESSION['lmc_data']['reload'] = $_GET['reload_step'];
        header('Location: ' . getCurrentUrlWithoutQuery());
    }

    // Déterminer l’étape actuelle

    if(isset($_POST['step']) && !empty($_POST['step'])){
        $step = intval($_POST['step']);
    }else{
        if (isset($_SESSION['lmc_data']['reload']) && !empty($_SESSION['lmc_data']['reload'])) {
            $step = $_SESSION['lmc_data']['reload'];
        }else{
            $step = 1;
        }
    }


    // Sauvegarder les données de l’étape précédente
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($step == 2) {
            include_once 'src/actions/step_2.php';
        } elseif ($step == 3) {
            include_once 'src/actions/step_3.php';
        } elseif ($step == 4) {
            include_once 'src/actions/step_4.php';
        } elseif ($step == 5) {
            include_once 'src/actions/step_5.php';
        } elseif ($step == 6) {
            include_once 'src/actions/step_6.php';
        } elseif ($step == 7) {
            include_once 'src/actions/step_7.php';
        }
    }


    // Formulaire multi-étapes
    ob_start();
    ?>

    <div class="w-full! m-auto! max-w-[1140px]! py-[40px]! font-roboto!" id="lmc-multistep-form">
        <?php include_once 'src/form/steps.php'; ?>
        <form method="post" id="form-lmc-multistep-form" class="w-full!">
            <?php
            if ($step == 1) {
                include_once 'src/form/step_1.php';
            } elseif ($step == 2) {
                include_once 'src/form/step_2.php';
            } elseif ($step == 3) {
                include_once 'src/form/step_3.php';
            } elseif ($step == 4) {
                include_once 'src/form/step_4.php';
            } elseif ($step == 5) {
                include_once 'src/form/step_5.php';
            } elseif ($step == 6) {
                include_once 'src/form/step_6.php';
            } elseif ($step == 7) {
                include_once 'src/form/step_7.php';
            }
            ?>
        </form>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('lmc-multistep-form', 'lmc_php_form');
