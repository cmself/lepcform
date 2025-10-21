
<?php

/*
 * Token CSRF
 */
if (!isset($_POST['step3_csrf_token']) || $_POST['step3_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
logLmc("Token CSRF invalide");
die("Erreur : Requête invalide.");
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step3_honeypot'])) {
logLmc("Honey Pot rempli (robot détecté)");
die("Erreur : Robot détecté.");
}

/*
 * Test de rapidité d’envoi
 */
/*
if (isset($_POST['step1_formStartTime'])) {
    $duration = time() - (int) ($_POST['step1_formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}
*/

$_SESSION['lmc_data']['reload'] = 4;


/*
 * vérifier si les données existent en base de données
 */
$step3_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step3_results) === 1) {
    $_SESSION['lmc_data']['step3_2fa'] = $step3_results[0]->step3_otp_used;
}

?>