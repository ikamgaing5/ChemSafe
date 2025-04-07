<button type="button" class="btn btn-primary shadow  mx-1" href="#add-product" data-bs-toggle="modal" data-bs-target="#add-product">+ Ajout produit(s)</button>



<div class="modal fade " id="add-product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelAdd-product" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabelAdd-product">Selectionner le ou les produit(s) à ajouter</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>    
            <form class="form" method="POST" action="/product/add"> 
                <div class="modal-footer">
                    <input type="hidden" name="idatelier" value="<?=$idatelier?>">
                    <span class="text-danger fs-6 fw-bold d-flex justify-md-between justify-md-start" id="messageProduit" style="display:none;"></span>
                    <select multiple name="produit[]" class="default-select form-control wide form-control-sm mb-3" id="produit">
                        <?php 
                            foreach ($produitsNonAssocies as $produits) { 
                                echo "<option value=\"{$produits['idprod']}\">" . htmlspecialchars($produits['nomprod']) . "</option>";
                            }
                        ?>
                    </select>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" id="submitBtn" disabled name="Envoyez" class="btn btn-primary" value="Ajouter">
                </div>
            </form>
        </div>
    </div>
</div>