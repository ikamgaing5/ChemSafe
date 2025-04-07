<button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#edit">
  Editer
</button>

<!-- Modal -->
<div class="modal fade" id="edit" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/workshop/edit" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modification de l'atelier <strong></strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label text-secondary">Nom de l'atelier: </label>
                    <input type="hidden" name="idatelier" value="">
                    <input type="text" class="form-control" name="nom" id="" >
                    <input type="hidden" name="oldvalue" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>