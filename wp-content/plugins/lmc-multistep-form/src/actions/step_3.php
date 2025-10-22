<?php

use PHPMailer\PHPMailer\PHPMailer;


/*
 * Token CSRF
 */
if (!isset($_POST['step2_csrf_token']) || $_POST['step2_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 3;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    lmc_multistep_form__logLmc("Token CSRF invalide");
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step2_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 3;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté)");
}

/*
 * Vérifier si le code par Mail est bon
 */
if(isset($_POST['step3_otp']) && !empty($_POST['step3_otp']) && $_POST['step3_otp'] == 1 ) {

    $_SESSION['lmc_data']['reload'] = 3;

    /*
     * vérifier si les données existent en base de données
     */
    $step3_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT);

    if (count($step3_results) === 1) {

        if ($step3_results[0]->step3_otp_hash) {

            $now = new DateTime();
            $expiresAt = new DateTime($step3_results[0]->step3_otp_expires);
            if ($now > $expiresAt) {

                $step3_otp = 'Code expiré';

            } else {

                $userOtp = $_POST['step3_pin1'] . $_POST['step3_pin2'] . $_POST['step3_pin3'] . $_POST['step3_pin4'] . $_POST['step3_pin5'];

                if (!password_verify($userOtp, $step3_results[0]->step3_otp_hash)) {

                    $step3_otp = 'Code invalide';

                } else {

                    $wpdb->update($table_name, [
                        'step3_otp_used' => 1
                    ],
                        ['cookie' => $_SESSION['lmc_data']['csrf_token']]);

                    $stepMAJ = 4;

                }

            }

        }

    }

