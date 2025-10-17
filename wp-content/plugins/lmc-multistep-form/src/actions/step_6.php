<?php

// Token CSRF
if (!isset($_POST['step5_csrf_token']) || $_POST['step5_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

// Honey Pot pour piéger les robots
if (!empty($_POST['step5_honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

// Test de rapidité d’envoi
if (isset($_POST['step5_formStartTime'])) {
    $duration = time() - (int) ($_POST['step5_formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}

$_SESSION['lmc_data']['reload'] = 6;

$_SESSION['lmc_data']['step5_paiement'] = isset($_POST['step5_paiement']) ? sanitize_textarea_field($_POST['step5_paiement']) : "";
$_SESSION['lmc_data']['step5_bc'] = isset($_POST['step5_bc']) ? sanitize_textarea_field($_POST['step5_bc']) : "";
$_SESSION['lmc_data']['step5_help'] = isset($_POST['step5_help']) ? sanitize_textarea_field($_POST['step5_help']) : "";
$_SESSION['lmc_data']['step5_rgpd'] = isset($_POST['step5_rgpd']) ? sanitize_textarea_field($_POST['step5_rgpd']) : "0";


// vérifier si existe
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

    // Enregistrement les données en base de données
    $wpdb->update($table_name, [
        'step5_paiement' => $_SESSION['lmc_data']['step5_paiement'],
        'step5_bc' => $_SESSION['lmc_data']['step5_bc'],
        'step5_help' => $_SESSION['lmc_data']['step5_help'],
        'step5_rgpd' => $_SESSION['lmc_data']['step5_rgpd']
    ],
        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);
}

/*

$data = $_SESSION['lmc_data'];
$data['confirmation'] = 'OK';

global $wpdb;
$table_name = $wpdb->prefix . 'lmc_multistep_submissions';
$wpdb->insert($table_name, [
    'nom' => $data['nom'],
    'email' => $data['email'],
    'adresse' => $data['adresse'],
    'ville' => $data['ville']
]);


unset($_SESSION['lmc_data']);

return '<p><strong>Merci !</strong> Votre formulaire a bien été envoyé.</p>';
*/

?>