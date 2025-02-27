<?php
// Données du formulaire
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Clé API Notion et ID de la base de données
$notion_api_key = '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'; 
$database_id = '1a7e0e45e08680f0b339f13a180da34d';

// URL de l'API Notion pour ajouter une entrée dans la base de données
$url = "https://api.notion.com/v1/pages";

// Données à envoyer à Notion
$data = [
    "parent" => [
        "database_id" => $database_id
    ],
    "properties" => [
        "Nom" => [ // Remplacez par le nom de la propriété dans votre base de données
            "title" => [
                [
                    "text" => [
                        "content" => $name
                    ]
                ]
            ]
        ],
        "E-mail" => [ // Remplacez par le nom de la propriété dans votre base de données
            "email" => $email
        ],
        "Demande" => [ // Remplacez par le nom de la propriété dans votre base de données
            "rich_text" => [
                [
                    "text" => [
                        "content" => $subject
                    ]
                ]
            ]
        ],
        "message" => [ // Remplacez par le nom de la propriété dans votre base de données
            "rich_text" => [
                [
                    "text" => [
                        "content" => $message
                    ]
                ]
            ]
        ]
    ]
];

// Convertir les données en JSON
$json_data = json_encode($data);

// Configuration de la requête cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $notion_api_key,
    'Content-Type: application/json',
    'Notion-Version: 2022-06-28' // Version de l'API Notion
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Exécuter la requête
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Fermer la connexion cURL
curl_close($ch);

// Vérifier la réponse
if ($http_code === 200) {
    // Succès
    echo json_encode(['status' => 'success', 'message' => 'Données enregistrées dans Notion avec succès !']);
} else {
    // Erreur
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'envoi des données à Notion.', 'details' => $response]);
}
?>