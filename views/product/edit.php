<?php
require_once __DIR__ . '/../../utilities/session.php';
// require_once __DIR__. '/../../models/atelier.php';
// require_once __DIR__. '/../../models/produit.php';
// require_once __DIR__.'/../../models/danger.php';
// require_once __DIR__. '/../../models/contenir.php';
// require_once __DIR__. '/../../models/connexion.php';	
// require_once __DIR__. '/../../models/package.php';
// require_once __DIR__. '/../../models/possede.php';

$conn = Database::getInstance()->getConnection();


// $conn = getConnection();
// $danger = new Danger();
$atelier = new Atelier();
$produit = new Produit();
$contenir = new Contenir();
$package = new Package();
$danger = new Danger();

$idusine = $_SESSION['idusine'];
// $idprod = $_GET['idprod'];
$infoproduit = $produit->OneProduct($conn, $idprod);

$allAtelier = $atelier->AllAtelier($conn, $idusine);



$allDangers = $danger->all($conn); // tous les dangers
$linkedDangers = $danger->getDangersByProduitId($conn, $idprod); // dangers du produit

// On extrait juste les ID pour vérifier les sélectionnés
$selectedIds = array_column($linkedDangers, 'iddanger');


// $allAteliers = $atelier-($conn); // tous les ateliers
$linkedAteliers = $atelier->getAteliersByProduitId($conn, $idprod); // ceux liés au produit
$selectedAtelierIds = array_column($linkedAteliers, 'idatelier');

$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (strpos($current_page, 'product/edit') === 0) {
    $message = "<span class='fs-4'> Modificaion du Produit " . $infoproduit['nomprod'] . "</span>";
    $chemin = '/product/edit-product/' . $idChiffre;
    // $chemin = ''
}

