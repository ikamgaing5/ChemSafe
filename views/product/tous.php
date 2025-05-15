<?php
// Connexion à la base de données (exemple)
// require_once '../../config/db.php';
// require_once '../../controllers/ProduitController.php';

// $controller = new ProduitController();
require_once __DIR__ . '/../../utilities/session.php';


// require_once __DIR__. '/../../core/connexion.php';
require_once __DIR__ . '/../../models/atelier.php';
require_once __DIR__ . '/../../models/produit.php';
require_once __DIR__ . '/../../models/contenir.php';
require_once __DIR__ . '/../../models/connexion.php';
require_once __DIR__ . '/../../models/package.php';

$conn = Database::getInstance()->getConnection();


// $conn = getConnection();
$atelier = new Atelier();
$produit = new Produit();
$contenir = new Contenir();
$package = new Package();

// Paramètres de pagination
$limit = 50; // nombre de produits par page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Récupération des produits paginés
$produits = $produit->getProduitsPagines($conn, $limit, $offset);

// Récupération du nombre total de produits pour la pagination
$totalProduits = $produit->countProduits($conn);
$totalPages = ceil($totalProduits / $limit);

// Compter le total de produits pour la pagination
$total = $conn->query("SELECT COUNT(DISTINCT p.idprod) FROM produit p")->fetchColumn();
$nbPages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Liste des Produits</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container">
    <h4>Produits / Liste Des Produits</h4>
    <!-- <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom Du Produit</th>
                <th>Type d'emballage</th>
                <th>Ateliers</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $prod): ?>
            <tr>
                <td><?= htmlspecialchars($prod['nomprod']) ?></td>
                <td><?= htmlspecialchars($prod['type_emballage']) ?></td>
                <td><?= htmlspecialchars($prod['ateliers']) ?></td>
                <td>
                    <button type="button" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalPhotoProduit<?= $prod['idprod'] ?>">
                        <i class="bi bi-file-image"></i>
                    </button>

                    <div class="modal fade" id="modalPhotoProduit<?= $prod['idprod'] ?>" tabindex="-1" aria-labelledby="photoModalLabel<?= $prod['idprod'] ?>" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="photoModalLabel<?= $prod['idprod'] ?>">Photo du produit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                          </div>
                          <div class="modal-body text-center">
                            <img src="../../uploads/photo/<?= htmlspecialchars($prod['photo']) ?>" alt="Photo du produit" class="img-fluid rounded shadow" style="max-width: 100%; max-height: 80vh; object-fit: contain;" loading="lazy">
                          </div>
                        </div>
                      </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table> -->

    <table table-striped>
      <tr>
        <th>Nom</th>
        <th>Emballage</th>
        <th>Ateliers</th>
        <th>Voir FDS</th>
        <th>Voir Photo</th>
      </tr>
      <?php
      foreach ($produits as $prod) {
        ?>
        <tr>
          <td><?= $prod['nomprod'] ?></td>
          <td><?= $prod['type_emballage'] ?></td>
          <td><?= $prod['ateliers'] ?></td>
          <td><?php require __DIR__ . '/photo.php' ?></td>
          <td><button type='button' class='btn btn-primary shadow btn-xs sharp me-1' data-bs-toggle='modal'
              data-bs-target='#modalPhotoProduit<?= $prod['idprod'] ?>'>Voir Photo</button></td>
        </tr>

        <!-- Modal Bootstrap Photo -->
        <div class="modal fade" id="modalPhotoProduit<?= $prod['idprod'] ?>" tabindex="-1"
          aria-labelledby="photoModalLabel<?= $prod['idprod'] ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel<?= $prod['idprod'] ?>">Photo du produit</h5>
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
        <!-- Modal Bootstrap FDS -->
        <div class="modal fade" id="modalFDSProduit<?= $prod['idprod'] ?>" tabindex="-1"
          aria-labelledby="fdsModalLabel<?= $prod['idprod'] ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="fdsModalLabel<?= $prod['idprod'] ?>">Fiche de Sécurité du produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
              </div>
              <div class="modal-body text-center">
                <iframe src="../../uploads/fds/<?= htmlspecialchars($prod['fds']) ?>" style="width:100%; height:80vh;"
                  frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>

      <?php }
      echo "</table>";
      ?>

      <nav>
        <ul class="pagination">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>