
<?php

/*

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
*/

?>