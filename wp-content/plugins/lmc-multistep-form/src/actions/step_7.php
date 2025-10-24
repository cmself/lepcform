<?php

/*
 * Token CSRF
 */
if (!isset($_POST['step6_csrf_token']) || $_POST['step6_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    lmc_multistep_form__logLmc("Token CSRF invalide");
    die();
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step6_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté)");
    die();
}


/*
 * Vérification du mail
 */
if( $_SESSION['lmc_data']['step3_2fa'] != 1){
    $_SESSION['lmc_data']['error_step'] = 3;
    $_SESSION['lmc_data']['$error_message'] = "Votre Email n'est pas vérifié.";
    lmc_multistep_form__logLmc("step4 Votre Email n'est pas vérifié.)");
    die();
}

$messageFin = "Votre formulaire a déjà été envoyé.";
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