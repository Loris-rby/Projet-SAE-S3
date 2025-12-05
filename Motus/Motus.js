document.addEventListener("DOMContentLoaded", () => {
    const lignes = document.querySelectorAll("tr");        // Sélectionne toutes les lignes du tableau
    const boutonValider = document.getElementById("btnValider"); // Récupère le bouton "Valider"
    let ligneActive = 0;                                   // Index de la ligne actuellement active

    // Gestion du déplacement automatique entre les champs input
    const inputs = document.querySelectorAll('input[type="text"]'); // Sélection de tous les champs texte

    inputs.forEach((input, index) => {

        // Quand l'utilisateur tape un caractère, on passe automatiquement au champ suivant
        input.addEventListener('input', () => {
            if (input.value.length === 1) {                // Si un seul caractère est saisi
                const next = inputs[index + 1];            // On récupère l'input suivant
                if (next && !next.disabled)                // Si l'input suivant existe et est actif
                    next.focus();                          // Déplacement du curseur
            }
        });

        // Gestion de la touche Retour arrière pour revenir au champ précédent
        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && input.value === "") { // Si backspace sur un champ vide
                const prev = inputs[index - 1];                // On récupère l'input précédent
                if (prev && !prev.disabled)                    // Si l'input précédent existe et est actif
                    prev.focus();                              // Déplacement du curseur en arrière
            }
        });
    });
});