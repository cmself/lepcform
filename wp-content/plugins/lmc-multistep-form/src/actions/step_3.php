<?php

// Token CSRF
if (!isset($_POST['step2_csrf_token']) || $_POST['step2_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

// Honey Pot pour piéger les robots
if (!empty($_POST['step2_honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

// Test de rapidité d’envoi
if (isset($_POST['step2_formStartTime'])) {
    $duration = time() - (int) ($_POST['step2_formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}



$_SESSION['lmc_data']['step2_prenom_0'] = isset($_POST['step2_prenom_0']) ? sanitize_text_field($_POST['step2_prenom_0']) : "";
$_SESSION['lmc_data']['step2_nom_0'] = isset($_POST['step2_nom_0']) ? sanitize_text_field($_POST['step2_nom_0']) : "";
$_SESSION['lmc_data']['step2_fonction_0'] = isset($_POST['step2_fonction_0']) ? sanitize_text_field($_POST['step2_fonction_0']) : "";
$_SESSION['lmc_data']['step2_email_0'] = isset($_POST['step2_email_0']) ? sanitize_email($_POST['step2_email_0']) : "";
$_SESSION['lmc_data']['step2_role_0'] = isset($_POST['step2_role_0']) ? sanitize_text_field($_POST['step2_role_0']) : "";
$_SESSION['lmc_data']['step2_signataire_0'] = isset($_POST['step2_signataire_0']) ? sanitize_text_field($_POST['step2_signataire_0']) : "";

$_SESSION['lmc_data']['step2_prenom_1'] = isset($_POST['step2_prenom_1']) ? sanitize_text_field($_POST['step2_prenom_1']) : "";
$_SESSION['lmc_data']['step2_nom_1'] = isset($_POST['step2_nom_1']) ? sanitize_text_field($_POST['step2_nom_1']) : "";
$_SESSION['lmc_data']['step2_fonction_1'] = isset($_POST['step2_fonction_1']) ? sanitize_text_field($_POST['step2_fonction_1']) : "";
$_SESSION['lmc_data']['step2_email_1'] = isset($_POST['step2_email_1']) ? sanitize_email($_POST['step2_email_1']) : "";
$_SESSION['lmc_data']['step2_role_1'] = isset($_POST['step2_role_1']) ? sanitize_text_field($_POST['step2_role_1']) : "";
$_SESSION['lmc_data']['step2_signataire_1'] = isset($_POST['step2_signataire_1']) ? sanitize_text_field($_POST['step2_signataire_1']) : "";

$_SESSION['lmc_data']['step2_prenom_2'] = isset($_POST['step2_prenom_2']) ? sanitize_text_field($_POST['step2_prenom_2']) : "";
$_SESSION['lmc_data']['step2_nom_2'] = isset($_POST['step2_nom_2']) ? sanitize_text_field($_POST['step2_nom_2']) : "";
$_SESSION['lmc_data']['step2_fonction_2'] = isset($_POST['step2_fonction_2']) ? sanitize_text_field($_POST['step2_fonction_2']) : "";
$_SESSION['lmc_data']['step2_email_2'] = isset($_POST['step2_email_2']) ? sanitize_email($_POST['step2_email_2']) : "";
$_SESSION['lmc_data']['step2_role_2'] = isset($_POST['step2_role_2']) ? sanitize_text_field($_POST['step2_role_2']) : "";
$_SESSION['lmc_data']['step2_signataire_2'] = isset($_POST['step2_signataire_2']) ? sanitize_text_field($_POST['step2_signataire_2']) : "";

$_SESSION['lmc_data']['step2_prenom_3'] = isset($_POST['step2_prenom_3']) ? sanitize_text_field($_POST['step2_prenom_3']) : "";
$_SESSION['lmc_data']['step2_nom_3'] = isset($_POST['step2_nom_3']) ? sanitize_text_field($_POST['step2_nom_3']) : "";
$_SESSION['lmc_data']['step2_fonction_3'] = isset($_POST['step2_fonction_3']) ? sanitize_text_field($_POST['step2_fonction_3']) : "";
$_SESSION['lmc_data']['step2_email_3'] = isset($_POST['step2_email_3']) ? sanitize_email($_POST['step2_email_3']) : "";
$_SESSION['lmc_data']['step2_role_3'] = isset($_POST['step2_role_3']) ? sanitize_text_field($_POST['step2_role_3']) : "";
$_SESSION['lmc_data']['step2_signataire_3'] = isset($_POST['step2_signataire_3']) ? sanitize_text_field($_POST['step2_signataire_3']) : "";



// vérifier si existe
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_COOKIE["lmc-multistep-form"]}'", OBJECT );

if (count($step1_results) === 1) {

    // Enregistrement les données en base de données
    $wpdb->update($table_name, [
        'step2_prenom_0' => $_SESSION['lmc_data']['step2_prenom_0'],
        'step2_nom_0' => $_SESSION['lmc_data']['step2_nom_0'],
        'step2_fonction_0' => $_SESSION['lmc_data']['step2_fonction_0'],
        'step2_email_0' => $_SESSION['lmc_data']['step2_email_0'],
        'step2_role_0' => $_SESSION['lmc_data']['step2_role_0'],
        'step2_signataire_0' => $_SESSION['lmc_data']['step2_signataire_0'],
        'step2_prenom_1' => $_SESSION['lmc_data']['step2_prenom_1'],
        'step2_nom_1' => $_SESSION['lmc_data']['step2_nom_1'],
        'step2_fonction_1' => $_SESSION['lmc_data']['step2_fonction_1'],
        'step2_email_1' => $_SESSION['lmc_data']['step2_email_1'],
        'step2_role_1' => $_SESSION['lmc_data']['step2_role_1'],
        'step2_signataire_1' => $_SESSION['lmc_data']['step2_signataire_1'],
        'step2_prenom_2' => $_SESSION['lmc_data']['step2_prenom_2'],
        'step2_nom_2' => $_SESSION['lmc_data']['step2_nom_2'],
        'step2_fonction_2' => $_SESSION['lmc_data']['step2_fonction_2'],
        'step2_email_2' => $_SESSION['lmc_data']['step2_email_2'],
        'step2_role_2' => $_SESSION['lmc_data']['step2_role_2'],
        'step2_signataire_2' => $_SESSION['lmc_data']['step2_signataire_2'],
        'step2_prenom_3' => $_SESSION['lmc_data']['step2_prenom_3'],
        'step2_nom_3' => $_SESSION['lmc_data']['step2_nom_3'],
        'step2_fonction_3' => $_SESSION['lmc_data']['step2_fonction_3'],
        'step2_email_3' => $_SESSION['lmc_data']['step2_email_3'],
        'step2_role_3' => $_SESSION['lmc_data']['step2_role_3'],
        'step2_signataire_3' => $_SESSION['lmc_data']['step2_signataire_3']
    ],
        ['cookie' => $_COOKIE["lmc-multistep-form"]]);
}


?>