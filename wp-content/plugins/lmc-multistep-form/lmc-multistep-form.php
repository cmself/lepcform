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

require 'vendor/autoload.php';

use GuzzleHttp\Client;
//use GuzzleHttp\Exception\ClientException;
//use GuzzleHttp\Psr7\Request;
//use GuzzleHttp\Psr7\Response;

/*
 * définition des variables pour envoyer les mails
 */
require 'src/config.php';

/*
 * Démarrer une session PHP
 */
function lmc_multistep_form__start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'lmc_multistep_form__start_session');

/*
 * Charger les scripts et css
 */
function lmc_multistep_form__enqueue_assets() {
    wp_enqueue_style('lmc-tippycss', plugin_dir_url(__FILE__) . 'node_modules/tippy.js/dist/tippy.css');
    wp_enqueue_style('lmc-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('lmc-popperjs','https://unpkg.com/@popperjs/core@2' , false, true);
    wp_enqueue_script('lmc-tippyjs','https://unpkg.com/tippy.js@6' , false, true);
    wp_enqueue_script('lmc-recaptcha','https://www.google.com/recaptcha/api.js' , false, true);
    wp_enqueue_script('lmc-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'lmc_multistep_form__enqueue_assets');


/*
 * Fonction d'activation
 */
function lmc_multistep_form__activation() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'lmc_multistep_form__activation');


/*
 * Fonction de désactivation
 */
function lmc_multistep_form__deactivation() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'lmc_multistep_form__deactivation');


/*
 * Enregistre le Custom Post Type "Fonctions dans l'entreprise"
 */
function lmc_multistep_form__register_cpt_fe() {

    $post_type = 'lmc_multistep_fe';

    if ( ! post_type_exists( $post_type ) ) {

        $labels = array(
            'name' => 'LMC multistep form - Fonctions dans l\'entreprise',
            'singular_name' => 'LMC multistep form - Fonctions dans l\'entreprise',
            'menu_name' => 'LMC multistep form - Fonctions dans l\'entreprise',
            'name_admin_bar' => 'LMC multistep form - Fonctions dans l\'entreprise',
            'add_new' => 'Ajouter une fonction dans l\'entreprise',
            'add_new_item' => 'Ajouter une fonction dans l\'entreprise',
            'edit_item' => 'Modifier la fonction dans l\'entreprise',
            'new_item' => 'Nouvelle fonction dans l\'entreprise',
            'view_item' => 'Voir la fonction dans l\'entreprise',
            'search_items' => 'Rechercher des fonctions dans l\'entreprise',
            'not_found' => 'Aucune fonction dans l\'entreprise trouvée',
            'not_found_in_trash' => 'Aucune fonction dans l\'entreprise dans la corbeille',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => array('title'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'lmc-multistep-fe'),
            'show_in_rest' => true, // pour Gutenberg et API REST
        );

        register_post_type('lmc_multistep_fe', $args);
    }

    /*
     * Enregistre des Fonctions dans l'entreprise
     */
    $csv_file = __DIR__ . '/import/lmc-multistep-fe.csv';

    if ( ! file_exists($csv_file) ) {
        return;
    }

    if ( ! function_exists( 'post_exists' ) ) {
        require_once ABSPATH . 'wp-admin/includes/post.php';
    }

    if (($handle = fopen($csv_file, 'r')) !== false) {
        $header = fgetcsv($handle, 1000, ',');
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $data = array_combine($header, $row);
            if (!post_exists($data['fonction_title'], '', '', $post_type)) {
                wp_insert_post([
                    'post_title'   => $data['fonction_title'],
                    'post_status'  => 'publish',
                    'post_type'    => $post_type
                ]);
            }

        }
        fclose($handle);
    }
}
add_action('init', 'lmc_multistep_form__register_cpt_fe' );



/*
 * Fonction pour récupérer l'URL courante avec variables
 */
function lmc_multistep_form__getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
        || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    $host = $_SERVER['HTTP_HOST'];

    $uri = $_SERVER['REQUEST_URI'];

    return $protocol . $host . $uri;
}

/*
 * Fonction pour récupérer l'URL courante sans variables
 */
