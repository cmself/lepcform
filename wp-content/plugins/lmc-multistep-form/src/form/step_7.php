<?php

// vérifier si existe
$step7_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT );


if (count($step7_results) === 1) {

    $messageFin = "Votre demande d'adhésion a été prise en compte.";
    $wpdb->delete($table_name, ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);
    unset($_SESSION['lmc_data']);
    setcookie("lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST'], "", time() - 3600, "/");
    sleep(10);
    header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=1');

}else{

    $_SESSION['lmc_data'][$id_session]['error_step'] = 6;
    $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
    lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 7)");
    die();
}

?>


<div class="relative! w-full!">
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
</div>

<div class="w-full!" id="step_content">
    <h5 class="inline-block! w-full! text-center!"><?= isset($messageFin) ? $messageFin : "";  ?></h5>
</div>


