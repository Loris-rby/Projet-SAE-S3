<?php

// ====================================================================
// --- Configuration API (À personnaliser) ---
// ====================================================================

$apiKey = 'YOUR API KEY'; 
$baseUrl = "https://firestore.googleapis.com/v1/projects/sae-3-3fd79/databases/(default)/documents/dictionnaire";


// ====================================================================
// --- Fonctions Utilitaires ---
// ====================================================================

/**
 * @brief Fonction d'appel générique à l'API Firestore.
 */
function api(string $url, string $method = 'GET', ?array $data = null): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $data ? json_encode($data) : null
    ]);
    $r = curl_exec($ch);
    curl_close($ch);
    return json_decode($r, true) ?? [];
}

/**
 * @brief Convertit un tableau PHP simple de chaînes en format arrayValue de Firestore.
 */
function to_firestore_array(array $categories): array {
    $category_values = [];
    foreach ($categories as $cat) {
        $category_values[] = ['stringValue' => $cat];
    }
    return [
        'arrayValue' => [
            'values' => $category_values
        ]
    ];
}

/**
 * @brief Récupère l'ID complet du document à partir du mot dans la langue spécifiée.
 */
function get_doc_id_by_word(string $word, string $lang): ?string {
    global $baseUrl, $apiKey;
    $url = $baseUrl . "?key=$apiKey";

    $data = api($url, 'GET');

    foreach ($data['documents'] ?? [] as $d) {
        $f = $d['fields'];
        if (($f[$lang]['stringValue'] ?? '') === $word) {
            return $d['name'];
        }
    }
    return null;
}


// ===================================================================================
// --- Fonctions CRUD et Recherche (Utilisation 1 Ligne) ---
// ===================================================================================

/**
 * @brief Ajoute un nouveau mot au dictionnaire.
 */
function add_word(string $fr, string $en, array $categories): array {
    global $baseUrl, $apiKey;
    $url = $baseUrl . "?key=$apiKey";
    
    $mot_data = ['fields' => [
        'fr' => ['stringValue' => $fr],
        'en' => ['stringValue' => $en],
        'categories' => to_firestore_array($categories)
    ]];

    return api($url, 'POST', $mot_data);
}

/**
 * @brief Modifie l'entrée d'un mot existant (Update/PATCH). Le ciblage est bidirectionnel.
 */
function update_word(string $target_word, string $target_lang = 'fr', ?string $new_en = null, ?array $new_categories = null): ?array {
    global $apiKey;
    $doc_id = get_doc_id_by_word($target_word, $target_lang);
    
    if (!$doc_id) {
        return null;
    }

    $url = $doc_id . "?key=$apiKey";
    $fields_to_update = [];

    if ($new_en !== null) {
        $fields_to_update['en'] = ['stringValue' => $new_en];
    }
    if ($new_categories !== null) {
        $fields_to_update['categories'] = to_firestore_array($new_categories);
    }

    if (empty($fields_to_update)) {
        return ['message' => 'Rien à mettre à jour.'];
    }

    $update_data = ['fields' => $fields_to_update];
    
    return api($url, 'PATCH', $update_data);
}

/**
 * @brief Supprime une entrée de mot du dictionnaire (Delete). Le ciblage est bidirectionnel.
 */
function delete_word(string $target_word, string $target_lang = 'fr'): ?array {
    global $apiKey;
    $doc_id = get_doc_id_by_word($target_word, $target_lang);

    if (!$doc_id) {
        return null;
    }

    $url = $doc_id . "?key=$apiKey";
    
    return api($url, 'DELETE');
}

/**
 * @brief Récupère tous les documents et filtre par mot (recherche LIKE) ou par catégorie.
 */
function get_dictionary_words(?string $filter_word_like = null, string $filter_lang = 'fr', ?string $filter_category = null): array {
    global $baseUrl, $apiKey;
    $url = $baseUrl . "?key=$apiKey";

    $data = api($url, 'GET');
    $results = [];

    foreach ($data['documents'] ?? [] as $d) {
        $f = $d['fields'];
        $word_fr = $f['fr']['stringValue'] ?? '';
        $word_en = $f['en']['stringValue'] ?? '';
        
        // Extraction des catégories (ArrayValue -> PHP array)
        $categories_php = [];
        $firestore_categories = $f['categories']['arrayValue']['values'] ?? [];

        foreach ($firestore_categories as $cat_value) {
            $categories_php[] = $cat_value['stringValue'] ?? '';
        }
        
        // --- Logique de Filtrage ---
        $target_word = ($filter_lang === 'en') ? $word_en : $word_fr;

        // Filtrage LIKE (utilisation de stristr pour une recherche insensible à la casse)
        $pass_word_filter = ($filter_word_like === null || stristr($target_word, $filter_word_like) !== false);

        // Filtrage par catégorie exacte
        $pass_category_filter = ($filter_category === null || in_array($filter_category, $categories_php));

        // Formatage et ajout si tous les filtres sont passés
        if ($pass_word_filter && $pass_category_filter) {
            $results[] = [
                'fr' => $word_fr,
                'en' => $word_en,
                'categories' => $categories_php
            ];
        }
    }
    
    return $results;
}
