
<?php

// Token CSRF
if (!isset($_POST['step4_csrf_token']) || $_POST['step4_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

// Honey Pot pour piéger les robots
if (!empty($_POST['step4_honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

// Test de rapidité d’envoi
if (isset($_POST['step4_formStartTime'])) {
    $duration = time() - (int) ($_POST['step4_formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}

$_SESSION['lmc_data']['step4_nom'] = isset($_POST['step4_nom']) ? sanitize_text_field($_POST['step4_nom']) : "";

// vérifier si existe
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

// Enregistrement les données en base de données
    /*
    $wpdb->update($table_name, [
        'step4_nom' => $_SESSION['lmc_data']['step4_nom'],

    ],
        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);
    */
}


?>