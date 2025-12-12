Voici **le fichier complet en texte brut Markdown**, prêt à être copié/collé dans ton dépôt GitHub ou ton README.md :

---

````md
# Documentation du Dictionnaire Firestore (PHP)

Ce projet utilise l'API REST de Google Firestore pour gérer un dictionnaire multilingue.  
La structure est organisée pour séparer clairement :

1. **`functions.php`** : Logique métier et accès Firestore (CRUD + recherche + utilitaires).
2. **`test.php`** : Exemples d’utilisation en une seule ligne.

---

## ⚙️ Configuration Requise

- Une **clé API Firestore** valide :
  ```php
  $apiKey = 'VOTRE_CLE_API';
````

* L’URL de la collection principale :

  ```php
  $baseUrl = "https://firestore.googleapis.com/v1/projects/sae-3-3fd79/databases/(default)/documents/dictionnaire";
  ```
* L’extension PHP **cURL** activée.

---

# 🔧 API Firestore — Fonction `api()`

Tous les appels Firestore passent par :

```php
api(string $url, string $method = 'GET', ?array $data = null): array
```

La fonction gère :

* GET, POST, PATCH, DELETE
* encodage JSON
* décodage JSON
* journalisation/debug si vous l’activez

---

# 🚀 Fonctions disponibles (utilisation en 1 ligne)

## 1. Ajouter un mot — `add_word()`

Ajoute un mot avec ses traductions et catégories.

| Paramètre    | Type     | Description           |
| ------------ | -------- | --------------------- |
| `fr`         | string   | Mot en français       |
| `en`         | string   | Mot en anglais        |
| `es`         | string   | Mot en espagnol       |
| `categories` | string[] | Tableau de catégories |

**Exemple :**

```php
add_word('poisson', 'fish', 'pez', ['faune', 'aquatique']);
```

---

## 2. Modifier un mot — `update_word()`

Met à jour la traduction anglaise et/ou les catégories.

| Paramètre        | Type   | Description               |                               |
| ---------------- | ------ | ------------------------- | ----------------------------- |
| `target_word`    | string | Mot à cibler              |                               |
| `target_lang`    | string | `'fr'` (défaut) ou `'en'` |                               |
| `new_en`         | string | null                      | Nouvelle traduction anglaise  |
| `new_categories` | array  | null                      | Nouveau tableau de catégories |

**Exemple :**

```php
update_word('fish', 'en', 'the fish', ['faune', 'eau']);
```

---

## 3. Supprimer un mot — `delete_word()`

Supprime un mot dans la collection souhaitée, avec URL Firestore **corrigée en absolu**.

| Paramètre     | Type   | Description                                                         |
| ------------- | ------ | ------------------------------------------------------------------- |
| `target_word` | string | Mot à supprimer                                                     |
| `target_lang` | string | `'fr'` (défaut) ou `'en'`                                           |
| `ext`         | string | Suffixe optionnel pour accéder à une autre collection (ex : `_ask`) |

⚠ **IMPORTANT :** Firestore exige une URL absolue du type :

```
https://firestore.googleapis.com/v1/{document_path}
```

**Exemples :**

```php
// Supprimer dans la collection principale
delete_word('poisson');

// Supprimer dans dictionnaire_ask
delete_word('oeuf', 'fr', '_ask');
```

---

## 4. Rechercher des mots — `get_dictionary_words()`

Effectue une recherche par :

* LIKE insensible à la casse
* langue cible (`fr` ou `en`)
* catégorie exacte

| Paramètre          | Type   | Description               |                  |
| ------------------ | ------ | ------------------------- | ---------------- |
| `filter_word_like` | string | null                      | Recherche LIKE   |
| `filter_lang`      | string | `'fr'` (défaut) ou `'en'` |                  |
| `filter_category`  | string | null                      | Catégorie exacte |

**Exemples :**

```php
// Tous les mots dont la version anglaise contient "ish"
$A = get_dictionary_words('ish', 'en');

// Tous les mots dans la catégorie "nature"
$B = get_dictionary_words(null, 'fr', 'nature');

// Tous les mots sans filtre
$C = get_dictionary_words();
```

---

## 5. Récupérer un mot aléatoire — `get_random_word()`

Retourne un mot au hasard avec ses traductions et catégories :

```php
$random = get_random_word();
```

---

## 6. Obtenir toutes les catégories — `get_all_categories()`

Retourne toutes les catégories uniques existantes :

```php
$cats = get_all_categories();
```

---

## 7. Ajouter une demande — `ask_add_word()`

La fonction permet d’ajouter un mot dans la collection **dictionnaire_ask**.

```php
ask_add_word('soleil', 'sun', 'sol', ['nature']);
```

Et pour récupérer toutes les demandes :

```php
$list = get_all_ask_words();
```

---

