<?php

use PHPMailer\PHPMailer\PHPMailer;

// vérifier si existe
$step6_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data'][$id_session]['csrf_token']}'", OBJECT );

if (count($step6_results) === 1) {

    $mail = new PHPMailer(true);

    /*
     * Intégrer le email de notification administrateur
     */

    $message_admin = "Une nouvelle demande de signature de la Charte de la diversité a été soumise :<br><br>";
    $message_admin .= "Structure : " . $_SESSION['lmc_data'][$id_session]['step1_nom'] . "<br>";
    $message_admin .= "Contact principal : " . $_SESSION['lmc_data'][$id_session]['step2_prenom_0'] . " " . $_SESSION['lmc_data'][$id_session]['step2_nom_0'] . " " . $_SESSION['lmc_data'][$id_session]['step2_email_0'] . "<br><br>";
    $message_admin .= "Mode de paiement : " . $_SESSION['lmc_data'][$id_session]['step5_paiement'] . "<br>";

    if($_SESSION['lmc_data'][$id_session]['step5_paiement'] == 'FACTURE') {
        $message_admin .= "Numéro de bon de commande : " . $_SESSION['lmc_data'][$id_session]['step5_bc'];
    }
    if($_SESSION['lmc_data'][$id_session]['step5_paiement'] == 'AIDE') {
        $message_admin .= "Demande d’aide :<br>";
        $message_admin .= $_SESSION['lmc_data'][$id_session]['step5_help'];
    }


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
        $mail->addAddress(MailADMIN);

        $mail->Subject = 'Mail de notification à la validation du formulaire d\'adhésion Administrateur';
        $mail->Body = $message_admin;

        $mail->send();

    } catch (Exception $e) {

        $_SESSION['lmc_data'][$id_session]['error_step'] = 5;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible d'envoyer le mail.";
        lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL du STEP 6");
        die();

    }


    /*
     * Intégrer le email de notification contact principal
     */

    $message_contact_principal = "Une nouvelle demande de signature de la Charte de la diversité a été soumise :<br>";
    $message_contact_principal .= "Structure : " . $_SESSION['lmc_data'][$id_session]['step1_nom'] . "<br>";
    $message_contact_principal .= "Contact principal : " . $_SESSION['lmc_data'][$id_session]['step2_prenom_0'] . " " . $_SESSION['lmc_data'][$id_session]['step2_nom_0'] . " " . $_SESSION['lmc_data'][$id_session]['step2_email_0'] . "<br>";
    $message_contact_principal .= "Mode de paiement : " . $_SESSION['lmc_data'][$id_session]['step5_paiement'] . "<br><br>";

    if($_SESSION['lmc_data'][$id_session]['step5_paiement'] == 'FACTURE') {
        $message_contact_principal .= "Numéro de bon de commande : " . $_SESSION['lmc_data'][$id_session]['step5_bc'] . "<br><br>";
    }
    if($_SESSION['lmc_data'][$id_session]['step5_paiement'] == 'AIDE') {
        $message_contact_principal .= "Demande d’aide :<br><br>";
        $message_contact_principal .= $_SESSION['lmc_data'][$id_session]['step5_help'];
    }

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

        $mail->Subject = 'Mail de notification à la validation du formulaire d\'adhésion Contact principal';
        $mail->Body = $message_contact_principal;

        $mail->send();

    } catch (Exception $e) {

        $_SESSION['lmc_data'][$id_session]['error_step'] = 5;
        $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible d'envoyer le mail.";
        lmc_multistep_form__logLmc("IMPOSSIBLE D'ENVOYER LE MAIL du STEP 6");
        die();

    }


    $messageFin = "Votre demande d'adhésion a été prise en compte.";
    $wpdb->delete($table_name, ['cookie' => $_SESSION['lmc_data'][$id_session]['csrf_token']]);
    unset($_SESSION['lmc_data']);
    setcookie("lmc-multistep-form" . "_" . $_SERVER['HTTP_HOST'], "", time() - 3600, "/");
    sleep(10);
    header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=1');

}else{

    $_SESSION['lmc_data'][$id_session]['error_step'] = 5;
    $_SESSION['lmc_data'][$id_session]['$error_message'] = "Impossible de se connecter à la base de données.";
    lmc_multistep_form__logLmc("Impossible de se connecter à la base de données STEP 6)");
    die();

}
