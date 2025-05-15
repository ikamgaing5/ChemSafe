<a class="btn btn-danger shadow btn-xs sharp me-1" href="#supp<?= IdEncryptor::encode($prod['idprod']) ?>"
    data-bs-toggle="modal" data-bs-target="#supp<?= IdEncryptor::encode($prod['idprod']) ?>"><i
        class="bi bi-trash"></i></a>
<div class="modal fade " id="supp<?= IdEncryptor::encode($prod['idprod']) ?>" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel<?= IdEncryptor::encode($prod['idprod']) ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel<?= IdEncryptor::encode($prod['idprod']) ?>">Cette action
                    supprimera <strong><?= $prod['nomprod'] ?></strong> de tous les ateliers, confirmez votre choix.</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php
            // $info = $admin -> oneAdmin($conn,$prod['idprod']);
            ?>
            <form class="form" method="POST" action="/product/delete-everywhere">
                <div class="modal-footer">
                    <input type="hidden" name="id" value="<?= $prod['idprod'] ?>">
                    <input type="hidden" name="nomprod" value="<?= $prod['nomprod'] ?>">
                    <input type="hidden" name="fds" value="<?= $prod['fds'] ?>">
                    <input type="hidden" name="photo" value="<?= $prod['photo'] ?>">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" name="Envoyez" class="btn btn-danger" value="Supprimer">
                </div>
            </form>
        </div>
    </div>
</div>