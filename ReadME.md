# Documentation du Dictionnaire Firestore (PHP)

Ce projet utilise l'API REST de Google Firestore pour gérer la communication avec le dictionnaire.  
Il vous sera expliquer comment utiliser le projet pour établir la lisaison avec la base de données, et comment utiliser les principales fonctions.



## | Configuration Requise |

**clé API à récupéré directement sur Firebase pour accéder à la base de donées Firestore** 
```php
  $apiKey = 'VOTRE_CLE_API';
```

* L’URL de la collection principale :

  ```php
  $baseUrl = "https://firestore.googleapis.com/v1/projects/sae-3-3fd79/databases/(default)/documents/[NOM–DE–LA–COLLECTION]";
  ```
* L’extension PHP **cURL** activée.



## | API Firestore géré avec la fonction api() |

Tous les appels Firestore passent par :

```php
api(string $url, string $method = 'GET', ?array $data = null): array
```

La fonction permet de faire  :
* GET, POST, PATCH, DELETE
* encodage JSON
* décodage JSON
* journalisation/debug si vous l’activez

---

## Fonctions disponibles et exemple d'utilisation

### 1. Ajouter un mot  add_word()

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

### 2. Modifier un mot update_word()

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



### 3. Supprimer un mot delete_word()

Supprime un mot dans la collection souhaitée.

| Paramètre     | Type   | Description                                                         |
| ------------- | ------ | ------------------------------------------------------------------- |
| `target_word` | string | Mot à supprimer                                                     |
| `target_lang` | string | `'fr'` (défaut) ou `'en'`                                           |
| `ext`         | string | Suffixe optionnel pour accéder à une autre collection pour la page ajout_mot (ex : `_ask`) |


**Exemples :**

```php
// Supprimer dans la collection principale
delete_word('poisson');

// Supprimer dans dictionnaire_ask
delete_word('oeuf', 'fr', '_ask');
```

## 4. Rechercher des mots get_dictionary_words()

Effectue une recherche par :

* LIKE insensible à la casse
* langue cible 
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

## 5. Récupérer un mot aléatoire get_random_word()

Retourne un mot au hasard avec ses traductions et catégories :

```php
$random = get_random_word();
```

## 6. Obtenir toutes les catégories get_all_categories()

Retourne toutes les catégories existantes dans la base : 

```php
$cats = get_all_categories();
```

## 7. Ajouter une demande ask_add_word()

La fonction permet d’ajouter un mot dans la collection **dictionnaire_ask**.

```php
ask_add_word('soleil', 'sun', 'sol', ['nature']);
```

Et pour récupérer toutes les demandes :

```php
$list = get_all_ask_words();
```


