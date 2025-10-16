<?php

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['step3_otp']) && !empty($_POST['step3_otp']) && $_POST['step3_otp'] == 1 ) {

    // Token CSRF
    if (!isset($_POST['step3_csrf_token']) || $_POST['step3_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
        logLmc("Token CSRF invalide");
        die("Erreur : Requête invalide.");
    }

    // Honey Pot pour piéger les robots
    if (!empty($_POST['step3_honeypot'])) {
        logLmc("Honey Pot rempli (robot détecté)");
        die("Erreur : Robot détecté.");
    }

    // Test de rapidité d’envoi
    if (isset($_POST['step3_formStartTime'])) {
        $duration = time() - (int)($_POST['step3_formStartTime'] / 1000);
        if ($duration < 3) {
            logLmc("Envoi trop rapide ($duration s)");
            die("Erreur : Envoi trop rapide.");
        }
    }


    $step3_results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_COOKIE["lmc-multistep-form"]}'", OBJECT);

    if (count($step3_results) === 1) {

        if ($step3_results[0]->step3_otp_hash) {

            $now = new DateTime();
            $expiresAt = new DateTime($step3_results[0]->step3_otp_expires);
            if ($now > $expiresAt) {

                $_SESSION['lmc_data']['step3_otp'] = 'Code expiré';

            } else {

                $userOtp = $_POST['step3_pin1'] . $_POST['step3_pin2'] . $_POST['step3_pin3'] . $_POST['step3_pin4'] . $_POST['step3_pin5'];

                if (!password_verify($userOtp, $step3_results[0]->step3_otp_hash)) {

                    $_SESSION['lmc_data']['step3_otp'] = 'Code invalide';

                } else {

                    $wpdb->update($table_name, [
                        'step3_otp_used' => 1
                    ],
                        ['cookie' => $_COOKIE["lmc-multistep-form"]]);

                    $_SESSION['lmc_data']['step3_otp'] = 'Code vérifié';


                    //allow_url_fopen doit être activé dans php.ini pour que file_get_contents() accède à des URLs distantes.
                    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                        $url = "https";
                    else
                        $url = "http";

                    $url .= "://";
                    $url .= $_SERVER['HTTP_HOST'];
                    $url .= $_SERVER['REQUEST_URI'];

                    $data = ['step' => '4', 'step3_csrf_token' => $_SESSION['lmc_data']['csrf_token']];
                    $json = json_encode($data);

                    $opts = [
                        'http' => [
                            'method'  => 'POST',
                            'header'  => "Content-Type: application/json\r\n" .
                                         "Content-Length: " . strlen($json) . "\r\n",
                            'content' => $json,
                            'timeout' => 10
                        ]
                    ];

                    $context = stream_context_create($opts);
                    $response = @file_get_contents($url, false, $context);

                    if ($response === false) {
                        $error = isset($http_response_header) ? implode("\n", $http_response_header) : 'Erreur inconnue';
                        echo "Requête échouée :\n" . $error;
                    }

                }

            }

        }

    }


}elseif(isset($_POST['step3_otp']) && !empty($_POST['step3_otp']) && $_POST['step3_otp'] == 2 ){

    // Token CSRF
    if (!isset($_POST['step3_csrf_token']) || $_POST['step3_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
        logLmc("Token CSRF invalide");
        die("Erreur : Requête invalide.");
    }

    // Honey Pot pour piéger les robots
    if (!empty($_POST['step3_honeypot'])) {
        logLmc("Honey Pot rempli (robot détecté)");
        die("Erreur : Robot détecté.");
    }

    // Test de rapidité d’envoi
    if (isset($_POST['step3_formStartTime'])) {
        $duration = time() - (int)($_POST['step3_formStartTime'] / 1000);
        if ($duration < 3) {
            logLmc("Envoi trop rapide ($duration s)");
            die("Erreur : Envoi trop rapide.");
        }
    }

    // vérifier si existe
    $step2_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_COOKIE["lmc-multistep-form"]}'", OBJECT );

    if (count($step2_results) === 1) {

        $wpdb->update($table_name, [
            'step3_otp_used' => 0
        ],
            ['cookie' => $_COOKIE["lmc-multistep-form"]]);

        $otp = generate_otp(5);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiresMinutes = 10;
        $expiresAt = (new DateTime())->modify("+{$expiresMinutes} minutes")->format('Y-m-d H:i:s');

        $wpdb->update($table_name, [
            'step3_otp_hash' => $otpHash,
            'step3_otp_expires' => $expiresAt
        ],
            ['cookie' => $_COOKIE["lmc-multistep-form"]]);


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
            error_log("Mailer error: " . $mail->ErrorInfo);
        }


        $_SESSION['lmc_data']['step3_otp'] = 'Code renvoyé par mail';

    }

}else{

    // Token CSRF
    if (!isset($_POST['step2_csrf_token']) || $_POST['step2_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
        logLmc("Token CSRF invalide");
        die("Erreur : Requête invalide.");
    }

    // Honey Pot pour piéger les robots
    if (!empty($_POST['step2_honeypot'])) {
        logLmc("Honey Pot rempli (robot détecté)");
        die("Erreur : Robot détecté.");
    }

    // Test de rapidité d’envoi
    if (isset($_POST['step2_formStartTime'])) {
        $duration = time() - (int) ($_POST['step2_formStartTime'] / 1000);
        if ($duration < 3) {
            logLmc("Envoi trop rapide ($duration s)");
            die("Erreur : Envoi trop rapide.");
        }
    }

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



    // vérifier si existe
    $step2_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_COOKIE["lmc-multistep-form"]}'", OBJECT );

    if (count($step2_results) === 1) {

        // Enregistrement les données en base de données
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
            ['cookie' => $_COOKIE["lmc-multistep-form"]]);






        $otp = generate_otp(5);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiresMinutes = 10;
        $expiresAt = (new DateTime())->modify("+{$expiresMinutes} minutes")->format('Y-m-d H:i:s');

        $wpdb->update($table_name, [
            'step3_otp_hash' => $otpHash,
            'step3_otp_expires' => $expiresAt
        ],
            ['cookie' => $_COOKIE["lmc-multistep-form"]]);


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
            error_log("Mailer error: " . $mail->ErrorInfo);
        }

    }
}

?>