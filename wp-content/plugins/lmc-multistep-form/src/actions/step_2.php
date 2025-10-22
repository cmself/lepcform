<?php

/*
 * Token CSRF
 */
if (!isset($_POST['step1_csrf_token']) || $_POST['step1_csrf_token'] !== $_SESSION['lmc_data']['csrf_token']) {
    $_SESSION['lmc_data']['error_step'] = 2;
    $_SESSION['lmc_data']['$error_message'] = "Requête invalide.";
    lmc_multistep_form__logLmc("Token CSRF invalide");
    die();
}

/*
 * Honey Pot pour piéger les robots
 */
if (!empty($_POST['step1_honeypot'])) {
    $_SESSION['lmc_data']['error_step'] = 2;
    $_SESSION['lmc_data']['$error_message'] = "Robot détecté..";
    lmc_multistep_form__logLmc("Honey Pot rempli (robot détecté)");
    die();
}

/*
 * Test de rapidité d’envoi
 */
/*
if (isset($_POST['step1_formStartTime'])) {
    $duration = time() - (int) ($_POST['step1_formStartTime'] / 1000);
    if ($duration < 3) {
        lmc_multistep_form__logLmc("Envoi trop rapide ($duration s)");
        die("Erreur : Envoi trop rapide.");
    }
}
*/

/*
 * Enregistre les variables de session des étapes
 */
$_SESSION['lmc_data']['reload'] = 2;
$_SESSION['lmc_data']['step1_nom'] = isset($_POST['step1_nom']) ? sanitize_text_field($_POST['step1_nom']) : "";
$_SESSION['lmc_data']['step1_siret'] = isset($_POST['step1_siret']) ? sanitize_text_field($_POST['step1_siret']) : "";
$_SESSION['lmc_data']['step1_adherent'] = isset($_POST['step1_adherent']) ? sanitize_text_field($_POST['step1_adherent']) : "";



/*
 * Vérifier si la structures existe dans OHME
 */

if(isset($_SESSION['lmc_data']['step1_siret']) && !empty($_SESSION['lmc_data']['step1_siret'])) {

    try {

        $siren = $client->request('GET', 'structures', [
            'query' => ['siren' => $_SESSION['lmc_data']['step1_siret']]
        ]);
        $code_siren = $siren->getStatusCode();
        if ($code_siren != 200) {
            $_SESSION['lmc_data']['error_step'] = 1;
            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
            lmc_multistep_form__logLmc("Json OHME Contact invalide");
            die();
        }
        $data_siren = json_decode($siren->getBody(), true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $_SESSION['lmc_data']['structures_siren'] = $data_siren['data'];
        } else {
            $_SESSION['lmc_data']['error_step'] = 1;
            $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
            lmc_multistep_form__logLmc("IMPOSSIBLE DE SE CONNECTER A OHME");
            die();
        }
    } catch (ClientException $e) {
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        lmc_multistep_form__logLmc("API OHME Siren invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());
        die();
    }
}else{
    $_SESSION['lmc_data']['structures_siren'] = [];
    header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=1');
}


if(!isset($_SESSION['lmc_data']['contacts_valide']) || empty($_SESSION['lmc_data']['contacts_valide'])) {
    if(count($_SESSION['lmc_data']['structures_siren']) > 0) {
        header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=8');
    }
}else{

    if(count($_SESSION['lmc_data']['structures_siren']) > 0) {

        /*
         * Vérifier statut Adhésion à la Charte de l’Entreprise
         */
        if($_SESSION['lmc_data']['structures_siren'][0]['statut_adhesion_a_la_charte_de_lentreprise'] != 'Entreprise_non_candidate'){
            $_SESSION['lmc_data']['error_step'] = 1;
            $_SESSION['lmc_data']['$error_message'] = 'Il semble qu’une signature a déjà été effectuée pour cette entreprise.<br> <a href="' . lmc_multistep_form__getCurrentUrlWithoutQuery() . '?reload_step=8" class="text-[var(--color-blanc)]!">Veuillez effectuer un renouvellement</a>  ou <a href="#" class="text-[var(--color-blanc)]!">contactez LEPC</a>';
            lmc_multistep_form__logLmc("Signature a déjà été effectuée");
            die();
        }

        /*
         * Vérifier l’adhésion au réseau
         */
        if(isset($_SESSION['lmc_data']['step1_adherent']) || $_SESSION['lmc_data']['step1_adherent'] == 'Oui') {
            if($_SESSION['lmc_data']['structures_siren'][0]['entreprise_membre_adherente_du_reseau_des_entreprises_pour_la_cite'] != 'Oui'){
                $_SESSION['lmc_data']['error_step'] = 1;
                $_SESSION['lmc_data']['$error_message'] = 'Nous n’avons pas pu vérifier votre adhésion au Réseau des Entreprises pour la Cité,<br> veuillez <a href="' . lmc_multistep_form__getCurrentUrlWithoutQuery() . '?reload_step=1" class="text-[var(--color-blanc)]!">modifier votre répondre</a> ou <a href="#" class="text-[var(--color-blanc)]!">prendre contact avec LEPC</a>';
                lmc_multistep_form__logLmc("Nous n’avons pas pu vérifier votre adhésion au Réseau des Entreprises pour la Cité");
                die();
            }
        }


    }
}



/*
 * Enregistre le logo
 */
if (isset($_FILES['step1_logo']) && $_FILES['step1_logo']['error'] === UPLOAD_ERR_OK) {

    $fileTmpPath = $_FILES['step1_logo']['tmp_name'];
    $fileName = $_FILES['step1_logo']['name'];
    $fileSize = $_FILES['step1_logo']['size'];
    $fileType = $_FILES['step1_logo']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    $uploadFileDir = __DIR__ . '/uploads/';

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }
    $dest_path = $uploadFileDir . $newFileName;

    if(move_uploaded_file($fileTmpPath, $dest_path)) {
        $_SESSION['lmc_data']['step1_logo'] =  $newFileName;
    } else {
        $_SESSION['lmc_data']['step1_logo'] = isset($_POST['step1_logoH']) ? sanitize_text_field($_POST['step1_logoH']) : "";
    }

} else {
    $_SESSION['lmc_data']['step1_logo'] = isset($_POST['step1_logoH']) ? sanitize_text_field($_POST['step1_logoH']) : "";
}


