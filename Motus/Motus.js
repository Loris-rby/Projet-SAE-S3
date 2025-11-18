document.addEventListener("DOMContentLoaded", () => {
    const lignes = document.querySelectorAll("tr");
    const boutonValider = document.getElementById("btnValider");
    let ligneActive = 0;

    // Gestion du déplacement automatique entre cases
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1) {
                const next = inputs[index + 1];
                if (next && !next.disabled)
                    next.focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && input.value === "") {
                const prev = inputs[index - 1];
                if (prev && !prev.disabled)
                    prev.focus();
            }
        });
    });
    });