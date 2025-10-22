<?php

use PHPMailer\PHPMailer\PHPMailer;


/*
 * Token CSRF
 */
if (!isset($_POST['step0_csrf_token']) || $_POST['step0_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 8;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    logLmc("Token CSRF invalide");
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step0_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 8;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    logLmc("Honey Pot rempli (robot détecté)");
}

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
                        $email = $client->request('GET', 'contacts', [
                            'query' => ['email' => $_SESSION['lmc_data']['step0_email'], 'limit' => 1]
                        ]);
                        $code_email = $email->getStatusCode();
                        if ($code_email != 200) {
                            $_SESSION['lmc_data']['error_step'] = 8;
                            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                            logLmc("Json OHME Contact invalide");
                        }
                        $data_email = json_decode($email->getBody(), true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $_SESSION['lmc_data']['contacts_email'] = $data_email['data'];
                        } else {
                            $_SESSION['lmc_data']['error_step'] = 8;
                            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                            logLmc("IMPOSSIBLE DE SE CONNECTER A OHME");
                        }
                    } catch (ClientException $e) {
                        $_SESSION['lmc_data']['error_step'] = 8;
                        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                        logLmc("API OHME Siren invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());
                    }

                    if(count($_SESSION['lmc_data']['contacts_email']) > 0) {
                        if( $_SESSION['lmc_data']['contacts_email'][0]['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite'] == '1 CHARTE CONTACT PRINCIPAL') {
                            if(isset($_SESSION['lmc_data']['contacts_email'][0]['structure_ohme_ids']) && !empty($_SESSION['lmc_data']['contacts_email'][0]['structure_ohme_ids'])) {

                                if(isset($_SESSION['lmc_data']['step0_siret']) && !empty($_SESSION['lmc_data']['step0_siret'])) {

                                    foreach ($_SESSION['lmc_data']['contacts_email'][0]['structure_ohme_ids'] as $ohme_ids) {

                                        try {
                                            $step0_structures = $client->request('GET', 'structures', [
                                                'query' => ['ohme_id' => $ohme_ids, 'siren' => $_SESSION['lmc_data']['step0_siret']]
                                            ]);
                                            $code_step0_structures = $step0_structures->getStatusCode();
                                            if ($code_step0_structures != 200) {
                                                $_SESSION['lmc_data']['error_step'] = 8;
                                                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                                logLmc("Json OHME Contact invalide");
                                            }

                                            $data_step0_structures = json_decode($step0_structures->getBody(), true);
                                            if (json_last_error() === JSON_ERROR_NONE) {
                                                if($data_step0_structures['count'] == 1) {
                                                    $_SESSION['lmc_data']['contacts_valide'] = true;
                                                    $_SESSION['lmc_data']['structures_ohme'] = $data_step0_structures['data'];
                                                    header('Location: ' . getCurrentUrlWithoutQuery() .'?reload_step=1');
                                                }
                                            } else {
                                                $_SESSION['lmc_data']['error_step'] = 8;
                                                $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                                logLmc("IMPOSSIBLE DE SE CONNECTER A OHME");
                                            }
                                        } catch (ClientException $e) {
                                            $_SESSION['lmc_data']['error_step'] = 8;
                                            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
                                            logLmc("API OHME Siren invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());
                                        }
                                    }

                                    $stepMAJ = 0;
                                    $step0_message = 'Le SIREN ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer un nouveau SIREN';


                                }else{
                                    $stepMAJ = 0;
                                    $step0_message = 'Le SIREN ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer un nouveau SIREN';
                                }

                            }else{
                                $stepMAJ = 0;
                                $step0_message = 'L’adresse ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer une nouvelle adresse';
                            }

                        }else{
                            $stepMAJ = 0;
                            $step0_message = 'L’adresse ne correspond pas au contact principal d’une structure enregistrée.<br>Veuillez entrer une nouvelle adresse';
                        }

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
    $_SESSION['lmc_data']['step0_siret'] = isset($_POST['step0_siret']) ? sanitize_text_field($_POST['step0_siret']) : "";

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
        $step0_message = 'Code envoyé par mail';

    } catch (Exception $e) {
        $_SESSION['lmc_data']['error_step'] = 8;
        $_SESSION['lmc_data']['$error_message'] = "Impossible d'envoyer le mail.";
        logLmc("IMPOSSIBLE D'ENVOYER LE MAIL :" . $mail->ErrorInfo);
    }

}

?>