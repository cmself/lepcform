<?php

use PHPMailer\PHPMailer\PHPMailer;

/*
 * Vérifier si le formulaire a bien été envoyé
 */
if(isset($_POST['step']) && $_POST['step'] == 2) {

    /*
    * Token CSRF
    */
    if (!isset($_POST['step2_csrf_token']) || $_POST['step2_csrf_token'] !== $_SESSION['lmc_data'][$id_session]['csrf_token']) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 2;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Jeton de validité du formulaires incorrect";
        lmc_multistep_form__logLmc("Jeton de validité du formulaires incorrect du STEP 2");
        die();
    }

    /*
     * Honey Pot pour piéger les robots
     */
    if (!empty($_POST['step2_honeypot'])) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 2;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Robot détecté";
        lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté) du STEP 2");
        die();
    }


    /*
     * Enregistre les variables de session des étapes
     */
        $_SESSION['lmc_data'][$id_session]['step2_prenom_0'] = isset($_POST['step2_prenom_0']) ? sanitize_text_field($_POST['step2_prenom_0']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_nom_0'] = isset($_POST['step2_nom_0']) ? sanitize_text_field($_POST['step2_nom_0']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_fonction_0'] = isset($_POST['step2_fonction_0']) ? sanitize_text_field($_POST['step2_fonction_0']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_email_0'] = isset($_POST['step2_email_0']) ? sanitize_email($_POST['step2_email_0']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_role_0'] = isset($_POST['step2_role_0']) ? sanitize_text_field($_POST['step2_role_0']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_signataire_0'] = isset($_POST['step2_signataire_0']) ? sanitize_text_field($_POST['step2_signataire_0']) : 0;

        $_SESSION['lmc_data'][$id_session]['step2_prenom_1'] = isset($_POST['step2_prenom_1']) ? sanitize_text_field($_POST['step2_prenom_1']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_nom_1'] = isset($_POST['step2_nom_1']) ? sanitize_text_field($_POST['step2_nom_1']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_fonction_1'] = isset($_POST['step2_fonction_1']) ? sanitize_text_field($_POST['step2_fonction_1']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_email_1'] = isset($_POST['step2_email_1']) ? sanitize_email($_POST['step2_email_1']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_role_1'] = isset($_POST['step2_role_1']) ? sanitize_text_field($_POST['step2_role_1']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_signataire_1'] = isset($_POST['step2_signataire_1']) ? sanitize_text_field($_POST['step2_signataire_1']) : 0;

        $_SESSION['lmc_data'][$id_session]['step2_prenom_2'] = isset($_POST['step2_prenom_2']) ? sanitize_text_field($_POST['step2_prenom_2']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_nom_2'] = isset($_POST['step2_nom_2']) ? sanitize_text_field($_POST['step2_nom_2']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_fonction_2'] = isset($_POST['step2_fonction_2']) ? sanitize_text_field($_POST['step2_fonction_2']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_email_2'] = isset($_POST['step2_email_2']) ? sanitize_email($_POST['step2_email_2']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_role_2'] = isset($_POST['step2_role_2']) ? sanitize_text_field($_POST['step2_role_2']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_signataire_2'] = isset($_POST['step2_signataire_2']) ? sanitize_text_field($_POST['step2_signataire_2']) : 0;

        $_SESSION['lmc_data'][$id_session]['step2_prenom_3'] = isset($_POST['step2_prenom_3']) ? sanitize_text_field($_POST['step2_prenom_3']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_nom_3'] = isset($_POST['step2_nom_3']) ? sanitize_text_field($_POST['step2_nom_3']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_fonction_3'] = isset($_POST['step2_fonction_3']) ? sanitize_text_field($_POST['step2_fonction_3']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_email_3'] = isset($_POST['step2_email_3']) ? sanitize_email($_POST['step2_email_3']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_role_3'] = isset($_POST['step2_role_3']) ? sanitize_text_field($_POST['step2_role_3']) : "";
        $_SESSION['lmc_data'][$id_session]['step2_signataire_3'] = isset($_POST['step2_signataire_3']) ? sanitize_text_field($_POST['step2_signataire_3']) : 0;

        /*
         * vérifier si les données existent en base de données
         */
        $step2_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT );

        if (count($step2_results) === 1) {

            /*
             * Enregistrement les données en base de données
             */
            $wpdb->update($table_name, [
                'step2_prenom_0' => $_SESSION['lmc_data'][$id_session]['step2_prenom_0'],
                'step2_nom_0' => $_SESSION['lmc_data'][$id_session]['step2_nom_0'],
                'step2_fonction_0' => $_SESSION['lmc_data'][$id_session]['step2_fonction_0'],
                'step2_email_0' => $_SESSION['lmc_data'][$id_session]['step2_email_0'],
                'step2_role_0' => $_SESSION['lmc_data'][$id_session]['step2_role_0'],
                'step2_signataire_0' => $_SESSION['lmc_data'][$id_session]['step2_signataire_0'],
                'step2_prenom_1' => $_SESSION['lmc_data'][$id_session]['step2_prenom_1'],
                'step2_nom_1' => $_SESSION['lmc_data'][$id_session]['step2_nom_1'],
                'step2_fonction_1' => $_SESSION['lmc_data'][$id_session]['step2_fonction_1'],
                'step2_email_1' => $_SESSION['lmc_data'][$id_session]['step2_email_1'],
                'step2_role_1' => $_SESSION['lmc_data'][$id_session]['step2_role_1'],
                'step2_signataire_1' => $_SESSION['lmc_data'][$id_session]['step2_signataire_1'],
                'step2_prenom_2' => $_SESSION['lmc_data'][$id_session]['step2_prenom_2'],
                'step2_nom_2' => $_SESSION['lmc_data'][$id_session]['step2_nom_2'],
                'step2_fonction_2' => $_SESSION['lmc_data'][$id_session]['step2_fonction_2'],
                'step2_email_2' => $_SESSION['lmc_data'][$id_session]['step2_email_2'],
                'step2_role_2' => $_SESSION['lmc_data'][$id_session]['step2_role_2'],
                'step2_signataire_2' => $_SESSION['lmc_data'][$id_session]['step2_signataire_2'],
                'step2_prenom_3' => $_SESSION['lmc_data'][$id_session]['step2_prenom_3'],
                'step2_nom_3' => $_SESSION['lmc_data'][$id_session]['step2_nom_3'],
                'step2_fonction_3' => $_SESSION['lmc_data'][$id_session]['step2_fonction_3'],
                'step2_email_3' => $_SESSION['lmc_data'][$id_session]['step2_email_3'],
                'step2_role_3' => $_SESSION['lmc_data'][$id_session]['step2_role_3'],
                'step2_signataire_3' => $_SESSION['lmc_data'][$id_session]['step2_signataire_3']
            ],
                ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);


            if(empty($_SESSION['lmc_data'][$id_session]['step2_signataire_0']) && empty($_SESSION['lmc_data'][$id_session]['step2_signataire_1']) && empty($_SESSION['lmc_data'][$id_session]['step2_signataire_2']) && empty($_SESSION['lmc_data'][$id_session]['step2_signataire_3']) ){

                $errors['step2']['name'] = 'Le champ Contact signataire est obligatoire';
                $errors['step2']['texte'] = 'Vous devez sélectionner au moins un contact signataire.';

            }else{

                /*
                 * Envoyer le code de vérification par mail
                 */
                $otp = lmc_multistep_form__generate_otp(5);
                $otpHash = password_hash($otp, PASSWORD_DEFAULT);
                $expiresMinutes = 10;
                $expiresAt = (new DateTime())->modify("+{$expiresMinutes} minutes")->format('Y-m-d H:i:s');

                $wpdb->update($table_name, [
                    'step3_otp_hash' => $otpHash,
                    'step3_otp_expires' => $expiresAt
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
                    $mail->addAddress($_SESSION['lmc_data'][$id_session]['step2_email_0']);

                    $mail->Subject = 'Votre code de vérification';
                    $mail->Body = "<p>Votre code de vérification est <strong>{$otp}</strong>. Il expire dans {$expiresMinutes} minutes.</p>";

                    $mail->send();

                    header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=3');

                } catch (Exception $e) {

                    $_SESSION['lmc_data'][$id_session]['error_step'] = 2;
                    $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible d'envoyer le mail.";
                    lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL du STEP 2");
                    die();

                }

            }

        }else{

            $_SESSION['lmc_data'][$id_session]['error_step'] = 2;
            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
            lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 2)");
            die();
        }

    }


?>