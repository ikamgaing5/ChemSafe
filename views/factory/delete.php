<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supp<?=$key['idusine']?>">
  Supprimer
</button>

<!-- Modal -->
<div class="modal fade" id="supp<?=$key['idusine']?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <form action="/workshop/delete" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression de l'Usine <strong><?=$key['nom']?></strong> </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voulez-vous réellement supprimer l'<strong><?=$key['nom']?></strong> ?
                <input type="hidden" name="idusine" value="<?=$key['idusine']?>">
                <input type="hidden" name="nom" value="<?=$key['nom']?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Supprimer</button>
            </div>
        </div>
    </form>
  </div>
</div>