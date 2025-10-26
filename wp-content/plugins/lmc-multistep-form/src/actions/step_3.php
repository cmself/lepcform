<?php

use PHPMailer\PHPMailer\PHPMailer;


/*
 * Vérifier si le formulaire a bien été envoyé
 */
if(isset($_POST['step']) && $_POST['step'] == 3) {

    /*
    * Token CSRF
    */
    if (!isset($_POST['step3_csrf_token']) || $_POST['step3_csrf_token'] !== $_SESSION['lmc_data'][$id_session]['csrf_token']) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 3;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Jeton de validité du formulaires incorrect";
        lmc_multistep_form__logLmc("Jeton de validité du formulaires incorrect du STEP 3");
        die();
    }

    /*
     * Honey Pot pour piéger les robots
     */
    if (!empty($_POST['step2_honeypot'])) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 3;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Robot détecté";
        lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté) du STEP 3");
        die();
    }



    if(isset($_POST['step3_resend']) && $_POST['step3_resend'] == 1) {

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

            $_SESSION['lmc_data'][$id_session]['error_step'] = 3;
            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible d'envoyer le mail.";
            lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL du STEP 2");
            die();

        }
    }else{

        /*
         * vérifier si les données existent en base de données
         */
        $step3_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT);

        if (count($step3_results) === 1) {

            if ($step3_results[0]->step3_otp_hash) {

                $now = new DateTime();
                $expiresAt = new DateTime($step3_results[0]->step3_otp_expires);
                if ($now > $expiresAt) {

                    $errors['step3']['name'] = 'Le code de vérification a expiré';
                    $errors['step3']['texte'] = 'Veuillez Renvoyer le code';

                } else {

                    $userOtp = $_POST['step3_pin1'] . $_POST['step3_pin2'] . $_POST['step3_pin3'] . $_POST['step3_pin4'] . $_POST['step3_pin5'];

                    if (!password_verify($userOtp, $step3_results[0]->step3_otp_hash)) {

                        $errors['step3']['name'] = 'Le code de vérification est invalide';
                        $errors['step3']['texte'] = 'Veuillez réessayer le code';

                    } else {

                        $wpdb->update($table_name, [
                            'step3_otp_used' => 1
                        ],
                            ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);

                        header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=4');

                    }

                }

            }else{

                $errors['step3']['name'] = 'Le code de vérification n\'a pas été créé';
                $errors['step3']['texte'] = 'Veuillez Renvoyer le code';

            }


        }else{

            $_SESSION['lmc_data'][$id_session]['error_step'] = 3;
            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
            lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 3)");
            die();
        }
    }

}




?>