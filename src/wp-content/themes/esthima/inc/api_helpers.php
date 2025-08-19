<?php
// Fonction pour appeler l'API de tracking Esthima
function esthima_get_tracking($tracking_id, $animal_name, $animal_species) {
    $api_url = API_URL . "/conventions/{$tracking_id}/traceabilities?animalName={$animal_name}&animalSpecies={$animal_species}";

    $jwt_token = $_COOKIE['token'];

    if (empty($jwt_token)) return;

    $response = wp_remote_get($api_url, [
        'timeout' => 10,
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $jwt_token,
        ],
    ]);

    if (is_wp_error($response)) {
        return [
            'error' => $response->get_error_message(),
            'data' => null,
        ];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return [
        'error' => null,
        'data' => $data,
    ];
}