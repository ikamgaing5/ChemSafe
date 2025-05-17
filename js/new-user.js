// let nomuser = document.getElementById('nomuser');
// let mdp = document.getElementById('password');
// let role = document.getElementById('role');
// let messageNom = document.getElementById('messageNom');
// let messageMdp = document.getElementById('messageMdp');
// let messageRole = document.getElementById('messageRole');
// let submitBtn = document.getElementById('submitBtn');

// const validationStates = {
//     temoinNom: false,
//     temoinMdp: false,
//     temoinRole: false
// };


// function checkValidation() {
// // Validation du nom
// if (nomuser.value.trim() !== "") {
//     validationStates.temoinNom = true;
//     messageNom.style.display = 'none';
// } else {
//     validationStates.temoinNom = false;
//     messageNom.style.display = 'block';
//     messageNom.textContent = 'Ce champ est obligatoire.';
// }

// if (mdp.value.trim() !== "") {
//     validationStates.temoinMdp = true;
//     messageMdp.style.display = "none";
// }else if(mdp.value.trim() == ""){
//     validationStates.temoinMdp = false;
//     messageMdp.style.display = "block";
//     messageMdp.textContent = "Ce champ est obligatoire.";
// }
// const selectedRole = Array.from(role.selectedOptions).map(option => option.value);
// const isValidRole = selectedRole.length > 0 && !selectedRole.includes("none");

// if (isValidRole) {
//     validationStates.temoinRole = true;
//     messageRole.style.display = 'none';
// } else {
//     validationStates.temoinDanger = false;
//     messageRole.style.display = 'block';
//     messageRole.textContent = 'Veuillez sélectionner un role.';
// }

// if (submitBtn) {
//     submitBtn.disabled = !Object.values(validationStates).every(Boolean);
// }


// }

// nomuser.addEventListener('input', function () { checkValidation(); });
// mdp.addEventListener('input', function () { checkValidation(); })
// role.addEventListener('change', function () { checkValidation(); });

// checkValidation();

function validForm() {
    let nomuser = document.getElementById('nomuser').value.trim();
    let mdp = document.getElementById('password').value.trim();
    let role = document.getElementById('role').value.trim();

    if (nomuser == "" && mdp == "" && role == "none") {
        document.getElementById('messageNom').innerText = "Ce champ est obligatoire.";
        document.getElementById('messageRole').innerText = "Ce champ est obligatoire.";
        document.getElementById('messageMdp').innerText = "Ce champ est obligatoire.";
        console.log('tous les chammps');
        return false;
    }else if(nomuser == "" && mdp == ""){
        document.getElementById('messageNom').innerText = "Ce champ est obligatoire.";
        document.getElementById('messageMdp').innerText = "Ce champ est obligatoire.";
        console.log('nom et mdp');
        return false;
    }else if (role == "none" && mdp == "") {
        document.getElementById('messageRole').innerText = "Ce champ est obligatoire.";
        document.getElementById('messageMdp').innerText = "Ce champ est obligatoire.";
        console.log('role et mdp');
        return false;
    }else if (nom == "" && role == "none") {
        document.getElementById('messageRole').innerText = "Ce champ est obligatoire.";
        document.getElementById('messageNom').innerText = "Ce champ est obligatoire.";
        console.log('role et nom');
        return false;
    }else if ( mdp == "") {
        document.getElementById('messageMdp').innerText = "Ce champ est obligatoire.";
        console.log('mdp');
        return false;
    }else if (role == "none") {
        document.getElementById('messageRole').innerText = "Ce champ est obligatoire.";
        console.log('role');
        return false;
    }else if (nom == "") {
        document.getElementById('messageNom').innerText = "Ce champ est obligatoire.";
        console.log('nom');
        return false;
    }else{
        return true;
    }
}