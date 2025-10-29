````markdown
# 📚 Documentation du Dictionnaire Firestore (PHP)

Ce projet utilise l'API REST de Google Firestore pour gérer un dictionnaire multilingue. La structure est séparée pour une meilleure maintenance :

1.  **`functions.php`** : Contient toute la logique métier (fonctions CRUD, utilitaires API, et logique de filtrage).
2.  **`test.php`** : Contient les exemples d'appels aux fonctions en ligne unique.

---

## ⚙️ Configuration Requise

1.  **Clé API :** Vérifiez que votre `$apiKey` et votre `$baseUrl` sont correctement configurés au début du fichier **`functions.php`**.
2.  **cURL :** L'extension cURL de PHP doit être activée.

---

## 🚀 Utilisation des Fonctions (Syntaxe en Ligne Unique)

Toutes les fonctions sont conçues pour être appelées en une seule ligne dans votre code.

### 1. Ajout d'un mot (**`add_word`**)

Ajoute un nouveau document au dictionnaire.

| Paramètre | Type | Description |
| :--- | :--- | :--- |
| `fr` | `string` | Le mot en français. |
| `en` | `string` | La traduction en anglais. |
| `categories` | `array` | Un tableau de chaînes de caractères pour les catégories. |

**Exemple :**
```php
add_word('le poisson', 'the fish', ['faune', 'eau', 'animal']);
````

-----

### 2\. Modification d'un mot (**`update_word`**)

Modifie la traduction anglaise et/ou les catégories d'un mot existant, en ciblant le mot via la langue de votre choix.

| Paramètre | Type | Description |
| :--- | :--- | :--- |
| `target_word` | `string` | Le mot à identifier (ex: 'le poisson' ou 'the fish'). |
| `target_lang` | `string` | **`'fr'` (défaut)** ou **`'en'`**. Langue du mot cible. |
| `new_en` | `string\|null` | Nouvelle traduction anglaise (ou `null` pour ne pas changer). |
| `new_categories` | `array\|null` | Nouveau tableau de catégories (ou `null` pour ne pas changer). |

**Exemple (Modification du mot basée sur le mot ANGLAIS) :**

```php
// Cible 'the fish' (en) et change sa traduction et ses catégories.
update_word('the fish', 'en', 'fish', ['faune', 'aquatique']);
```

-----

### 3\. Suppression d'un mot (**`delete_word`**)

Supprime un mot du dictionnaire, en ciblant le mot via la langue de votre choix.

| Paramètre | Type | Description |
| :--- | :--- | :--- |
| `target_word` | `string` | Le mot à identifier (ex: 'le poisson' ou 'the fish'). |
| `target_lang` | `string` | **`'fr'` (défaut)** ou **`'en'`**. Langue du mot cible. |

**Exemple (Suppression basée sur le mot FRANÇAIS) :**

```php
// Supprime 'le poisson' (cible 'fr' par défaut)
delete_word('le poisson');
```

-----

### 4\. Recherche de mots (**`get_dictionary_words`**)

Récupère et filtre les mots du dictionnaire. Le filtre par mot utilise la recherche **`LIKE`** (contient la chaîne).

| Paramètre | Type | Description |
| :--- | :--- | :--- |
| `filter_word_like` | `string\|null` | Chaîne de caractères à rechercher (recherche LIKE / "contient"). |
| `filter_lang` | `string` | **`'fr'` (défaut)** ou **`'en'`**. Langue dans laquelle appliquer le filtre LIKE. |
| `filter_category` | `string\|null` | Le nom exact d'une catégorie. |

**Exemples de recherche en ligne unique :**

```php
// A. Chercher tous les mots dont la traduction ANGLAISE contient 'ish'
$result_A = get_dictionary_words('ish', 'en'); 

// B. Chercher tous les mots de la catégorie 'animal' (recherche FR par défaut)
$result_B = get_dictionary_words(null, 'fr', 'animal'); 

// C. Chercher tous les mots sans aucun filtre
$result_C = get_dictionary_words();
```