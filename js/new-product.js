document.addEventListener('DOMContentLoaded', function () {
    console.log('Script JS chargé');

    let nom = document.getElementById('nom');
    let emballage = document.getElementById('emballage');
    let vol = document.getElementById('vol');
    let danger = document.getElementById('danger');
    let atelier = document.getElementById('atelier');
    let risque = document.getElementById('risque');
    let fabriquant = document.getElementById('fabriquant');
    let nature = document.getElementById('nature');
    let utilisation = document.getElementById('utilisation');
    let fdsInput = document.getElementById('pdfUpload');
    let FDSDisplay = document.getElementById("FDSDisplay");
    let DispoFDS = document.getElementById('DispoFDS');
    let submitBtn = document.getElementById('submitBtn');

    let messageNom = document.getElementById('messageNom');
    let messageEmballage = document.getElementById('messageEmballage');
    let messageVol = document.getElementById('messageVol');
    let messageDanger = document.getElementById('messageDanger');
    let messageAtelier = document.getElementById('messageAtelier');
    let messageRisque = document.getElementById('messageRisque');
    let messageFabriquant = document.getElementById('messageFabriquant');
    let messageNature = document.getElementById('messageNature');
    let messageUtilisation = document.getElementById('messageUtilisation');
    let messageFDS = document.getElementById('messageFDS');

    const validationStates = {
        temoinNom: false,
        temoinEmballage: false,
        temoinVol: false,
        temoinDanger: false,
        temoinRisque: false,
        temoinFabriquant: false,
        temoinNature: false,
        temoinUtilisation: false,
        temoinAtelier: false,
        temoinFDS: false
    };

    // Vérification de la validation des champs
    function checkValidation() {
        // Validation du nom
        if (nom.value.trim() !== "") {
            validationStates.temoinNom = true;
            messageNom.style.display = 'none';
        } else {
            validationStates.temoinNom = false;
            messageNom.style.display = 'block';
            messageNom.textContent = 'Ce champ est obligatoire.';
        }

        // Validation de l'emballage
        if (emballage.value.trim() !== "") {
            validationStates.temoinEmballage = true;
            messageEmballage.style.display = 'none';
        } else {
            validationStates.temoinEmballage = false;
            messageEmballage.style.display = 'block';
            messageEmballage.textContent = 'Ce champ est obligatoire.';
        }

        // Validation du volume
        if (vol.value.trim() !== "") {
            validationStates.temoinVol = true;
            messageVol.style.display = 'none';
        } else {
            validationStates.temoinVol = false;
            messageVol.style.display = 'block';
            messageVol.textContent = 'Ce champ est obligatoire.';
        }

        // Validation du danger
        // const selectedDanger = Array.from(danger.selectedOptions).map(option => option.value);
        // const isValidDanger = selectedDanger.length > 0 && !selectedDanger.includes("none");

        // if (isValidDanger) {
        //     validationStates.temoinDanger = true;
        //     messageDanger.style.display = 'none';
        // } else {
        //     validationStates.temoinDanger = false;
        //     messageDanger.style.display = 'block';
        //     messageDanger.textContent = 'Veuillez sélectionner au moins un danger.';
        // }


        const selectedAtelier = Array.from(atelier.selectedOptions).map(option => option.value);
        const isValidAtelier = selectedAtelier.length > 0 && !selectedAtelier.includes("none");

        if (isValidAtelier) {
            validationStates.temoinAtelier = true;
            messageAtelier.style.display = 'none';
        } else {
            validationStates.temoinAtelier = false;
            messageAtelier.style.display = 'block';
            messageAtelier.textContent = 'Veuillez sélectionner au moins un atelier.';
        }

        // Validation du risque
        if (risque.value.trim() !== "") {
            validationStates.temoinRisque = true;
            messageRisque.style.display = 'none';
        } else {
            validationStates.temoinRisque = false;
            messageRisque.style.display = 'block';
            messageRisque.textContent = 'Ce champ est obligatoire.';
        }

        // Validation du fabriquant
        if (fabriquant.value.trim() !== "") {
            validationStates.temoinFabriquant = true;
            messageFabriquant.style.display = 'none';
        } else {
            validationStates.temoinFabriquant = false;
            messageFabriquant.style.display = 'block';
            messageFabriquant.textContent = 'Ce champ est obligatoire.';
        }

        // Validation de la nature
        if (nature.value.trim() !== "") {
            validationStates.temoinNature = true;
            messageNature.style.display = 'none';
        } else {
            validationStates.temoinNature = false;
            messageNature.style.display = 'block';
            messageNature.textContent = 'Ce champ est obligatoire.';
        }

        // Validation de l'utilisation
        if (utilisation.value.trim() !== "") {
            validationStates.temoinUtilisation = true;
            messageUtilisation.style.display = 'none';
        } else {
            validationStates.temoinUtilisation = false;
            messageUtilisation.style.display = 'block';
            messageUtilisation.textContent = 'Ce champ est obligatoire.';
        }

        // Validation du FDS si "Oui" est sélectionné
        if (DispoFDS.value === "oui") {
            if (fdsInput && fdsInput.files.length > 0) {
                messageFDS.style.display = 'none';
                validationStates.temoinFDS = true;
            } else {
                messageFDS.style.display = 'block';
                messageFDS.textContent = 'Le fichier FDS est obligatoire.';
                validationStates.temoinFDS = false;
            }
            FDSDisplay.style.display = "block"; // Affiche la zone de téléchargement FDS
        } else {
            validationStates.temoinFDS = true;
            messageFDS.style.display = 'none';
            FDSDisplay.style.display = "none"; // Cache la zone de téléchargement FDS
        }

        // Contrôler si tous les champs sont valides et activer/désactiver le bouton submit
        if (submitBtn) {
            submitBtn.disabled = !Object.values(validationStates).every(Boolean);
        }
    }   
   
    danger.addEventListener('change', () => {
        const selectedDanger = Array.from(danger.selectedOptions).map(option => option.value);
        const isNoneSelected = selectedDanger.includes("1");
        const hasOtherSelections = selectedDanger.some(value => value !== "1");
    
        const messageConflict = document.getElementById("message-conflit-danger");
    
        // Gestion du blocage logique
        if (selectedDanger.length === 0 || selectedDanger.includes("none")) {
            validationStates.temoinDanger = false;
            messageDanger.style.display = 'block';
            messageDanger.textContent = 'Veuillez sélectionner au moins un danger.';
            messageConflict.style.display = 'none';
        } else if (isNoneSelected && hasOtherSelections) {
            validationStates.temoinDanger = false;
            messageConflict.style.display = 'block';
            messageConflict.textContent = 'Vous avez sélectionné "Aucun danger" ainsi qu’un autre danger. Veuillez vérifier votre choix.';
            messageDanger.style.display = 'none';
        } else {
            validationStates.temoinDanger = true;
            messageDanger.style.display = 'none';
            messageConflict.style.display = 'none';
        }
    
        // Gestion des options sélectionnables
        for (let option of danger.options) {
            if (isNoneSelected) {
                // Si "Aucun danger" est sélectionné, on désactive les autres
                if (option.value !== "1") {
                    option.disabled = true;
                }
            } else if (hasOtherSelections) {
                // Si un autre danger est sélectionné, on désactive "Aucun danger"
                if (option.value === "1") {
                    option.disabled = true;
                }
            } else {
                // Sinon, on réactive toutes les options
                option.disabled = false;
            }
        }
    
        // Mise à jour du bouton
        const submitButton = document.getElementById("btn-valider");
        submitButton.disabled = !Object.values(validationStates).every(Boolean);
    });
    
   
   
    document.querySelector('form').addEventListener('submit', function (e) {
        checkValidation(); // Vérification des champs avant soumission
        if (!Object.values(validationStates).every(Boolean)) {
            e.preventDefault(); // Empêcher la soumission si un champ est invalide
            alert("Veuillez remplir correctement tous les champs obligatoires.");
        }
    });

    // Validation des champs à la saisie de l'utilisateur
    nom.addEventListener('input', function () { checkValidation(); });
    emballage.addEventListener('input', function () { checkValidation(); });
    vol.addEventListener('input', function () { checkValidation(); });
    risque.addEventListener('input', function () { checkValidation(); });
    fabriquant.addEventListener('input', function () { checkValidation(); });
    nature.addEventListener('input', function () { checkValidation(); });
    utilisation.addEventListener('input', function () { checkValidation(); });
    danger.addEventListener('change', function () { checkValidation(); });
    DispoFDS.addEventListener('change', function () { checkValidation(); });
    if (fdsInput) {
        fdsInput.addEventListener('change', function () { checkValidation(); });
    }

    // Initialisation de la validation lors du chargement de la page
    checkValidation();
});






    function readPDF(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if (file.type === "application/pdf") {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#pdfViewer').attr('src', e.target.result);
                    $('#pdfPreview').fadeIn(300);
                };
                reader.readAsDataURL(file);
            } else {
                alert("Veuillez sélectionner un fichier PDF.");
                input.value = ""; // reset
            }
        }
    }
    
    $("#pdfUpload").change(function () {
        readPDF(this);
    });
    
    $(".remove-pdf").on("click", function () {
        $('#pdfUpload').val('');
        $('#pdfViewer').attr('src', '');
        $('#pdfPreview').fadeOut(300);
    });






$(function () {
    $("#datepicker, #datepicker1, #datepicker2").datepicker({ 
            autoclose: true, 
            todayHighlight: true
    }).datepicker('update', new Date());    
});


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
$('.remove-img').on('click', function() {
    var imageUrl = "images/no-img-avatar.png";
    $('.avatar-preview, #imagePreview').removeAttr('style');
    $('#imagePreview').css('background-image', 'url(' + imageUrl + ')');
});
