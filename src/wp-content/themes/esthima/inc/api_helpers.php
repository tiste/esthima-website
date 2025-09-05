<?php
// Fonction pour appeler l'API de tracking Esthima
function esthima_get_tracking($tracking_id, $animal_name, $animal_species) {
    $api_url = API_URL . "/conventions/{$tracking_id}/traceabilities?animalName={$animal_name}&animalSpecies={$animal_species}";

    $jwt_token = $_COOKIE['token'] ?? '';

    if (empty($jwt_token)) {
        return [
            'error' => 'Authentification requise',
            'data' => null,
        ];
    }

    $use_mock_data = false;

    if (!$use_mock_data) {
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
    } else {
        $mock_data = [
            "offerType" => "plural", // reference / plural / private
            "tasks" => [
                [
                    "name" => "creation",
                    "at" => "2025-06-01"
                ],
                [
                    "name" => "arrived",
                    "at" => "2025-06-02"
                ],
                [
                    "name" => "cremation",
                    "at" => "2025-06-02"
                ]
            ],
            "paymentMethod" => "bank_check",
            "paymentStatus" => "done"
        ];

        $data = $mock_data;
    }

    return [
        'error' => null,
        'data' => $data,
    ];
}