// die();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS principaux -->
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css">

    <!-- Librairies nécessaires UNIQUEMENT -->
    <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css">


    <!-- jQuery d'abord ! -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div id="preloader">
        <div class="loader">
            <div class="dots">
                <div class="dot mainDot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    <div id="main-wrapper">

        <?php require_once __DIR__ . '/../../layouts/navbar.php' ?>

        <?php require_once __DIR__ . '/../../layouts/dlabnav.php'; ?>


        <form action="/product/edit-product" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="chemin" value="<?= $chemin ?>">
            <input type="hidden" name="idprod" value="<?= $infoproduit['idprod'] ?>">
            <div class="content-body">


                <div class="container-fluid">
                    <div class="row">
                        <?php
                        // echo $message_succes;
                        
                        ?>
                        <?php

                        if (isset($_SESSION['insert']['type'])) {
                            switch ($_SESSION['insert']['type']) {
                                case "insertfalse":
                                    echo $package->message("Problème lors de l'insertion", "danger");
                                    break;
                                case "insertok":
                                    echo $package->message("Le produit a été ajouté avec succès", "success");
                                    break;
                                case "updateok":
                                    echo $package->message("Le produit a été modifié avec succès", "success");
                                    break;
                                case "updatefailed":
                                    echo $package->message("Problème lors de la modification", "danger");
                                    break;
                                case "extension":
                                    echo $package->message("L'extension de l'image n'est pas valide", "danger");
                                    break;
                                case "doublonProduit":
                                    echo $package->message("Ce produit existe déjà", "danger");
                                    break;
                                case "erreur uploadphoto":
                                    echo $package->message("Problème lors de l'envoi de la photo", "danger");
                                    break;
                                case "volumineux":
                                    echo $package->message("Fichier trop volumineux", "danger");
                                    break;
                                case "doublonPhoto":
                                    $nomproduit = isset($_SESSION['insert']['insert']) ? $_SESSION['insert']['insert'] : '';
                                    echo $package->message("Cette photo est déjà associée au produit <strong>$nomproduit</strong>", "danger");
                                    break;
                                case "erreur upload fds":
                                    echo $package->message("Erreur lors de la sauvegarde de la FDS", "danger");
                                    break;
                                case "extensionFDS":
                                    echo $package->message("Veuillez choisir un fichier d'extension <strong>.pdf</strong>", "danger");
                                    break;
                                case "doublonsFDS":
                                    $nomproduitFDS = isset($_SESSION['insert']['insert']) ? $_SESSION['insert']['insert'] : '';
                                    echo $package->message("Cette FDS est déjà associée au produit <strong>$nomproduitFDS</strong>", "danger");
                                    break;
                            }
                        }
                        unset($_SESSION['insert']);
                        ?>


                        <div class="col-xl-12">
                            <div class="shadow-lg card">
                                <div class="card-header">
                                    <h5 class="mb-0">Details du produit</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-4">
                                            <label style="font-weight: 700;" class="form-label text-primary">Photo<span
                                                    class="required">*</span></label>
                                            <div class="avatar-upload">
                                                <?php
                                                // var_dump($infoproduit['photo']); // Pour déboguer
                                                ?>
                                                <div class="avatar-preview">
                                                    <?php
                                                    $photoPath = '/uploads/photo/' . $infoproduit['photo'];
                                                    $pdfPath = '/uploads/pdf/' . $infoproduit['fds'];
                                                    ?>
                                                    <div id="imagePreview"
                                                        style="background-image: url('<?= $photoPath ?>');">
                                                    </div>
                                                </div>


                                                <input type="file" name="imageUpload" class="form-control d-none"
                                                    accept="image/*" id="imageUpload">
                                                <label style="font-weight: 700;" for="imageUpload"
                                                    class="btn btn-primary mt-2 btn-sm">Choisir la photo</label>
                                                <a href="javascript:void"
                                                    class="btn btn-danger light remove-img ms-2 btn-sm">Retirer</a>

                                            </div>




                                        </div>
                                        <div class="col-xl-9 col-lg-8">
                                            <div class="row">
                                                <div class="col-xl-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                            class="form-label text-primary">Nom du produit<span
                                                                class="required">*</span></label>
                                                        <input type="text" class="form-control" name="nom" id="nom"
                                                            placeholder="Le nom du produit" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                echo $_SESSION['insert']['info']['nom'];
                                                            } else {
                                                                echo $infoproduit['nomprod'];
                                                            } ?>">
                                                        <span class="fw-bold text-danger" id="messageNom"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;"
                                                            class="form-label text-primary">Emballage et Poids/Volume du
                                                            produit<span class="required">*</span></label>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control" name="emballage"
                                                                    placeholder="Type d'Emballage" id="emballage" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['emballage'];
                                                                    } else {
                                                                        echo $infoproduit['type_emballage'];
                                                                    } ?>">
                                                                <span class="fw-bold text-danger" id="messageEmballage"
                                                                    style="display: none;"></span>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control w-50 ms-3"
                                                                    name="vol" id="vol" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['vol'];
                                                                    } else {
                                                                        echo $infoproduit['poids'];
                                                                    } ?>" placeholder="Vol/Poids">
                                                                <span class="fw-bold text-danger" id="messageVol"
                                                                    style="display: none;"></span>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                            class="form-label text-primary">Danger<span
                                                                class="required">*</span></label>
                                                        <div class="mb-3">
                                                            <select multiple name="danger[]" class="form-control">
                                                                <?php foreach ($allDangers as $danger): ?>
                                                                <?php if (in_array($danger['iddanger'], $selectedIds)) { ?>
                                                                <option value="<?= $danger['iddanger'] ?>" selected>
                                                                    <?= htmlspecialchars($danger['nomdanger']) ?>
                                                                </option>
                                                                <?php } else { ?>
                                                                <option value="<?= $danger['iddanger'] ?>">
                                                                    <?= htmlspecialchars($danger['nomdanger']) ?>
                                                                </option>
                                                                <?php } ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <span id="messageDanger" class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                            <span id="message-conflit-danger"
                                                                class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                        </div>
                                                        <!-- <span class="fw-bold text-danger" id="messageDanger" style="display: none;"></span> -->
                                                    </div>


                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="risque"
                                                            class="form-label text-primary">Risque<span
                                                                class="required">*</span></label>
                                                        <textarea class="form-control" name="risque" id="risque"
                                                            rows="6"> <?php if (isset($_SESSION['insert']['info'])) {
                                                                echo $_SESSION['insert']['info']['risque'];
                                                            } else {
                                                                echo $infoproduit['risque'];
                                                            } ?></textarea>
                                                        <span class="fw-bold text-danger" id="messageRisque"
                                                            style="display: none;"></span>
                                                    </div>

                                                </div>
                                                <div class="col-xl-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;"
                                                            class="form-label text-primary">Fabircant et Nature du
                                                            produit<span class="required">*</span></label>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control"
                                                                    name="fabriquant" placeholder="Fabricant"
                                                                    id="fabriquant" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['fabriquant'];
                                                                    } else {
                                                                        echo $infoproduit['fabriquant'];
                                                                    } ?> ">
                                                                <span class="fw-bold text-danger" id="messageFabriquant"
                                                                    style="display: none;"></span>
                                                            </div>

                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control w-50 ms-3"
                                                                    name="nature" id="nature" placeholder="Nature"
                                                                    value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['nature'];
                                                                    } else {
                                                                        echo $infoproduit['nature'];
                                                                    } ?>">
                                                                <span class="fw-bold text-danger" id="messageNature"
                                                                    style="display: none;"></span>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="utilisation"
                                                            class="form-label text-primary">Utilisation<span
                                                                class="required">*</span></label>
                                                        <textarea class="form-control" name="utilisation"
                                                            id="utilisation" rows="6"><?php if (isset($_SESSION['insert']['info'])) {
                                                                echo $_SESSION['insert']['info']['utilisation'];
                                                            } else {
                                                                echo $infoproduit['utilisation'];
                                                            } ?></textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="DispoFDS"
                                                            class="form-label text-primary">Disponibilité FDS<span
                                                                class="required">*</span></label>
                                                        <div class="mb-3">
                                                            <select
                                                                class="default-select form-control wide form-control-sm"
                                                                name="DispoFDS" id="DispoFDS">
                                                                <option value="oui">OUI</option>
                                                                <option value="non">NON</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3" id="FDSDisplay">

                                                        <label style="font-weight: 700;"
                                                            class="form-label text-primary">Fichier PDF <span
                                                                class="required">*</span></label>
                                                        <div class="pdf-upload">
                                                            <div class="pdf-preview mt-2" id="pdfPreview">
                                                                <?php if (!empty($infoproduit['fds'])): ?>

                                                                <div class="mt-3">
                                                                    <object id="pdfViewer" data="<?= $pdfPath ?>"
                                                                        type="application/pdf" width="100%"
                                                                        height="400px" style="border: 1px solid #ccc;">
                                                                    </object>
                                                                </div>
                                                                <?php else: ?>
                                                                <p class="text-danger">Aucun fichier PDF disponible</p>
                                                                <?php endif; ?>
                                                            </div>

                                                            <input type="file" name="pdfUpload"
                                                                class="form-control d-none" accept="application/pdf"
                                                                id="pdfUpload">
                                                            <span id="messageFDS" class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                            <label style="font-weight: 700;" for="pdfUpload"
                                                                class="btn btn-primary mt-2 btn-sm">Choisir le
                                                                PDF</label>
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-danger light remove-pdf ms-2 btn-sm">Retirer</a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="submit" id="submitBtn" class="btn btn-primary">Soumettre</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <script>
    // Débogage du chemin du PDF
    console.log("Chemin du PDF:", "<?= $pdfPath ?>");

    $(document).ready(function() {
        <?php if (!empty($infoproduit['fds'])): ?>
        $('#pdfPreview').show();
        // Vérifier si le PDF est accessible
        $.ajax({
            url: '<?= $pdfPath ?>',
            type: 'HEAD',
            success: function() {
                console.log("PDF accessible");
            },
            error: function(xhr, status, error) {
                console.error("Erreur d'accès au PDF:", error);
                $('#pdfPreview').html(
                    '<div class="alert alert-danger">' +
                    '<p>Le PDF n\'est pas accessible. Erreur: ' + error + '</p>' +
                    '<p>URL: <?= $pdfPath ?></p>' +
                    '</div>'
                );
            }
        });
        <?php endif; ?>

        // Validation du formulaire
        $('form').on('submit', function(e) {
            let isValid = true;

            // Validation du nom
            if ($('#nom').val().trim() === '') {
                $('#messageNom').text('Le nom du produit est requis').show();
                isValid = false;
            } else {
                $('#messageNom').hide();
            }

            // Validation de l'emballage
            if ($('#emballage').val().trim() === '') {
                $('#messageEmballage').text('Le type d\'emballage est requis').show();
                isValid = false;
            } else {
                $('#messageEmballage').hide();
            }

            // Validation du volume/poids
            if ($('#vol').val().trim() === '') {
                $('#messageVol').text('Le volume/poids est requis').show();
                isValid = false;
            } else {
                $('#messageVol').hide();
            }

            // Validation des dangers
            if ($('select[name="danger[]"]').val() === null || $('select[name="danger[]"]').val()
                .length === 0) {
                $('#messageDanger').text('Veuillez sélectionner au moins un danger').show();
                isValid = false;
            } else {
                $('#messageDanger').hide();
            }

            // Validation du risque
            if ($('#risque').val().trim() === '') {
                $('#messageRisque').text('Le risque est requis').show();
                isValid = false;
            } else {
                $('#messageRisque').hide();
            }

            // Validation du fabricant
            if ($('#fabriquant').val().trim() === '') {
                $('#messageFabriquant').text('Le fabricant est requis').show();
                isValid = false;
            } else {
                $('#messageFabriquant').hide();
            }

            // Validation de la nature
            if ($('#nature').val().trim() === '') {
                $('#messageNature').text('La nature du produit est requise').show();
                isValid = false;
            } else {
                $('#messageNature').hide();
            }

            // Validation de l'utilisation
            if ($('#utilisation').val().trim() === '') {
                $('#messageUtilisation').text('L\'utilisation est requise').show();
                isValid = false;
            } else {
                $('#messageUtilisation').hide();
            }

            // Validation de la photo si une nouvelle est sélectionnée
            if ($('#imageUpload')[0].files.length > 0) {
                const file = $('#imageUpload')[0].files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    $('#messagePhoto').text('Format d\'image non valide. Utilisez JPG, PNG ou GIF')
                        .show();
                    isValid = false;
                } else {
                    $('#messagePhoto').hide();
                }
            }

            // Validation de la FDS si une nouvelle est sélectionnée
            if ($('#DispoFDS').val() === 'oui' && $('#pdfUpload')[0].files.length > 0) {
                const file = $('#pdfUpload')[0].files[0];
                if (file.type !== 'application/pdf') {
                    $('#messageFDS').text('Format de fichier non valide. Utilisez PDF').show();
                    isValid = false;
                } else {
                    $('#messageFDS').hide();
                }
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }
        });

        // Gestion de l'affichage du champ FDS
        $('#DispoFDS').change(function() {
            if ($(this).val() === 'oui') {
                $('#FDSDisplay').show();
            } else {
                $('#FDSDisplay').hide();
                $('#pdfUpload').val('');
                $('#pdfPreview').hide();
            }
        });

        // Initialisation de l'affichage du champ FDS
        if ($('#DispoFDS').val() === 'non') {
            $('#FDSDisplay').hide();
        }
    });

    function readPDF(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if (file.type === "application/pdf") {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#pdfViewer').attr('data', e.target.result);
                    $('#pdfPreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                alert("Veuillez sélectionner un fichier PDF.");
                input.value = "";
            }
        }
    }

    $("#pdfUpload").change(function() {
        readPDF(this);
    });

    $(".remove-pdf").on("click", function() {
        $('#pdfUpload').val('');
        $('#pdfViewer').attr('data', '');
        $('#pdfPreview').hide();
    });


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
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
        var
            imageUrl = "images/no-img-avatar.png";
        $('.avatar-preview, #imagePreview').removeAttr('style');
        $('#imagePreview').css('background-image', 'url(' + imageUrl + ')');
    });
    </script>
    <?php unset($_SESSION['photo'], $_SESSION['insert']) ?>


    <!-- <script src="/../../vendor/global/global.min.js"></script>
    <script src="/../../vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="/../../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/../../vendor/apexchart/apexchart.js"></script>
    <script src="/../../vendor/peity/jquery.peity.min.js"></script>
    <script src="/../../vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="/../../vendor/swiper/js/swiper-bundle.min.js"></script>
    <script src="/../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/../../js/plugins-init/datatables.init.js"></script>
    <script src="/../../js/dashboard/dashboard-1.js"></script>
    <script src="/../../vendor/wow-master/dist/wow.min.js"></script>
    <script src="/../../vendor/bootstrap-datetimepicker/js/moment.js"></script>
    <script src="/../../vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/../../vendor/bootstrap-select-country/js/bootstrap-select-country.min.js"></script>
    <script src="/../../js/dlabnav-init.js"></script>
    <script src="/../../js/custom.min.js"></script>
    <script src="/../../js/demo.js"></script>
    <script src="/../../js/new-product.js"></script> -->


    <?php
    require_once __DIR__ . '/../../utilities/all-js.php';
    if (isset($_SESSION['photo']['photo'])) {
        echo $photo = $_SESSION['photo']['photo'];
    }

    ?>