/*
 * Renvoi du code par Mail
 */
}elseif(isset($_POST['step3_otp']) && !empty($_POST['step3_otp']) && $_POST['step3_otp'] == 2 ){

    $step2_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

    if (count($step2_results) === 1) {

        $wpdb->update($table_name, [
            'step3_otp_used' => 0
        ],
            ['cookie' => $_SESSION['lmc_data']['csrf_token']]);

        $otp = lmc_multistep_form__generate_otp(5);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiresMinutes = 10;
        $expiresAt = (new DateTime())->modify("+{$expiresMinutes} minutes")->format('Y-m-d H:i:s');

        $wpdb->update($table_name, [
            'step3_otp_hash' => $otpHash,
            'step3_otp_expires' => $expiresAt
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
            $mail->addAddress($_SESSION['lmc_data']['step2_email_0']);

            $mail->Subject = 'Votre code de vérification';
            $mail->Body = "<p>Votre code de vérification est <strong>{$otp}</strong>. Il expire dans {$expiresMinutes} minutes.</p>";

            $mail->send();

        } catch (Exception $e) {

            $_SESSION['lmc_data']['error_step'] = 3;
            $_SESSION['lmc_data']['$error_message'] = "Impossible d'envoyer le mail.";
            lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL :" . $mail->ErrorInfo);
        }


        $step3_otp = 'Code renvoyé par mail';

    }

/*
 * Enregistre les variables de session des étapes
 */
}else{

    /*
     * Enregistre les variables de session des étapes
     */
    $_SESSION['lmc_data']['step3_otp'] = '';
    $_SESSION['lmc_data']['step2_prenom_0'] = isset($_POST['step2_prenom_0']) ? sanitize_text_field($_POST['step2_prenom_0']) : "";
    $_SESSION['lmc_data']['step2_nom_0'] = isset($_POST['step2_nom_0']) ? sanitize_text_field($_POST['step2_nom_0']) : "";
    $_SESSION['lmc_data']['step2_fonction_0'] = isset($_POST['step2_fonction_0']) ? sanitize_text_field($_POST['step2_fonction_0']) : "";
    $_SESSION['lmc_data']['step2_email_0'] = isset($_POST['step2_email_0']) ? sanitize_email($_POST['step2_email_0']) : "";
    $_SESSION['lmc_data']['step2_role_0'] = isset($_POST['step2_role_0']) ? sanitize_text_field($_POST['step2_role_0']) : "";
    $_SESSION['lmc_data']['step2_signataire_0'] = isset($_POST['step2_signataire_0']) ? sanitize_text_field($_POST['step2_signataire_0']) : "";

    $_SESSION['lmc_data']['step2_prenom_1'] = isset($_POST['step2_prenom_1']) ? sanitize_text_field($_POST['step2_prenom_1']) : "";
    $_SESSION['lmc_data']['step2_nom_1'] = isset($_POST['step2_nom_1']) ? sanitize_text_field($_POST['step2_nom_1']) : "";
    $_SESSION['lmc_data']['step2_fonction_1'] = isset($_POST['step2_fonction_1']) ? sanitize_text_field($_POST['step2_fonction_1']) : "";
    $_SESSION['lmc_data']['step2_email_1'] = isset($_POST['step2_email_1']) ? sanitize_email($_POST['step2_email_1']) : "";
    $_SESSION['lmc_data']['step2_role_1'] = isset($_POST['step2_role_1']) ? sanitize_text_field($_POST['step2_role_1']) : "";
    $_SESSION['lmc_data']['step2_signataire_1'] = isset($_POST['step2_signataire_1']) ? sanitize_text_field($_POST['step2_signataire_1']) : "";

    $_SESSION['lmc_data']['step2_prenom_2'] = isset($_POST['step2_prenom_2']) ? sanitize_text_field($_POST['step2_prenom_2']) : "";
    $_SESSION['lmc_data']['step2_nom_2'] = isset($_POST['step2_nom_2']) ? sanitize_text_field($_POST['step2_nom_2']) : "";
    $_SESSION['lmc_data']['step2_fonction_2'] = isset($_POST['step2_fonction_2']) ? sanitize_text_field($_POST['step2_fonction_2']) : "";
    $_SESSION['lmc_data']['step2_email_2'] = isset($_POST['step2_email_2']) ? sanitize_email($_POST['step2_email_2']) : "";
    $_SESSION['lmc_data']['step2_role_2'] = isset($_POST['step2_role_2']) ? sanitize_text_field($_POST['step2_role_2']) : "";
    $_SESSION['lmc_data']['step2_signataire_2'] = isset($_POST['step2_signataire_2']) ? sanitize_text_field($_POST['step2_signataire_2']) : "";

    $_SESSION['lmc_data']['step2_prenom_3'] = isset($_POST['step2_prenom_3']) ? sanitize_text_field($_POST['step2_prenom_3']) : "";
    $_SESSION['lmc_data']['step2_nom_3'] = isset($_POST['step2_nom_3']) ? sanitize_text_field($_POST['step2_nom_3']) : "";
    $_SESSION['lmc_data']['step2_fonction_3'] = isset($_POST['step2_fonction_3']) ? sanitize_text_field($_POST['step2_fonction_3']) : "";
    $_SESSION['lmc_data']['step2_email_3'] = isset($_POST['step2_email_3']) ? sanitize_email($_POST['step2_email_3']) : "";
    $_SESSION['lmc_data']['step2_role_3'] = isset($_POST['step2_role_3']) ? sanitize_text_field($_POST['step2_role_3']) : "";
    $_SESSION['lmc_data']['step2_signataire_3'] = isset($_POST['step2_signataire_3']) ? sanitize_text_field($_POST['step2_signataire_3']) : "";



    /*
     * vérifier si les données existent en base de données
     */
    $step2_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

    if (count($step2_results) === 1) {

        /*
         * Enregistrement les données en base de données
         */
        $wpdb->update($table_name, [
            'step2_prenom_0' => $_SESSION['lmc_data']['step2_prenom_0'],
            'step2_nom_0' => $_SESSION['lmc_data']['step2_nom_0'],
            'step2_fonction_0' => $_SESSION['lmc_data']['step2_fonction_0'],
            'step2_email_0' => $_SESSION['lmc_data']['step2_email_0'],
            'step2_role_0' => $_SESSION['lmc_data']['step2_role_0'],
            'step2_signataire_0' => $_SESSION['lmc_data']['step2_signataire_0'],
            'step2_prenom_1' => $_SESSION['lmc_data']['step2_prenom_1'],
            'step2_nom_1' => $_SESSION['lmc_data']['step2_nom_1'],
            'step2_fonction_1' => $_SESSION['lmc_data']['step2_fonction_1'],
            'step2_email_1' => $_SESSION['lmc_data']['step2_email_1'],
            'step2_role_1' => $_SESSION['lmc_data']['step2_role_1'],
            'step2_signataire_1' => $_SESSION['lmc_data']['step2_signataire_1'],
            'step2_prenom_2' => $_SESSION['lmc_data']['step2_prenom_2'],
            'step2_nom_2' => $_SESSION['lmc_data']['step2_nom_2'],
            'step2_fonction_2' => $_SESSION['lmc_data']['step2_fonction_2'],
            'step2_email_2' => $_SESSION['lmc_data']['step2_email_2'],
            'step2_role_2' => $_SESSION['lmc_data']['step2_role_2'],
            'step2_signataire_2' => $_SESSION['lmc_data']['step2_signataire_2'],
            'step2_prenom_3' => $_SESSION['lmc_data']['step2_prenom_3'],
            'step2_nom_3' => $_SESSION['lmc_data']['step2_nom_3'],
            'step2_fonction_3' => $_SESSION['lmc_data']['step2_fonction_3'],
            'step2_email_3' => $_SESSION['lmc_data']['step2_email_3'],
            'step2_role_3' => $_SESSION['lmc_data']['step2_role_3'],
            'step2_signataire_3' => $_SESSION['lmc_data']['step2_signataire_3']
        ],
            ['cookie' => $_SESSION['lmc_data']['csrf_token']]);





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
            $mail->addAddress($_SESSION['lmc_data']['step2_email_0']);

            $mail->Subject = 'Votre code de vérification';
            $mail->Body = "<p>Votre code de vérification est <strong>{$otp}</strong>. Il expire dans {$expiresMinutes} minutes.</p>";

            $mail->send();

        } catch (Exception $e) {
            $_SESSION['lmc_data']['error_step'] = 3;
            $_SESSION['lmc_data']['$error_message'] = "Impossible d'envoyer le mail.";
            lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL :" . $mail->ErrorInfo);
        }

        $step3_otp = 'Code envoyé par mail';

    }
}

?>