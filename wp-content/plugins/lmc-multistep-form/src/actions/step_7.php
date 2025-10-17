<?php

// Token CSRF
if (!isset($_POST['step6_csrf_token']) || $_POST['step6_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

// Honey Pot pour piéger les robots
if (!empty($_POST['step6_honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

// Test de rapidité d’envoi
if (isset($_POST['step6_formStartTime'])) {
    $duration = time() - (int) ($_POST['step6_formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
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