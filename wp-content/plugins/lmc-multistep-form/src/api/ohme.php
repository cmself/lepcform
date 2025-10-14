<?php

try {

$custom_fields = $client->get('https://api-ohme.oneheart.fr/api/v1/custom-fields');
$data = json_decode($custom_fields->getBody(), true);
if (json_last_error() === JSON_ERROR_NONE) {
$options = $data['data'][1]['options'];
} else {
$options = null;
}

} catch (ClientException $e) {
echo 'HTTP Status Code: ' . $e->getResponse()->getStatusCode() . "\n";
echo 'Body: ' . $e->getResponse()->getBody();
}

?>