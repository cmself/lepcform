<?php

/*
 * Vérifier si le formulaire a bien été envoyé
 */
if(isset($_POST['step']) && $_POST['step'] == 6) {

    /*
    * Token CSRF
    */
    if (!isset($_POST['step6_csrf_token']) || $_POST['step6_csrf_token'] !== $_SESSION['lmc_data'][$id_session]['csrf_token']) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 6;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Jeton de validité du formulaires incorrect";
        lmc_multistep_form__logLmc("Jeton de validité du formulaires incorrect du STEP 6");
        die();
    }

    /*
     * Honey Pot pour piéger les robots
     */
    if (!empty($_POST['step6_honeypot'])) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 6;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Robot détecté";
        lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté) du STEP 6");
        die();
    }

    header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=7');

}

?>