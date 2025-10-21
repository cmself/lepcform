<?php

use PHPMailer\PHPMailer\PHPMailer;

/*
 * Token CSRF
 */
if (!isset($_POST['step0_csrf_token']) || $_POST['step0_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step0_honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

$step0_message = '';


if(isset($_POST['step0_otp']) && !empty($_POST['step0_otp']) && $_POST['step0_otp'] == 1 ) {

    $stepMAJ = 1;

    /*
     * vérifier si les données existent en base de données
     */
    $step0_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT);

    if (count($step0_results) === 1) {

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

                    $stepMAJ = 2;

                    try {
                        $email = $client->get('https://api-ohme.oneheart.fr/api/v1/contacts?email=' . $_SESSION['lmc_data']['step0_email']);
                        $data_email = json_decode($email->getBody(), true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $_SESSION['lmc_data']['contacts_email'] = $data_email['data'];
                        } else {
                            $step0_message = 'Impossibble de vérifier l\'adresse email';
                            $_SESSION['lmc_data']['contacts_email'] = [];
                        }
                    } catch (ClientException $e) {
                        $step0_message = 'Impossibble de vérifier l\'adresse email';
                        $_SESSION['lmc_data']['contacts_email'] = [];
                    }

                    if(count($_SESSION['lmc_data']['contacts_email']) > 0) {
                        header('Location: ' . getCurrentUrlWithoutQuery() .'?reload_step=1');
                    }else{

                        $stepMAJ = 0;
                        $step0_message = 'L’adresse ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer une nouvelle adresse';

                    }

                }

            }

        }


    }

}else{

    $_SESSION['lmc_data']['step0_email'] = isset($_POST['step0_email']) ? sanitize_email($_POST['step0_email']) : "";

    /*
    * Envoyer le code de vérification par mail
    */
    $otp = generate_otp(5);
    $otpHash = password_hash($otp, PASSWORD_DEFAULT);
    $expiresMinutes = 10;
    $expiresAt = (new DateTime())->modify("+{$expiresMinutes} minutes")->format('Y-m-d H:i:s');

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
        $step0_message = 'Code renvoyé par mail';

    } catch (Exception $e) {
        error_log("Mailer error: " . $mail->ErrorInfo);
    }

}

?>