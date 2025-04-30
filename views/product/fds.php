<?php if (!empty($prod['fds']) && file_exists(__DIR__. "/../../uploads/pdf/" . $prod['fds'])) { ?>
    <button type="button" class="btn btn-danger shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalFDS<?= $prod['idprod'] ?>">
        <i class="bi bi-file-pdf-fill"></i>
    </button>


  <!-- Modal Bootstrap -->
  <div class="modal fade" id="modalFDS<?= $prod['idprod'] ?>" tabindex="-1" aria-labelledby="modalFDS<?= $prod['idprod'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFDS<?= $prod['idprod'] ?>">FDS du produit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body text-center">
            <iframe 
              src="../../uploads/pdf/<?= htmlspecialchars($prod['fds']) ?>" 
              style="width: 100%; height: 75vh; border: none;"
              title="FDS PDF">
            </iframe>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?> 
  <?php if (isset($_SESSION['insert']['openModal'])): ?>
  <script>
    $(document).ready(function () {
      $('#modalFDS<?= $_SESSION['insert']['openModal'] ?>').modal('show');
    });
  </script>
<?php 
  unset($_SESSION['insert']['openModal']); // pour ne pas réouvrir à chaque reload
endif; ?>

  <button type="button" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalFDS<?= $prod['idprod'] ?>">
  <i class="bi bi-plus-lg"></i>
</button>

<div class="modal fade" id="modalFDS<?= $prod['idprod'] ?>" tabindex="-1" aria-labelledby="modalFDS<?= $prod['idprod'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFDS<?= $prod['idprod'] ?>">Ajout de la FDS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body text-center">
        <form action="/product/updateFDS" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="idprod" value="<?=$prod['idprod']?>" >
          <input type="hidden" name="chemin" value="<?=$chmein?>">
          <div class="pdf-preview mt-2" id="pdfPreview<?= $prod['idprod'] ?>" style="display: none;">
            <iframe id="pdfViewer<?= $prod['idprod'] ?>" src="" width="100%" height="400px" style="border: 1px solid #ccc;"></iframe>
          </div>

          <input type="file" required name="pdfUpload" class="form-control d-none" accept="application/pdf" id="pdfUpload<?= $prod['idprod'] ?>">
          <span id="messageFDS<?= $prod['idprod'] ?>" class="text-danger fw-bold" style="display:none;"></span>

          <label style="font-weight: 700;" for="pdfUpload<?= $prod['idprod'] ?>" class="btn btn-secondary mt-2 btn-sm">Choisir le PDF</label>

          <a href="javascript:void(0)" class="btn btn-danger light remove-pdf ms-2 btn-sm" data-target="<?= $prod['idprod'] ?>">Retirer</a>
          
          <input type="submit" value="Ajouter" class="btn btn-primary light ms-2 btn-sm" data-target="<?= $prod['idprod'] ?>">
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {

    function readPDF(input, targetId) {
      if (input.files && input.files[0]) {
        const file = input.files[0];
        console.log("Chargement du fichier :", file.name, file.type);

        if (file.type === "application/pdf") {
          const reader = new FileReader();
          reader.onload = function (e) {
            $('#pdfViewer' + targetId).attr('src', e.target.result);
            $('#pdfPreview' + targetId).fadeIn(300);
          };
          reader.readAsDataURL(file);
        } else {
          alert("Veuillez sélectionner un fichier PDF.");
          input.value = ""; // reset
        }
      }
    }

    $("[id^='pdfUpload']").change(function () {
      const targetId = $(this).attr('id').replace('pdfUpload', '');
      readPDF(this, targetId);
    });

    $(".remove-pdf").on("click", function () {
      const targetId = $(this).data("target");
      $('#pdfUpload' + targetId).val('');
      $('#pdfViewer' + targetId).attr('src', '');
      $('#pdfPreview' + targetId).fadeOut(300);
    });

  });
</script>

<?php } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
