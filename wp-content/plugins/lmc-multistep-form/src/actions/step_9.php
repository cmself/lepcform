<?php


use PHPMailer\PHPMailer\PHPMailer;


/*
 * Vérifier si le formulaire a bien été envoyé
 */
if(isset($_POST['step']) && $_POST['step'] == 9) {

    /*
    * Token CSRF
    */
    if (!isset($_POST['step9_csrf_token']) || $_POST['step9_csrf_token'] !== $_SESSION['lmc_data'][$id_session]['csrf_token']) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 9;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Jeton de validité du formulaires incorrect";
        lmc_multistep_form__logLmc("Jeton de validité du formulaires incorrect du STEP 9");
        die();
    }

    /*
     * Honey Pot pour piéger les robots
     */
    if (!empty($_POST['step9_honeypot'])) {
        $_SESSION['lmc_data'][$id_session]['error_step'] = 3;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Robot détecté";
        lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté) du STEP 9");
        die();
    }



    if(isset($_POST['step9_resend']) && $_POST['step9_resend'] == 1) {

        /*
         * Envoyer le code de vérification par mail
         */

        $otp = lmc_multistep_form__generate_otp(5);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiresMinutes = 10;
        $expiresAt = (new DateTime())->modify("+{$expiresMinutes} minutes")->format('Y-m-d H:i:s');

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

            header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=9');

        } catch (Exception $e) {

            $_SESSION['lmc_data'][$id_session]['error_step'] = 9;
            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible d'envoyer le mail.";
            lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL du STEP 9");
            die();

        }
    }else{

        /*
         * vérifier si les données existent en base de données
         */
        $step9_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT);

        if (count($step9_results) === 1) {

            if ($step9_results[0]->step8_otp_hash) {

                $now = new DateTime();
                $expiresAt = new DateTime($step9_results[0]->step8_otp_expires);
                if ($now > $expiresAt) {

                    $errors['step9']['name'] = 'Le code de vérification a expiré';
                    $errors['step9']['texte'] = 'Veuillez Renvoyer le code';

                } else {

                    $userOtp = $_POST['step9_pin1'] . $_POST['step9_pin2'] . $_POST['step9_pin3'] . $_POST['step9_pin4'] . $_POST['step9_pin5'];

                    if (!password_verify($userOtp, $step9_results[0]->step8_otp_hash)) {

                        $errors['step9']['name'] = 'Le code de vérification est invalide';
                        $errors['step9']['texte'] = 'Veuillez réessayer le code';

                    } else {

                        $wpdb->update($table_name, [
                            'step8_otp_used' => 1
                        ],
                            ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);

                        header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=1');

                    }

                }

            }else{

                $errors['step9']['name'] = 'Le code de vérification n\'a pas été créé';
                $errors['step9']['texte'] = 'Veuillez Renvoyer le code';

            }


        }else{

            $_SESSION['lmc_data'][$id_session]['error_step'] = 9;
            $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
            lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 9)");
            die();
        }
    }

}




?>