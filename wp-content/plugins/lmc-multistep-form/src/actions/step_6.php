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

// Limiter le nombre de tentatives
if ($_SESSION['lmc_data']['attempts'] >= 5 && (time() - $_SESSION['lmc_data']['attempt_time'] < 300)) {
    logAttempt("Trop de tentatives depuis IP: " . $_SERVER['REMOTE_ADDR']);
    die("Erreur : Trop de tentatives. Veuillez réessayer plus tard.");
}
$_SESSION['lmc_data']['attempts']++;
if ($_SESSION['lmc_data']['attempts'] === 1) {
    $_SESSION['lmc_data']['attempt_time'] = time();
}

// Soumission finale : traiter les données
$data = $_SESSION['lmc_data'];
$data['confirmation'] = 'OK';

// Exemple : Enregistrer dans la base de données
global $wpdb;
$table_name = $wpdb->prefix . 'lmc_multistep_submissions';
$wpdb->query("
                CREATE TABLE IF NOT EXISTS $table_name (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nom VARCHAR(255),
                    email VARCHAR(255),
                    adresse VARCHAR(255),
                    ville VARCHAR(255),
                    date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;
            ");

$wpdb->insert($table_name, [
    'nom' => $data['nom'],
    'email' => $data['email'],
    'adresse' => $data['adresse'],
    'ville' => $data['ville']
]);


// Nettoyer la session
unset($_SESSION['lmc_data']);

return '<p><strong>Merci !</strong> Votre formulaire a bien été envoyé.</p>';
?>