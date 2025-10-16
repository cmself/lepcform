<?php

// Token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    logLmc("Token CSRF invalide");
    die("Erreur : Requête invalide.");
}

// Honey Pot pour piéger les robots
if (!empty($_POST['honeypot'])) {
    logLmc("Honey Pot rempli (robot détecté)");
    die("Erreur : Robot détecté.");
}

// Test de rapidité d’envoi
if (isset($_POST['formStartTime'])) {
    $duration = time() - (int) ($_POST['formStartTime'] / 1000);
    if ($duration < 3) {
        logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}




if (!$row) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'No OTP found.']);
    exit;
}

// Check used flag
if ($row['used']) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'This code was already used.']);
    exit;
}

// Check expiry
$now = new DateTime();
$expiresAt = new DateTime($row['expires_at']);
if ($now > $expiresAt) {
    echo json_encode(['status'=>'error','message'=>'OTP expired.']);
    exit;
}

// Verify OTP - use password_verify (we used password_hash)
if (!password_verify($userOtp, $row['otp_hash'])) {
    // Optional: increment failed attempt counter (not shown) and enforce lockout after N tries
    http_response_code(401);
    echo json_encode(['status'=>'error','message'=>'Invalid code.']);
    exit;
}

// Mark OTP used
$update = $pdo->prepare("UPDATE user_otp SET used = 1 WHERE id = ?");
$update->execute([$row['id']]);

// Success: create final session / tokens for the user
// e.g., set $_SESSION['2fa_verified'] = true or issue JWT with 2fa claim
echo json_encode(['status'=>'ok','message'=>'2FA verified']);





?>