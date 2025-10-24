
<?php

/*
 * Token CSRF
 */
if (!isset($_POST['step3_csrf_token']) || $_POST['step3_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 4;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    lmc_multistep_form__logLmc("step4 Token CSRF invalide");
    die();
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step3_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 4;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    lmc_multistep_form__logLmc("step4 Honey Pot rempli (robot détecté)");
    die();
}



$_SESSION['lmc_data']['reload'] = 4;


/*
 * vérifier si les données existent en base de données
 */
$step3_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step3_results) === 1) {
    $_SESSION['lmc_data']['step3_2fa'] = $step3_results[0]->step3_otp_used;
}else{
    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à la base de données.";
    lmc_multistep_form__logLmc("step4 Impossible de se connecter à la base de données.)");
    die();
}

if( $_SESSION['lmc_data']['step3_2fa'] != 1){
    $_SESSION['lmc_data']['error_step'] = 3;
    $_SESSION['lmc_data']['$error_message'] = "Votre Email n'est pas vérifié.";
    lmc_multistep_form__logLmc("step4 Votre Email n'est pas vérifié.)");
    die();
}

?>