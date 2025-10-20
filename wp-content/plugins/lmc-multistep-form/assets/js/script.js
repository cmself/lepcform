const step1_siret = document.getElementById('step1_siret');

step1_siret.addEventListener('input', () => {
    // Supprime tout ce qui n'est pas un chiffre
    step1_siret.value = step1_siret.value.replace(/[^0-9]/g, '');
});