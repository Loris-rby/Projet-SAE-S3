<?php
// Inclut le fichier contenant toutes les fonctions CRUD et de recherche.
require_once 'fonctions.php';

// ====================================================================
// --- DÉMONSTRATION D'UTILISATION (1 LIGNE) ---
// ====================================================================

$mot_a_fr = 'la plume';
$mot_a_en = 'the feather';
$mot_b_fr = 'le bateau';
$mot_b_en = 'the boat';

/*


$result_a = add_word($mot_a_fr, $mot_a_en, ['écriture', 'oiseau']);
echo "Ajout de '$mot_a_fr' : " . ($result_a['name'] ?? 'Échec') . "\n";


// Utilisation 1 ligne : Ajout du mot B
$result_b = add_word($mot_b_fr, $mot_b_en, ['mer', 'transport', 'navigation']);
echo "Ajout de '$mot_b_fr' : " . ($result_b['name'] ?? 'Échec') . "\n";



echo "2. RECHERCHE (Read) par catégorie\n";

// Utilisation 1 ligne : Recherche des mots de la catégorie 'transport'
$mots_transport = get_dictionary_words(null, 'fr', 'transport'); 
echo "Mots trouvés pour 'transport' :\n";
foreach ($mots_transport as $mot) {
    echo "  -> FR: {$mot['fr']}, EN: {$mot['en']}\n";
}



echo "3. RECHERCHE BIDIRECTIONNELLE (LIKE sur mot Anglais)\n";

// Utilisation 1 ligne : Recherche LIKE sur le mot anglais ('boat' dans la langue 'en')
$result_like_en = get_dictionary_words('boat', 'en'); 
echo "Résultat LIKE sur 'boat' : FR: " . ($result_like_en[0]['fr'] ?? 'Non trouvé') . "\n";



echo "4. MODIFICATION (Update) basée sur le mot Français\n";

// Utilisation 1 ligne : Mise à jour des catégories de 'la plume' (cible 'fr' par défaut)
$new_cats = ['outil', 'écriture', 'papeterie'];
$result_update = update_word($mot_a_fr, 'fr', null, $new_cats);
echo "Mise à jour de '$mot_a_fr' statut : " . ($result_update !== null ? 'Succès (PATCH)' : 'Échec') . "\n";



echo "5. SUPPRESSION (Delete) basée sur le mot Anglais\n";

// Utilisation 1 ligne : Suppression de 'the boat' (cible 'en')
$result_delete_en = delete_word($mot_b_en, 'en');
echo "Suppression de '$mot_b_en' : " . ($result_delete_en === [] ? 'Succès' : 'Échec') . "\n";

// Verification
$verif_delete = get_dictionary_words('le bateau');
echo "Vérification (doit être vide) : " . (empty($verif_delete) ? 'OK, supprimé.' : 'Erreur.') . "\n";




// Test nouvelle function --> get_random_word
$random_word = get_random_word();
echo "Mot aléatoire : FR: {$random_word['fr']}, EN: {$random_word['en']}, ES: {$random_word['es']}\n";

// Test nouvelle function --> get_all_categories
$all_categories = get_all_categories();
echo "Catégories dans le dictionnaire : " . implode($all_categories);



$ask_word_fr = 'oeuf';
$ask_word_en = 'egg';
$ask_word_es = 'huevo';
$res = ask_add_word($ask_word_fr, $ask_word_en, $ask_word_es, ['nourriture']);


*/
delete_word('oeuf', 'fr','_ask');


//parcours et affiche tout les mots demandés
foreach (get_all_ask_words() as $demande) {
    echo "Mot demandé : FR: {$demande['fr']}, EN: {$demande['en']}, ES: {$demande['es']}\n";
}




