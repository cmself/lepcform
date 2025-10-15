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

function lmc_php_form() {

    // Exemple : Création de la base de données
    global $wpdb;
    $table_name = $wpdb->prefix . 'lmc_multistep_submissions';
    $wpdb->query("
                CREATE TABLE IF NOT EXISTS $table_name (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nom VARCHAR(255),
                    email VARCHAR(255),
                    adresse VARCHAR(255),
                    ville VARCHAR(255),
                    date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;
            ");

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

    // Génération du token côté serveur
    if (!isset($_SESSION['lmc_data']['csrf_token'])) {
        $_SESSION['lmc_data']['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Le cookie
    if (!isset($_COOKIE["lmc-multistep-form"])) {
        setcookie(
            "lmc-multistep-form",
            $_SESSION['lmc_data']['csrf_token'],
            [
                'expires' => time() + 86400, // 1 jour
                'path' => '/',
                'domain' => 'lmc-lepc.com',
                'secure' => true,     // envoyé seulement via HTTPS
                'httponly' => true,   // inaccessible en JavaScript
                'samesite' => 'Strict' // protège contre les attaques CSRF
            ]
        );
    }

    if (isset($_COOKIE["lmc-multistep-form"])) {
        // vérifier si existe
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_COOKIE["lmc-multistep-form"]}'", OBJECT );

        if (count($results) < 1) {
            // Enregistrement la session en  base de données
            $wpdb->insert($table_name, [
                'cookie' => $_COOKIE["lmc-multistep-form"]
            ]);
        }
    }


    // Implémentation du compteur de tentatives
    if (!isset($_SESSION['lmc_data']['attempts'])) {
        $_SESSION['lmc_data']['attempts'] = 0;
        $_SESSION['lmc_data']['attempt_time'] = time();
    }

    // Déterminer l’étape actuelle
    $step = isset($_POST['step']) ? intval($_POST['step']) : 1;

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
        }
    }

    // Formulaire multi-étapes
    ob_start();
    ?>

    <div class="w-full! m-auto! max-w-[1140px]! py-[40px]! font-roboto!" id="lmc-multistep-form">
        <?php include_once 'src/form/steps.php'; ?>
        <form method="post">
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
            }
            ?>
        </form>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('lmc-multistep-form', 'lmc_php_form');
