<?php
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