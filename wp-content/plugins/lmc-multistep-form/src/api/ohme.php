<?php

/*
 * Récupérer les champs personnalisés Contact
 */
$opt_ohme = [];

try {
    $custom_fields_contact = $client->request('GET', 'custom-fields', [
        'query' => ['model' => 'Contact']
    ]);
    $code_contact = $custom_fields_contact->getStatusCode();
    if ($code_contact != 200) {
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Contact invalide");
    }
    $data_contact = json_decode($custom_fields_contact->getBody(), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $options_contact = $data_contact['data'];
        foreach ($options_contact as $option_contact) {
            if (!empty($option_contact['options'])) {
                $opt_ohme['Contact'][$option_contact['name']]['label'] = $option_contact['label'];
                $opt = 0;
                foreach ($option_contact['options'] as $value_contact) {
                    $opt_ohme['Contact'][$option_contact['name']]['options'][$opt] = $value_contact;
                    $opt ++;
                }
            }
        }
    }else{
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Contact invalide");
    }

} catch (ClientException $e) {

    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
    logLmc("API OHME Contact invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());

}

/*
 *  Récupérer les champs personnalisés Structure
 */
try {

    $custom_fields_structure = $client->request('GET', 'custom-fields', [
        'query' => ['model' => 'Structure']
    ]);
    $code_structure = $custom_fields_structure->getStatusCode();
    if ($code_structure != 200) {
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Structure invalide");
    }
    $data_structure = json_decode($custom_fields_structure->getBody(), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $options_structure = $data_structure['data'];
        foreach ($options_structure as $option_structure) {
            if (!empty($option_structure['options'])) {
                $opt_ohme['Structure'][$option_structure['name']]['label'] = $option_structure['label'];
                $opt = 0;
                foreach ($option_structure['options'] as $value_structure) {
                    $opt_ohme['Structure'][$option_structure['name']]['options'][$opt] = $value_structure;
                    $opt ++;
                }
            }
        }
    }else{
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Structure invalide");
    }

} catch (ClientException $e) {

    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
    logLmc("API OHME Structure invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());
}


/*
 * Récupérer les champs personnalisés Group
 */
try {

    $custom_fields_group = $client->request('GET', 'custom-fields', [
        'query' => ['model' => 'Group']
    ]);
    $code_group = $custom_fields_group->getStatusCode();
    if ($code_group != 200) {
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Group invalide");
    }
    $data_group = json_decode($custom_fields_group->getBody(), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $options_group = $data_group['data'];

        foreach ($options_group as $option_group) {
            if (!empty($option_group['options'])) {
                $opt_ohme['Group'][$option_group['name']]['label'] = $option_group['label'];
                $opt = 0;
                foreach ($option_group['options'] as $value_group) {
                    $opt_ohme['Group'][$option_group['name']]['options'][$opt] = $value_group;
                    $opt ++;
                }
            }
        }
    }else{
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Group invalide");
    }

} catch (ClientException $e) {
    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
    logLmc("API OHME Group invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());
}

/*
 * Récupérer les champs personnalisés Payment
 */
try {

    $custom_fields_payment = $client->request('GET', 'custom-fields', [
        'query' => ['model' => 'Payment']
    ]);
    $code_payment = $custom_fields_payment->getStatusCode();
    if ($code_payment != 200) {
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Payment invalide");
    }
    $data_payment = json_decode($custom_fields_payment->getBody(), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $options_payment = $data_payment['data'];

        foreach ($options_payment as $option_payment) {
            if (!empty($option_payment['options'])) {
                $opt_ohme['Payment'][$option_payment['name']]['label'] = $option_payment['label'];
                $opt = 0;
                foreach ($option_payment['options'] as $value_payment) {
                    $opt_ohme['Payment'][$option_payment['name']]['options'][$opt] = $value_payment;
                    $opt ++;
                }
            }
        }
    }else{
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Payment invalide");
    }

} catch (ClientException $e) {
    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
    logLmc("API OHME Payment invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());
}

/*
 * Récupérer les champs personnalisés Interaction
 */

try {

    $custom_fields_interaction = $client->request('GET', 'custom-fields', [
        'query' => ['model' => 'Interaction']
    ]);
    $code_interaction = $custom_fields_interaction->getStatusCode();
    if ($code_interaction != 200) {
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Interaction invalide");
    }
    $data_interaction = json_decode($custom_fields_interaction->getBody(), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $options_interaction = $data_interaction['data'];
        foreach ($options_interaction as $option_interaction) {
            if (!empty($option_interaction['options'])) {
                $opt_ohme['Interaction'][$option_interaction['name']]['label'] = $option_interaction['label'];
                $opt = 0;
                foreach ($option_interaction['options'] as $value_interaction) {
                    $opt_ohme['Interaction'][$option_interaction['name']]['options'][$opt] = $value_interaction;
                    $opt ++;
                }
            }
        }
    }else{
        $_SESSION['lmc_data']['error_step'] = 1;
        $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
        logLmc("Json OHME Interaction invalide");
    }

} catch (ClientException $e) {
    $_SESSION['lmc_data']['error_step'] = 1;
    $_SESSION['lmc_data']['$error_message'] = "Impossible de se connecter à OHME.";
    logLmc("API OHME Interaction invalide : " . $e->getResponse()->getStatusCode() . " = " .  $e->getResponse()->getBody());
}


?>