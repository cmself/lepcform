<?php
// Token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logAttempt("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

// Honey Pot pour piéger les robots
if (!empty($_POST['honeypot'])) {
    logAttempt("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

// Test de rapidité d’envoi
if (isset($_POST['formStartTime'])) {
    $duration = time() - (int) ($_POST['formStartTime'] / 1000);
    if ($duration < 3) {
        logAttempt("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}


$_SESSION['lmc_data']['nom'] = sanitize_text_field($_POST['nom']);
$_SESSION['lmc_data']['email'] = sanitize_email($_POST['email']);
?>