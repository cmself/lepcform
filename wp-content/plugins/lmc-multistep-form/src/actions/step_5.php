<?php

/*
 * Vérifier si le formulaire a bien été envoyé
 */
if(isset($_POST['step']) && $_POST['step'] == 5) {

    /*
    * Token CSRF
    */
    if (!isset($_POST['step5_csrf_token']) || $_POST['step5_csrf_token'] !== $_SESSION['lmc_data'][$id_session]['csrf_token']) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 5;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Jeton de validité du formulaires incorrect";
        lmc_multistep_form__logLmc("Jeton de validité du formulaires incorrect du STEP 5");
        die();
    }

    /*
     * Honey Pot pour piéger les robots
     */
    if (!empty($_POST['step5_honeypot'])) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 5;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Robot détecté";
        lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté) du STEP 5");
        die();
    }



/*
 * Enregistre les variables de session des étapes
 */

    if (isset($_POST['step5_paiement']) && !empty($_POST['step5_honeypot'])) {


        $_SESSION['lmc_data'][$id_session]['step5_paiement'] = isset($_POST['step5_paiement']) ? sanitize_textarea_field($_POST['step5_paiement']) : "";
        $_SESSION['lmc_data'][$id_session]['step5_bc'] = isset($_POST['step5_bc']) ? sanitize_textarea_field($_POST['step5_bc']) : "";
        $_SESSION['lmc_data'][$id_session]['step5_help'] = isset($_POST['step5_help']) ? sanitize_textarea_field($_POST['step5_help']) : "";
        $_SESSION['lmc_data'][$id_session]['step5_rgpd'] = isset($_POST['step5_rgpd']) ? sanitize_textarea_field($_POST['step5_rgpd']) : 0;


        /*
         * vérifier si les données existent en base de données
         */
        $step5_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT );

        if (count($step5_results) === 1) {

            /*
             * Enregistrement les données en base de données
             */
            $wpdb->update($table_name, [
                'step5_paiement' => $_SESSION['lmc_data'][$id_session]['step5_paiement'],
                'step5_bc' => $_SESSION['lmc_data'][$id_session]['step5_bc'],
                'step5_help' => $_SESSION['lmc_data'][$id_session]['step5_help'],
                'step5_rgpd' => $_SESSION['lmc_data'][$id_session]['step5_rgpd']
            ],
                ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);

                header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=6');

        }else{

            $_SESSION['lmc_data'][$id_session]['error_step'] = 5;
            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
            lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 5)");
            die();

        }

    }else{

        $errors['step5']['name'] = 'Choisissez votre méthode de paiement';
        $errors['step5']['texte'] = 'Veuillez sélectionner votre méthode de paiement';

    }

}

?>