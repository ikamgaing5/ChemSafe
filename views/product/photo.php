<button type="button" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalPhotoProduit<?= $prod['idprod'] ?>">
    <i class="bi bi-file-image"></i>
</button>

<!-- Modal Bootstrap -->
<div class="modal fade" id="modalPhotoProduit<?= $prod['idprod'] ?>" tabindex="-1" aria-labelledby="photoModalLabel<?= $prod['idprod'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalLabel<?= $prod['idprod'] ?>">Photo du produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body text-center">
        <img src="../../uploads/photo/<?= htmlspecialchars($prod['photo']) ?>" alt="Photo du produit" 
             class="img-fluid rounded shadow" 
             style="max-width: 100%; max-height: 80vh; object-fit: contain;" loading="lazy">
      </div>
    </div>
  </div>
</div>