function lmc_multistep_form__getCurrentUrlWithoutQuery() {
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

/*
 * Fonction pour générer le code envoyé par mail
 */
function lmc_multistep_form__generate_otp(int $digits = 6): string {
    $min = (int) pow(10, $digits - 1);
    $max = (int) pow(10, $digits) - 1;
    return (string) random_int($min, $max); // cryptographically secure
}

/*
 * Enregistrement des tentatives suspectes
 */
function lmc_multistep_form__logLmc($reason) {
    $logFile = __DIR__ . '/log/lmc-multistep-form.log';
    $entry = date('Y-m-d H:i:s') . " - IP: " . $_SERVER['REMOTE_ADDR'] . " - Motif: $reason\n";
    file_put_contents($logFile, $entry, FILE_APPEND);
    header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=400');
}



function lmc_multistep_form() {

    /*
    * Variable de session global pour le plugin
    */
    if (!isset($_SESSION['lmc_data'])) {
        $_SESSION['lmc_data'] = [];
    }

    if (!isset($_SESSION['lmc_data']['csrf_token'])) {
        $_SESSION['lmc_data']['csrf_token'] = "lmc-multistep-form_" . bin2hex(random_bytes(32)) . "_" . time();
    }

    /*
       * Création de la base de données
       */
    global $wpdb;
    $table_name = $wpdb->prefix . 'lmc_multistep_submissions';
    $wpdb->query("
        CREATE TABLE IF NOT EXISTS $table_name (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `cookie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
          `ohme_id` varchar(255) NOT NULL,
          `resign` tinyint(1) NOT NULL DEFAULT '0',
          `date_de_signature` varchar(255) NOT NULL,
          `step1_nom` varchar(255) NOT NULL,
          `step1_siret` varchar(255) NOT NULL,
          `step1_logo` text NOT NULL,
          `step1_ca` varchar(255) NOT NULL,
          `step1_frais` varchar(255) NOT NULL,
          `step1_adherent` text NOT NULL,
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
          `step0_otp_hash` text NOT NULL,
          `step0_otp_expires` datetime NOT NULL,
          `step0_otp_used` int NOT NULL DEFAULT '0',
          `date_submitted` datetime DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    ");

    /*
     * Authentification à l'API OHME
     */
    $client = new Client([
        'verify' => false, // pas sécurisé, uniquement pour test
        'base_uri' => 'https://api-ohme.oneheart.fr/api/v1/',
        'headers' => [
            'Accept' => 'application/json',
            'client-name' => CLIENTOHME,
            'client-secret' => SECRETOHME
        ]
    ]);

    /*
     * Récupérer les champs personnalisés de OHME
     */
    include_once 'src/api/ohme.php';




    /*
     * Variable de session pour les champs personnalisés de OHME
     */
    if (!isset($_SESSION['lmc_data']['ohme_data'])) {
        $_SESSION['lmc_data']['ohme_data'] = filter_var_array($opt_ohme);
    }


    /*
     * Implémentation du compteur de tentatives de soumissions du formulaire
     */
    if (!isset($_SESSION['lmc_data']['attempts'])) {
        $_SESSION['lmc_data']['attempts'] = 0;
        $_SESSION['lmc_data']['attempt_time'] = time();
    }

    /*
     * COOKIE
     */
    $session_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );
    if (count($session_results) == 0) {
        $wpdb->insert($table_name, [
            'cookie' => $_SESSION['lmc_data']['csrf_token']
        ]);
    }

    /*
    var_dump($_COOKIE["lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST']] ?? 'Cookie not set');
    if (!isset($_COOKIE["lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST']])) {

        // Création du cookie
        setcookie(
            "lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST'],
            $_SESSION['lmc_data']['csrf_token'],
            [
                // 1 jour = 86400 secondes
                'expires' => time() + (86400 * 7), // 7 jours
                'path' => '/',
                'domain' => '.' . $_SERVER['HTTP_HOST'],
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );

        // vérifier si existe
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

        // Enregistrement la session en  base de données
        if (count($results) == 0) {
            $wpdb->insert($table_name, [
                'cookie' => $_SESSION['lmc_data']['csrf_token']
            ]);
        }else{

            //$wpdb->delete($table_name, ['cookie' => $_SESSION['lmc_data']['csrf_token']]);
            //$wpdb->insert($table_name, [
            //    'cookie' => $_SESSION['lmc_data']['csrf_token']
            //]);

        }

    }else{

        // Récupération du token côté cookie
        if (!isset($_SESSION['lmc_data']['csrf_token'])) {
            $_SESSION['lmc_data']['csrf_token'] = $_COOKIE["lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST']];
        }

        // vérifier si existe
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

        // Enregistrement la session en  base de données
        if (count($results) == 0) {
            $wpdb->insert($table_name, [
                'cookie' => $_SESSION['lmc_data']['csrf_token']
            ]);
        }

    }
    */

    /*
     * Récupération des valeurs en base de données
     */
    $value_form = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );



    /*
     * Vérification si retour en arrière des étape
     */
    if(isset($_GET['reload_step']) && !empty($_GET['reload_step'])){
        $_SESSION['lmc_data']['reload'] = intval($_GET['reload_step']);
        header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery());
    }

    /*
     * Déterminer l’étape actuelle
     */
    if(isset($_POST['step']) && !empty($_POST['step'])){
        $step = intval($_POST['step']);
    }else{
        if (isset($_SESSION['lmc_data']['reload']) && !empty($_SESSION['lmc_data']['reload'])) {
            $step = $_SESSION['lmc_data']['reload'];
        }else{
            $step = 1;
        }
    }


    /*
     * Sauvegarder les données de l’étape précédente
     */
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
        }elseif ($step == 8) {
            include_once 'src/actions/step_renouvellement.php';
        }elseif ($step == 400) {
            include_once 'src/actions/error.php';
        }
    }


    /*
     * Formulaire multi-étapes
     */
    ob_start();
    ?>

    <div class="w-full! m-auto! max-w-[1140px]! py-[40px]! font-roboto!" id="lmc-multistep-form">
        <?php
        if ($step != 8 || $step != 7) {
            include_once 'src/form/steps.php';
        }
        ?>
        <form method="post" enctype="multipart/form-data" id="form-lmc-multistep-form" class="w-full!">
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
            } elseif ($step == 8) {
                include_once 'src/form/step_renouvellement.php';
            } elseif ($step == 400) {
                include_once 'src/form/error.php';
            }
            ?>
        </form>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('lmc-multistep-form', 'lmc_multistep_form');