$_SESSION['lmc_data']['step1_ca'] = isset($_POST['step1_ca']) ? sanitize_text_field($_POST['step1_ca']) : "";
$_SESSION['lmc_data']['step1_frais'] = isset($_POST['step1_frais']) ? sanitize_text_field($_POST['step1_frais']) : "";
$_SESSION['lmc_data']['step1_adresse'] = isset($_POST['step1_adresse']) ? sanitize_text_field($_POST['step1_adresse']) : "";
$_SESSION['lmc_data']['step1_ville'] = isset($_POST['step1_ville']) ? sanitize_text_field($_POST['step1_ville']) : "";
$_SESSION['lmc_data']['step1_cp'] = isset($_POST['step1_cp']) ? sanitize_text_field($_POST['step1_cp']) : "";
$_SESSION['lmc_data']['step1_email'] = isset($_POST['step1_email']) ? sanitize_email($_POST['step1_email']) : "";
$_SESSION['lmc_data']['step1_internet'] = isset($_POST['step1_internet']) ? sanitize_url($_POST['step1_internet']) : "";
$_SESSION['lmc_data']['step1_collaborateurs'] = isset($_POST['step1_collaborateurs']) ? sanitize_text_field($_POST['step1_collaborateurs']) : "";
$_SESSION['lmc_data']['step1_activite'] = isset($_POST['step1_activite']) ? sanitize_text_field($_POST['step1_activite']) : "";
$_SESSION['lmc_data']['step1_structure'] = isset($_POST['step1_structure']) ? sanitize_text_field($_POST['step1_structure']) : "";
$_SESSION['lmc_data']['step1_connaissance'] = isset($_POST['step1_connaissance']) ? sanitize_text_field($_POST['step1_connaissance']) : "";
$_SESSION['lmc_data']['step1_politique'] = isset($_POST['step1_politique']) ? sanitize_textarea_field($_POST['step1_politique']) : "";


/*
 * vérifier si les données existent en base de données
 */
$step1_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lmc_multistep_submissions WHERE cookie = '{$_SESSION['lmc_data']['csrf_token']}'", OBJECT );

if (count($step1_results) === 1) {

    /*
     * Enregistrement les données en base de données
     */
    $wpdb->update($table_name, [
        'step1_nom' => $_SESSION['lmc_data']['step1_nom'],
        'step1_siret' => $_SESSION['lmc_data']['step1_siret'],
        'step1_logo' => $_SESSION['lmc_data']['step1_logo'],
        'step1_ca' => $_SESSION['lmc_data']['step1_ca'],
        'step1_frais' => $_SESSION['lmc_data']['step1_frais'],
        'step1_adherent' => $_SESSION['lmc_data']['step1_adherent'],
        'step1_adresse' => $_SESSION['lmc_data']['step1_adresse'],
        'step1_ville' => $_SESSION['lmc_data']['step1_ville'],
        'step1_cp' => $_SESSION['lmc_data']['step1_cp'],
        'step1_email' => $_SESSION['lmc_data']['step1_email'],
        'step1_internet' => $_SESSION['lmc_data']['step1_internet'],
        'step1_collaborateurs' => $_SESSION['lmc_data']['step1_collaborateurs'],
        'step1_activite' => $_SESSION['lmc_data']['step1_activite'],
        'step1_structure' => $_SESSION['lmc_data']['step1_structure'],
        'step1_connaissance' => $_SESSION['lmc_data']['step1_connaissance'],
        'step1_politique' => $_SESSION['lmc_data']['step1_politique']
    ],
    ['cookie' => $_SESSION['lmc_data']['csrf_token']]);
}


?>