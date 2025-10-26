<?php

$messageFin = "Votre demande d'adhésion a été prise en compte.";
$data = $_SESSION['lmc_data'];
$data['confirmation'] = 'OK';


// vérifier si existe
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

    $wpdb->delete($table_name, ['cookie' => $_SESSION['lmc_data']['csrf_token']]);
    unset($_SESSION['lmc_data']);
    setcookie("lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST'], "", time() - 3600, "/");
    $messageFin = '<strong>Merci !</strong> Votre formulaire a bien été envoyé.';

}else{
    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Votre formulaire n\'a pas été envoyé.";
    lmc_multistep_form__logLmc("step4 Votre formulaire n\'a pas été envoyé.)");
    die();
}


?>