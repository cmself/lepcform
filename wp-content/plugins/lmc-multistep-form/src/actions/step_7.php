<?php

// vérifier si existe
$step7_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

    $messageFin = "Votre demande d'adhésion a été prise en compte.";
    $wpdb->delete($table_name, ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);
    unset($_SESSION['lmc_data']);
    setcookie("lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST'], "", time() - 3600, "/");

}else{

    $_SESSION['lmc_data'][$id_session]['error_step'] = 6;
    $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
    lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 7)");
    die();

}


?>