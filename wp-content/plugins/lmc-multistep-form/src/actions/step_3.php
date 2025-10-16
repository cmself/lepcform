<?php

use PHPMailer\PHPMailer\PHPMailer;

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
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_COOKIE["lmc-multistep-form"]}'", OBJECT );

if (count($step1_results) === 1) {

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
        $mail->Host = 'mail.gandi.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'aurelien.boisselet@lmcfrance.com';
        $mail->Password = 'AB@lou221020';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@lmcfrance.com', 'LEPC CHARTE');
        $mail->addAddress('aurelien.boisselet@gmail.com');
        $mail->Subject = 'Votre code de vérification';
        $mail->isHTML(true);
        $mail->Body = "<p>Votre code de vérification est <strong>{$otp}</strong>. Il expire dans {$expiresMinutes} minutes.</p>";

        $mail->send();
        echo json_encode(['status'=>'ok','message'=>'OTP envoyé']);
    } catch (Exception $e) {
        error_log("Mailer error: " . $mail->ErrorInfo);
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>'Échec envoi OTP']);
    }

}


?>