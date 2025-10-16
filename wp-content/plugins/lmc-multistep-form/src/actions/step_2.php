<?php
/*
$fichierActuel = $_SERVER['PHP_SELF'] ;
if(!empty($_SERVER['QUERY_STRING']))
{
    $fichierActuel .= '?step=' . 2 ;
}
header('Location: ' . $fichierActuel);
*/

// Token CSRF
if (!isset($_POST['step1_csrf_token']) || $_POST['step1_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

// Honey Pot pour piéger les robots
if (!empty($_POST['step1_honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

// Test de rapidité d’envoi
if (isset($_POST['step1_formStartTime'])) {
    $duration = time() - (int) ($_POST['step1_formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}


$_SESSION['lmc_data']['step1_nom'] = isset($_POST['step1_nom']) ? sanitize_text_field($_POST['step1_nom']) : "";
$_SESSION['lmc_data']['step1_siret'] = isset($_POST['step1_siret']) ? sanitize_text_field($_POST['step1_siret']) : "";
$_SESSION['lmc_data']['step1_logo'] = isset($_POST['step1_logo']) ? sanitize_file_name($_POST['step1_logo']) : "";
$_SESSION['lmc_data']['step1_ca'] = isset($_POST['step1_ca']) ? sanitize_text_field($_POST['step1_ca']) : "";
$_SESSION['lmc_data']['step1_frais'] = isset($_POST['step1_frais']) ? sanitize_text_field($_POST['step1_frais']) : "";
$_SESSION['lmc_data']['step1_adherent'] = isset($_POST['step1_adherent']) ? sanitize_text_field($_POST['step1_adherent']) : "";
$_SESSION['lmc_data']['step1_adresse'] = isset($_POST['step1_adresse']) ? sanitize_text_field($_POST['step1_adresse']) : "";
$_SESSION['lmc_data']['step1_ville'] = isset($_POST['step1_ville']) ? sanitize_text_field($_POST['step1_ville']) : "";
$_SESSION['lmc_data']['step1_cp'] = isset($_POST['step1_cp']) ? sanitize_text_field($_POST['step1_cp']) : "";
$_SESSION['lmc_data']['step1_email'] = isset($_POST['step1_email']) ? sanitize_email($_POST['step1_email']) : "";
$_SESSION['lmc_data']['step1_internet'] = isset($_POST['step1_internet']) ? sanitize_url($_POST['step1_internet']) : "";
$_SESSION['lmc_data']['step1_collaborateurs'] = isset($_POST['step1_collaborateurs']) ? sanitize_text_field($_POST['step1_collaborateurs']) : "";
$_SESSION['lmc_data']['step1_activite'] = isset($_POST['step1_activite']) ? sanitize_text_field($_POST['step1_activite']) : "";
$_SESSION['lmc_data']['step1_structure'] = isset($_POST['step1_structure']) ? sanitize_text_field($_POST['step1_structure']) : "";
$_SESSION['lmc_data']['step1_connaissance'] = isset($_POST['step1_connaissance']) ? sanitize_text_field($_POST['step1_connaissance']) : "";
$_SESSION['lmc_data']['step1_politique'] = isset($_POST['step1_politique']) ? sanitize_textarea_field($_POST['step1_politique']) : "";


// vérifier si existe
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_COOKIE["lmc-multistep-form"]}'", OBJECT );

if (count($step1_results) === 1) {

    // Enregistrement les données en base de données
    $wpdb->update($table_name, [
        'step1_nom' => $_SESSION['lmc_data']['step1_nom'],
        'step1_siret' => $_SESSION['lmc_data']['step1_siret'],
        'step1_logo' => $_SESSION['lmc_data']['step1_logo'],
        'step1_ca' => $_SESSION['lmc_data']['step1_ca'],
        'step1_frais' => $_SESSION['lmc_data']['step1_frais'],
        'step1_adherent' => $_SESSION['lmc_data']['step1_adherent'],
        'step1_adresse' => $_SESSION['lmc_data']['step1_adresse'],
        'step1_ville' => $_SESSION['lmc_data']['step1_ville'],
        'step1_cp' => $_SESSION['lmc_data']['step1_cp'],
        'step1_email' => $_SESSION['lmc_data']['step1_email'],
        'step1_internet' => $_SESSION['lmc_data']['step1_internet'],
        'step1_collaborateurs' => $_SESSION['lmc_data']['step1_collaborateurs'],
        'step1_activite' => $_SESSION['lmc_data']['step1_activite'],
        'step1_structure' => $_SESSION['lmc_data']['step1_structure'],
        'step1_connaissance' => $_SESSION['lmc_data']['step1_connaissance'],
        'step1_politique' => $_SESSION['lmc_data']['step1_politique']
    ],
    ['cookie' => $_COOKIE["lmc-multistep-form"]]);
}


?>