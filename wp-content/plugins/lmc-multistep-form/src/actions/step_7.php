<?php
/*
 * Token CSRF
 */
if (!isset($_POST['step6_csrf_token']) || $_POST['step6_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step6_honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

/*
 * Test de rapidité d’envoi
 */
if (isset($_POST['step6_formStartTime'])) {
    $duration = time() - (int) ($_POST['step6_formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}

$_SESSION['lmc_data']['reload'] = null;

$data = $_SESSION['lmc_data'];
$data['confirmation'] = 'OK';

// vérifier si existe
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

    $wpdb->delete($table_name, ['cookie' => $_SESSION['lmc_data']['csrf_token']]);
    unset($_SESSION['lmc_data']);
    setcookie("lmc-multistep-form", "", time() - 3600);
    $messageFin = '<strong>Merci !</strong> Votre formulaire a bien été envoyé.';

}else{
    $messageFin = '<strong>Erreur !</strong> Votre formulaire n\'a pas été envoyé.';
}





?>