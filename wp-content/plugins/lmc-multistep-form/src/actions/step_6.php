<?php

/*
 * Token CSRF
 */
if (!isset($_POST['step1_csrf_token']) || $_POST['step1_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 6;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    logLmc("Token CSRF invalide");
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step1_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 6;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    logLmc("Honey Pot rempli (robot détecté)");
}

/*
 * Enregistre les variables de session des étapes
 */
$_SESSION['lmc_data']['reload'] = 6;
$_SESSION['lmc_data']['step5_paiement'] = isset($_POST['step5_paiement']) ? sanitize_textarea_field($_POST['step5_paiement']) : "";
$_SESSION['lmc_data']['step5_bc'] = isset($_POST['step5_bc']) ? sanitize_textarea_field($_POST['step5_bc']) : "";
$_SESSION['lmc_data']['step5_help'] = isset($_POST['step5_help']) ? sanitize_textarea_field($_POST['step5_help']) : "";
$_SESSION['lmc_data']['step5_rgpd'] = isset($_POST['step5_rgpd']) ? sanitize_textarea_field($_POST['step5_rgpd']) : "0";


/*
 * vérifier si les données existent en base de données
 */
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

    /*
     * Enregistrement les données en base de données
     */
    $wpdb->update($table_name, [
        'step5_paiement' => $_SESSION['lmc_data']['step5_paiement'],
        'step5_bc' => $_SESSION['lmc_data']['step5_bc'],
        'step5_help' => $_SESSION['lmc_data']['step5_help'],
        'step5_rgpd' => $_SESSION['lmc_data']['step5_rgpd']
    ],
        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);
}

?>