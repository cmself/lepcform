<?php
// Récupérer les champs personnalisés Contact

$opt_ohme = [];

try {

    $custom_fields_contact = $client->get('https://api-ohme.oneheart.fr/api/v1/custom-fields?model=Contact');
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
    }

} catch (ClientException $e) {
    echo 'HTTP Status Code: ' . $e->getResponse()->getStatusCode() . "\n";
    echo 'Body: ' . $e->getResponse()->getBody();
}

// Récupérer les champs personnalisés Structure

try {

    $custom_fields_structure = $client->get('https://api-ohme.oneheart.fr/api/v1/custom-fields?model=Structure');
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
    }

} catch (ClientException $e) {
    echo 'HTTP Status Code: ' . $e->getResponse()->getStatusCode() . "\n";
    echo 'Body: ' . $e->getResponse()->getBody();
}


// Récupérer les champs personnalisés Group
try {

    $custom_fields_group = $client->get('https://api-ohme.oneheart.fr/api/v1/custom-fields?model=Group');
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
    }

} catch (ClientException $e) {
    echo 'HTTP Status Code: ' . $e->getResponse()->getStatusCode() . "\n";
    echo 'Body: ' . $e->getResponse()->getBody();
}

// Récupérer les champs personnalisés Payment

try {

    $custom_fields_payment = $client->get('https://api-ohme.oneheart.fr/api/v1/custom-fields?model=Payment');
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
    }

} catch (ClientException $e) {
    echo 'HTTP Status Code: ' . $e->getResponse()->getStatusCode() . "\n";
    echo 'Body: ' . $e->getResponse()->getBody();
}

// Récupérer les champs personnalisés Interaction

try {

    $custom_fields_interaction = $client->get('https://api-ohme.oneheart.fr/api/v1/custom-fields?model=Interaction');
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
    }

} catch (ClientException $e) {
    echo 'HTTP Status Code: ' . $e->getResponse()->getStatusCode() . "\n";
    echo 'Body: ' . $e->getResponse()->getBody();
}


?>