
<?php


/*
 * Token CSRF
 */
if (!isset($_POST['step4_csrf_token']) || $_POST['step4_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 5;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    lmc_multistep_form__logLmc("Token CSRF invalide");
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step4_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 5;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté)");
}


/*
 * Enregistre les variables de session des étapes
 */
$_SESSION['lmc_data']['reload'] = 5;
$_SESSION['lmc_data']['step4_engagement_1'] = isset($_POST['step4_engagement_1']) ? sanitize_text_field($_POST['step4_engagement_1']) : "";
$_SESSION['lmc_data']['step4_engagement_2'] = isset($_POST['step4_engagement_2']) ? sanitize_text_field($_POST['step4_engagement_2']) : "";
$_SESSION['lmc_data']['step4_engagement_3'] = isset($_POST['step4_engagement_3']) ? sanitize_text_field($_POST['step4_engagement_3']) : "";
$_SESSION['lmc_data']['step4_engagement_4'] = isset($_POST['step4_engagement_4']) ? sanitize_text_field($_POST['step4_engagement_4']) : "";
$_SESSION['lmc_data']['step4_engagement_5'] = isset($_POST['step4_engagement_5']) ? sanitize_text_field($_POST['step4_engagement_5']) : "";
$_SESSION['lmc_data']['step4_engagement_6'] = isset($_POST['step4_engagement_6']) ? sanitize_text_field($_POST['step4_engagement_6']) : "";

/*
 * vérifier si les données existent en base de données
 */
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

    /*
     * Enregistrement les données en base de données
     */

    $wpdb->update($table_name, [
        'step4_engagement_1' => $_SESSION['lmc_data']['step4_engagement_1'],
        'step4_engagement_2' => $_SESSION['lmc_data']['step4_engagement_2'],
        'step4_engagement_3' => $_SESSION['lmc_data']['step4_engagement_3'],
        'step4_engagement_4' => $_SESSION['lmc_data']['step4_engagement_4'],
        'step4_engagement_5' => $_SESSION['lmc_data']['step4_engagement_5'],
        'step4_engagement_6' => $_SESSION['lmc_data']['step4_engagement_6']
    ],
        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);

}


?>