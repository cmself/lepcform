<?php
/**
 * Plugin Name: LMC Form MultiStep
 * Description: Formulaire multi-étapes en PHP.
 * Version: 1.0
 * Author: LMC
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

    <div class="lmc-multistep-form w-full m-auto max-w-[1140px]! py-[40px] font-roboto">
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
