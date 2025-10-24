<?php

use PHPMailer\PHPMailer\PHPMailer;

/*
 * Token CSRF
 */
if (!isset($_POST['step0_csrf_token']) || $_POST['step0_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 8;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    lmc_multistep_form__logLmc("step8 Token CSRF invalide");
    die();
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step0_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 8;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    lmc_multistep_form__logLmc("step8 Honey Pot rempli (robot détecté)");
    die();
}

if(isset($_POST['step0_otp']) && !empty($_POST['step0_otp']) && $_POST['step0_otp'] == 1 ) {

    $stepMAJ = 1;

    /*
     * vérifier si les données existent en base de données
     */
    $step0_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT);

    if (count($step0_results) == 1) {

        if ($step0_results[0]->step0_otp_hash) {


            $now = new DateTime();
            $expiresAt = new DateTime($step0_results[0]->step0_otp_expires);
            if ($now > $expiresAt) {
                $step0_message = 'Code expiré';
            } else {

                $userOtp = $_POST['step0_pin1'] . $_POST['step0_pin2'] . $_POST['step0_pin3'] . $_POST['step0_pin4'] . $_POST['step0_pin5'];

                if (!password_verify($userOtp, $step0_results[0]->step0_otp_hash)) {

                    $step0_message = 'Code invalide';

                } else {
                    $wpdb->update($table_name, [
                        'step0_otp_used' => 1
                    ],
                        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);

                    $step0_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT);

                }

            }

        }


        if (count($step0_results) == 1 && $step0_results[0]->step0_otp_used == 1) {

        $stepMAJ = 2;

        try {
            $email = $client->request('GET', 'contacts', [
                'query' => ['email' => $_SESSION['lmc_data']['step0_email'], 'role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite' => "1 CHARTE CONTACT PRINCIPAL"]
            ]);
            $code_email = $email->getStatusCode();
            if ($code_email != 200) {
                $_SESSION['lmc_data']['error_step'] = 8;
                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                lmc_multistep_form__logLmc("step8 Json OHME Contact invalide");
                die();
            }
            $data_email = json_decode($email->getBody(), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $_SESSION['lmc_data']['contacts_email'] = $data_email['data'];
            } else {
                $_SESSION['lmc_data']['error_step'] = 8;
                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                lmc_multistep_form__logLmc("step8 IMPOSSIBLE DE SE CONNECTER A OHME");
                die();
            }
        } catch (ClientException $e) {
            $_SESSION['lmc_data']['error_step'] = 8;
            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
            lmc_multistep_form__logLmc("step8 API OHME Siren invalide : " . $e->getResponse()->getStatusCode() . " = " . $e->getResponse()->getBody());
            die();
        }

        if (count($_SESSION['lmc_data']['contacts_email']) > 0) {
            if (isset($_SESSION['lmc_data']['contacts_email'][0]['structure_ohme_ids']) && !empty($_SESSION['lmc_data']['contacts_email'][0]['structure_ohme_ids'])) {

                if (isset($_SESSION['lmc_data']['step0_siret']) && !empty($_SESSION['lmc_data']['step0_siret'])) {
                    foreach ($_SESSION['lmc_data']['contacts_email'][0]['structure_ohme_ids'] as $ohme_ids) {

                        try {
                            $step0_structures = $client->request('GET', 'structures', [
                                'query' => ['ohme_id' => $ohme_ids, 'siret' => $_SESSION['lmc_data']['step0_siret']]
                            ]);
                            $code_step0_structures = $step0_structures->getStatusCode();
                            if ($code_step0_structures != 200) {
                                $_SESSION['lmc_data']['error_step'] = 8;
                                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                lmc_multistep_form__logLmc("step8 Json OHME Contact invalide");
                                die();
                            }
                            $data_step0_structures = json_decode($step0_structures->getBody(), true);
                            if (json_last_error() === JSON_ERROR_NONE) {
                                if ($data_step0_structures['count'] == 1) {
                                    /*
                                     * vérifier si les données existent en base de données
                                     */
                                    $stepResign_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT);

                                    if (count($stepResign_results) == 1) {


                                        /*
                                         * Enregistrement les données en base de données
                                         */
                                        $wpdb->update($table_name, [

                                            'ohme_id' => $data_step0_structures['data'][0]['ohme_id'],
                                            'resign' => 1,
                                            'date_de_signature' => $data_step0_structures['data'][0]['date_de_signature_de_la_charte_de_la_diversite'],
                                            'step1_nom' => $data_step0_structures['data'][0]['name'],
                                            'step1_siret' => $data_step0_structures['data'][0]['siret'],
                                            'step1_logo' => $data_step0_structures['data'][0]['logo_de_la_structure'],
                                            'step1_ca' => $data_step0_structures['data'][0]['chiffre_daffaires'][0],
                                            'step1_frais' => $data_step0_structures['data'][0]['montant_des_frais_pour_la_charte_de_la_diversite'],
                                            'step1_adherent' => !empty($data_step0_structures['data'][0]['entreprise_membre_adherente_du_reseau_des_entreprises_pour_la_cite']) ? 1 : 0,
                                            'step1_adresse' => $data_step0_structures['data'][0]['address']['street'],
                                            'step1_ville' => $data_step0_structures['data'][0]['address']['city'],
                                            'step1_cp' => $data_step0_structures['data'][0]['address']['post_code'],
                                            'step1_email' => $data_step0_structures['data'][0]['email'],
                                            'step1_internet' => $data_step0_structures['data'][0]['site_internet'],
                                            'step1_collaborateurs' => $data_step0_structures['data'][0]['nombre_de_collaborateurs_en_france'],
                                            'step1_activite' => $data_step0_structures['data'][0]['secteur_dactivite'],
                                            'step1_structure' => $data_step0_structures['data'][0]['type_de_structure'],
                                            'step1_connaissance' => $data_step0_structures['data'][0]['comment_avez_vous_eu_connaissance_de_la_charte_de_la_diversite'],
                                            'step1_politique' => $data_step0_structures['data'][0]['presentation_de_votre_politique_diversite_et_des_raisons_de_votre_engagement'],
                                            'step4_engagement_1' => $data_step0_structures['data'][0]['engagement_1_sensibiliser_et_former_nos_dirigeants_et_managers'],
                                            'step4_engagement_2' => $data_step0_structures['data'][0]['engagement_2_promouvoir_lapplication_du_principe_de_non_discrimination'],
                                            'step4_engagement_3' => $data_step0_structures['data'][0]['engagement_3_favoriser_la_representation_de_la_diversite_de_la_societe_francaise'],
                                            'step4_engagement_4' => $data_step0_structures['data'][0]['engagement_4_communiquer_sur_notre_engagement'],
                                            'step4_engagement_5' => $data_step0_structures['data'][0]['engagement_5_faire_de_lelaboration_et_de_la_mise_en_oeuvre_de_la_politique_de_diversite_un_objet_de_dialogue_social_avec_les_representants_du_personnel'],
                                            'step4_engagement_6' => $data_step0_structures['data'][0]['engagement_6_evaluer_regulierement_les_progres_realises'],

                                            'step2_prenom_0' => $_SESSION['lmc_data']['contacts_email'][0]['firstname'],
                                            'step2_nom_0' => $_SESSION['lmc_data']['contacts_email'][0]['lastname'],
                                            'step2_fonction_0' => $_SESSION['lmc_data']['contacts_email'][0]['fonction_dans_lentreprise'],
                                            'step2_email_0' => $_SESSION['lmc_data']['contacts_email'][0]['email'],
                                            'step2_role_0' => '1 CHARTE CONTACT PRINCIPAL',
                                            'step2_signataire_0' => !empty($_SESSION['lmc_data']['contacts_email'][0]['signataire_de_la_charte_de_la_diversite']) ? 1 : 0

                                            //'step5_paiement' => $data_step0_structures['data']['ohme_id'],
                                            //'step5_bc' => $data_step0_structures['data']['ohme_id'],
                                            //'step5_help' => $data_step0_structures['data']['ohme_id'],
                                            //'step5_rgpd' => $data_step0_structures['data']['ohme_id']
                                        ],
                                            ['cookie' => $_SESSION['lmc_data']['csrf_token']]);


                                        try {
                                            $structure_fields_contact = $client->request('GET', 'contacts', [
                                                'query' => ['structure' => $data_step0_structures['data']['name'], 'role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite' => "2 AUTRE INTERLOCUTEUR CHARTE INTERLOCUTEUR", 'limit' => 3]
                                            ]);
                                            $code_structure_contact = $structure_fields_contact->getStatusCode();
                                            if ($code_structure_contact != 200) {
                                                $_SESSION['lmc_data']['error_step'] = 8;
                                                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                                lmc_multistep_form__logLmc("step8 Json OHME Contact invalide");
                                                die();
                                            }
                                            $data_structure_contact = json_decode($structure_fields_contact->getBody(), true);
                                            if (json_last_error() === JSON_ERROR_NONE) {

                                                $c = 1;
                                                foreach ($data_structure_contact['data'] as $structure_contact) {

                                                    $wpdb->update($table_name, [
                                                        'step2_prenom_' . $c => $structure_contact['firstname'],
                                                        'step2_nom_' . $c => $structure_contact['lastname'],
                                                        'step2_fonction_' . $c => $structure_contact['fonction_dans_lentreprise'],
                                                        'step2_email_' . $c => $structure_contact['email'],
                                                        'step2_role_' . $c => '2 AUTRE INTERLOCUTEUR CHARTE INTERLOCUTEUR',
                                                        'step2_signataire_' . $c =>!empty($structure_contact['signataire_de_la_charte_de_la_diversite']) ? 1 : 0
                                                    ],
                                                        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);

                                                    $c++;
                                                }
                                            } else {
                                                $_SESSION['lmc_data']['error_step'] = 8;
                                                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                                lmc_multistep_form__logLmc("step8 IMPOSSIBLE DE SE CONNECTER A OHME");
                                                die();
                                            }

                                        } catch (ClientException $e) {

                                            $_SESSION['lmc_data']['error_step'] = 8;
                                            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                            lmc_multistep_form__logLmc("step8 API OHME Siren invalide : " . $e->getResponse()->getStatusCode() . " = " . $e->getResponse()->getBody());
                                            die();
                                        }

                                        header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() . '?reload_step=1');

                                    } else {

                                        $_SESSION['lmc_data']['error_step'] = 8;
                                        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à la base de données.";
                                        lmc_multistep_form__logLmc("step8 IMPOSSIBLE DE SE CONNECTER A BASE DE DONNEES");
                                        die();

                                    }
                                } else {

                                    $stepMAJ = 0;
                                    $step0_message = 'Le SIRET ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer un nouveau SIRET';
                                }
                            } else {
                                $_SESSION['lmc_data']['error_step'] = 8;
                                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                lmc_multistep_form__logLmc("step8 IMPOSSIBLE DE SE CONNECTER A OHME");
                                die();
                            }
                        } catch (ClientException $e) {
                            $_SESSION['lmc_data']['error_step'] = 8;
                            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                            lmc_multistep_form__logLmc("step8 API OHME Siren invalide : " . $e->getResponse()->getStatusCode() . " = " . $e->getResponse()->getBody());
                            die();
                        }
                    }

                    $stepMAJ = 0;
                    $step0_message = 'Le SIRET ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer un nouveau SIRET';


                } else {

                    $stepMAJ = 0;
                    $step0_message = 'Le SIRET ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer un nouveau SIRET';
                }

            } else {

                $stepMAJ = 0;
                $step0_message = 'L’adresse ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer une nouvelle adresse';
            }


        } else {


            $stepMAJ = 0;
            $step0_message = 'L’adresse ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer une nouvelle adresse';

        }


        }else{
            $_SESSION['lmc_data']['error_step'] = 8;
            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à la base de données.";
            lmc_multistep_form__logLmc("step8 Impossible de se connecter à la base de données.)");
            die();
         }

    }else{
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à la base de données.";
        lmc_multistep_form__logLmc("step8 Impossible de se connecter à la base de données.)");
        die();
    }


}else{

    $_SESSION['lmc_data']['step0_email'] = isset($_POST['step0_email']) ? sanitize_email($_POST['step0_email']) : "";
    $_SESSION['lmc_data']['step0_siret'] = isset($_POST['step0_siret']) ? sanitize_text_field($_POST['step0_siret']) : "";

    /*
    * Envoyer le code de vérification par mail
    */
    $otp = lmc_multistep_form__generate_otp(5);
    $otpHash = password_hash($otp, PASSWORD_DEFAULT);
    $expiresMinutes = 10;
    $expiresAt = (new DateTime())->modify("+{$expiresMinutes} minutes")->format('Y-m-d H:i:s');


    /*
     * vérifier si les données existent en base de données
     */
    $step0_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT);

    if (count($step0_results) === 1) {

    $wpdb->update($table_name, [
        'step0_otp_hash' => $otpHash,
        'step0_otp_expires' => $expiresAt
    ],
        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host =  MailHOST;
        $mail->SMTPAuth = true;
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);

        $mail->Username = MailUSER;
        $mail->Password = MailPWD;

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 587;

        // pour local à sup en prod
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->setFrom(MailSENDER);
        $mail->addAddress($_SESSION['lmc_data']['step0_email']);

        $mail->Subject = 'Votre code de vérification';
        $mail->Body = "<p>Votre code de vérification est <strong>{$otp}</strong>. Il expire dans {$expiresMinutes} minutes.</p>";

        $mail->send();
        $stepMAJ = 1;
        $step0_message = 'Code envoyé par mail';

    } catch (Exception $e) {
        $_SESSION['lmc_data']['error_step'] = 8;
        $_SESSION['lmc_data']['$error_message'] = "Impossible d'envoyer le mail.";
        lmc_multistep_form__logLmc("step8 IMPOSSIBLE D'ENVOYER LE MAIL :" . $mail->ErrorInfo);
        die();
    }

    }else{
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à la base de données.";
        lmc_multistep_form__logLmc("step8 Impossible de se connecter à la base de données.)");
        die();
    }

}

?>