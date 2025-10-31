<?php

use PHPMailer\PHPMailer\PHPMailer;


/*
 * Vérifier si le formulaire a bien été envoyé
 */
if(isset($_POST['step']) && $_POST['step'] == 8) {

    /*
     * Token CSRF
     */
    if (!isset($_POST['step8_csrf_token']) || $_POST['step8_csrf_token'] !== $_SESSION['lmc_data'][$id_session]['csrf_token']) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Jeton de validité du formulaires incorrect";
        lmc_multistep_form__logLmc("Jeton de validité du formulaires incorrect du STEP 8");
        die();
    }

    /*
     * Honey Pot pour piéger les robots
     */
    if (!empty($_POST['step8_honeypot'])) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Robot détecté";
        lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté) du STEP 8");
        die();
    }

        if (isset($_POST['step8_email']) && !empty($_POST['step8_email'])) {

            try {
                $email = $client_ohme->request('GET', 'contacts', [
                    'query' => ['email' => $_POST['step8_email'], 'role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite' => "1 CHARTE CONTACT PRINCIPAL"]
                ]);
                $code_email = $email->getStatusCode();
                if ($code_email != 200) {
                    $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                    $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                    lmc_multistep_form__logLmc("IMPOSSIBLE DE SE CONNECTER A OHME STEP 8");
                    die();
                }
                $data_email = json_decode($email->getBody(), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $ohme_contacts = $data_email['data'];
                } else {
                    $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                    $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                    lmc_multistep_form__logLmc("IMPOSSIBLE DE SE CONNECTER A OHME STEP 8");
                    die();
                }
            } catch (ClientException $e) {
                $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                lmc_multistep_form__logLmc('IMPOSSIBLE DE SE CONNECTER A OHME STEP 8');
                die();
            }

        } else {

            $errors['step8']['email'] = true;
            $errors['step8']['name'] = 'Le champ Email est obligatoire';
            $errors['step8']['texte'] = 'Vous devez renseigner le champ Email.';
        }


        if (count($ohme_contacts) > 0) {

            if (isset($ohme_contacts[0]['structure_ohme_ids']) && !empty($ohme_contacts[0]['structure_ohme_ids'])) {

                if (isset($_POST['step8_siret']) && !empty($_POST['step8_siret'])) {

                    foreach ($ohme_contacts[0]['structure_ohme_ids'] as $ohme_ids) {

                        try {
                            $step8_structures = $client_ohme->request('GET', 'structures', [
                                'query' => ['ohme_id' => $ohme_ids, 'siret' => $_POST['step8_siret']]
                            ]);
                            $code_step8_structures = $step8_structures->getStatusCode();
                            if ($code_step8_structures != 200) {
                                $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                                lmc_multistep_form__logLmc("IMPOSSIBLE DE SE CONNECTER A OHME STEP 8");
                                die();
                            }
                            $data_step8_structures = json_decode($step8_structures->getBody(), true);
                            if (json_last_error() === JSON_ERROR_NONE) {


                                if ($data_step8_structures['count'] == 1) {

                                    /*
                                     * vérifier si les données existent en base de données
                                     */
                                    $stepResign_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT);

                                    if (count($stepResign_results) == 1) {

                                        /*
                                         * Enregistrement les données en base de données
                                         */
                                        $wpdb->update($table_name, [

                                            'ohme_id' => $data_step8_structures['data'][0]['ohme_id'],
                                            'resign' => 1,
                                            'date_de_signature' => $data_step8_structures['data'][0]['date_de_signature_de_la_charte_de_la_diversite'],
                                            'step1_nom' => $data_step8_structures['data'][0]['name'],
                                            'step1_siret' => $data_step8_structures['data'][0]['siret'],
                                            'step1_logo' => $data_step8_structures['data'][0]['logo_de_la_structure'],
                                            'step1_ca' => $data_step8_structures['data'][0]['chiffre_daffaires'][0],
                                            'step1_frais' => $data_step8_structures['data'][0]['montant_des_frais_pour_la_charte_de_la_diversite'],
                                            'step1_adherent' => !empty($data_step8_structures['data'][0]['entreprise_membre_adherente_du_reseau_des_entreprises_pour_la_cite']) ? 1 : 0,
                                            'step1_adresse' => $data_step8_structures['data'][0]['address']['street'],
                                            'step1_ville' => $data_step8_structures['data'][0]['address']['city'],
                                            'step1_cp' => $data_step8_structures['data'][0]['address']['post_code'],
                                            'step1_email' => $data_step8_structures['data'][0]['email'],
                                            'step1_internet' => $data_step8_structures['data'][0]['site_internet'],
                                            'step1_collaborateurs' => $data_step8_structures['data'][0]['nombre_de_collaborateurs_en_france'],
                                            'step1_activite' => $data_step8_structures['data'][0]['secteur_dactivite'],
                                            'step1_structure' => $data_step8_structures['data'][0]['type_de_structure'],
                                            'step1_connaissance' => $data_step8_structures['data'][0]['comment_avez_vous_eu_connaissance_de_la_charte_de_la_diversite'],
                                            'step1_politique' => $data_step8_structures['data'][0]['presentation_de_votre_politique_diversite_et_des_raisons_de_votre_engagement'],
                                            'step4_engagement_1' => $data_step8_structures['data'][0]['engagement_1_sensibiliser_et_former_nos_dirigeants_et_managers'],
                                            'step4_engagement_2' => $data_step8_structures['data'][0]['engagement_2_promouvoir_lapplication_du_principe_de_non_discrimination'],
                                            'step4_engagement_3' => $data_step8_structures['data'][0]['engagement_3_favoriser_la_representation_de_la_diversite_de_la_societe_francaise'],
                                            'step4_engagement_4' => $data_step8_structures['data'][0]['engagement_4_communiquer_sur_notre_engagement'],
                                            'step4_engagement_5' => $data_step8_structures['data'][0]['engagement_5_faire_de_lelaboration_et_de_la_mise_en_oeuvre_de_la_politique_de_diversite_un_objet_de_dialogue_social_avec_les_representants_du_personnel'],
                                            'step4_engagement_6' => $data_step8_structures['data'][0]['engagement_6_evaluer_regulierement_les_progres_realises'],

                                            'step2_prenom_0' => $ohme_contacts[0]['firstname'],
                                            'step2_nom_0' => $ohme_contacts[0]['lastname'],
                                            'step2_fonction_0' => $ohme_contacts[0]['fonction_dans_lentreprise'],
                                            'step2_email_0' => $ohme_contacts[0]['email'],
                                            'step2_role_0' => '1 CHARTE CONTACT PRINCIPAL',
                                            'step2_signataire_0' => !empty($ohme_contacts[0]['signataire_de_la_charte_de_la_diversite']) ? 1 : 0

                                            //'step5_paiement' => $data_step0_structures['data']['ohme_id'],
                                            //'step5_bc' => $data_step0_structures['data']['ohme_id'],
                                            //'step5_help' => $data_step0_structures['data']['ohme_id'],
                                            //'step5_rgpd' => $data_step0_structures['data']['ohme_id']
                                        ],
                                            ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);

                                        try {
                                            $structure_fields_contact = $client_ohme->request('GET', 'contacts', [
                                                'query' => ['structure' => $data_step8_structures['data']['name'], 'role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite' => "2 AUTRE INTERLOCUTEUR CHARTE INTERLOCUTEUR", 'limit' => 3]
                                            ]);
                                            $code_structure_contact = $structure_fields_contact->getStatusCode();
                                            if ($code_structure_contact != 200) {
                                                $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                                $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                                                lmc_multistep_form__logLmc("IMPOSSIBLE DE SE CONNECTER A OHME STEP 8");
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
                                                        'step2_signataire_' . $c => !empty($structure_contact['signataire_de_la_charte_de_la_diversite']) ? 1 : 0
                                                    ],
                                                        ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);

                                                    $c++;
                                                }
                                            } else {
                                                $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                                $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                                                lmc_multistep_form__logLmc("IMPOSSIBLE DE SE CONNECTER A OHME STEP 8");
                                                die();
                                            }

                                        } catch (ClientException $e) {
                                            $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                                            lmc_multistep_form__logLmc('IMPOSSIBLE DE SE CONNECTER A OHME STEP 8');
                                            die();
                                        }

                                        $_SESSION['lmc_data'][$id_session]['step8_email'] = isset($_POST['step8_email']) ? sanitize_email($_POST['step8_email']) : "";
                                        $_SESSION['lmc_data'][$id_session]['step8_siret'] = isset($_POST['step8_siret']) ? sanitize_text_field($_POST['step8_siret']) : "";

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
                                        $step8_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT);

                                        if (count($step8_results) === 1) {

                                            $wpdb->update($table_name, [
                                                'step8_otp_hash' => $otpHash,
                                                'step8_otp_expires' => $expiresAt
                                            ],
                                                ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);


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
                                                $mail->addAddress($_SESSION['lmc_data'][$id_session]['step8_email']);

                                                $mail->Subject = 'Votre code de vérification';
                                                $mail->Body = "<p>Votre code de vérification est <strong>{$otp}</strong>. Il expire dans {$expiresMinutes} minutes.</p>";

                                                $mail->send();

                                                header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() . '?reload_step=9');

                                            } catch (Exception $e) {

                                                $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                                $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible d'envoyer le mail.";
                                                lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL du STEP 8");
                                                die();

                                            }

                                        }else{
                                            $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
                                            lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 8)");
                                            die();
                                        }

                                    } else {

                                        $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
                                        lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 8)");
                                        die();

                                    }
                                } else {
                                    $errors['step8']['name'] = 'Le SIRET ne correspond pas au contact principal d’une structure enregistrée.';
                                    $errors['step8']['texte'] = 'Veuillez entrer un nouveau SIRET';
                                }
                            } else {
                                $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                                $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                                lmc_multistep_form__logLmc("IMPOSSIBLE DE SE CONNECTER A OHME STEP 8");
                                die();
                            }
                        } catch (ClientException $e) {
                            $_SESSION['lmc_data'][$id_session]['error_step'] = 8;
                            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à OHME.";
                            lmc_multistep_form__logLmc('IMPOSSIBLE DE SE CONNECTER A OHME STEP 8');
                            die();
                        }
                    }


                } else {
                    $errors['step8']['name'] = 'Le SIRET ne correspond pas au contact principal d’une structure enregistrée.';
                    $errors['step8']['texte'] = 'Veuillez entrer un nouveau SIRET';
                }

            } else {
                $errors['step8']['name'] = 'L’adresse ne correspond pas au contact principal d’une structure enregistrée';
                $errors['step8']['texte'] = 'Veuillez entrer une nouvelle adresse';
            }


        } else {
            $errors['step8']['name'] = 'L’adresse ne correspond pas au contact principal d’une structure enregistrée';
            $errors['step8']['texte'] = 'Veuillez entrer une nouvelle adresse';

        }

}

?>