<?php
if (!empty($prod['photo']) && file_exists(__DIR__ . "/../../uploads/photo/" . $prod['photo'])) { ?>
<button type="button" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
    data-bs-target="#modalPhotoProduit<?= $prod['idprod'] ?>">
    <i class="bi bi-file-image"></i>
</button>

<!-- Modal Bootstrap -->
<div class="modal fade" id="modalPhotoProduit<?= $prod['idprod'] ?>" tabindex="-1"
    aria-labelledby="photoModalLabel<?= $prod['idprod'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel<?= $prod['idprod'] ?>">Photo de <?= $prod['nomprod'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                <img src="../../uploads/photo/<?= htmlspecialchars($prod['photo']) ?>" alt="Photo du produit"
                    class="img-fluid rounded shadow" style="max-width: 100%; max-height: 80vh; object-fit: contain;"
                    loading="lazy">
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
<button type="button" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal"
    data-bs-target="#modalPhotoProduit<?= $prod['idprod'] ?>">
    <i class="bi bi-plus-lg"></i>
</button>

<div class="modal fade" id="modalPhotoProduit<?= $prod['idprod'] ?>" tabindex="-1"
    aria-labelledby="modalPhotoProduit<?= $prod['idprod'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPhotoProduit<?= $prod['idprod'] ?>">Ajout de la Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                <form action="/product/updatePhoto" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idprod" value="<?= $prod['idprod'] ?>">
                    <input type="hidden" name="chemin" value="<?= $chemin ?>">

                    <!-- Zone de prévisualisation -->
                    <div class="image-preview-container mb-3" id="imagePreviewContainer<?= $prod['idprod'] ?>"
                        style="display: none;">
                        <img id="imagePreview<?= $prod['idprod'] ?>" src="#" alt="Prévisualisation"
                            class="img-fluid rounded shadow" style="max-height: 300px; object-fit: contain;">
                    </div>

                    <input type="file" required name="imageUpload" class="form-control d-none" accept="image/*"
                        id="imageUpload<?= $prod['idprod'] ?>" onchange="previewImage(this, '<?= $prod['idprod'] ?>')">

                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <label for="imageUpload<?= $prod['idprod'] ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-upload me-1"></i>Choisir la photo
                        </label>

                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="clearImagePreview('<?= $prod['idprod'] ?>')">
                            <i class="bi bi-trash me-1"></i>Retirer
                        </button>

                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input, idprod) {
    const preview = document.getElementById('imagePreview' + idprod);
    const container = document.getElementById('imagePreviewContainer' + idprod);

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function clearImagePreview(idprod) {
    const input = document.getElementById('imageUpload' + idprod);
    const preview = document.getElementById('imagePreview' + idprod);
    const container = document.getElementById('imagePreviewContainer' + idprod);

    input.value = '';
    preview.src = '#';
    container.style.display = 'none';
}
</script>
<?php }
// Nettoyer les variables de session après utilisation
if (isset($_SESSION['photo_error'])) {
  unset($_SESSION['photo_error']);
}
if (isset($_SESSION['photo_success'])) {
  unset($_SESSION['photo_success']);
}
?>