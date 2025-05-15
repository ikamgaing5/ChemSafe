<?php

$conn = Database::getInstance()->getConnection();

class ProductController
{
    private $package;
    private $conn;
    private $produit;
    private $contenir;
    private $danger;
    private $possede;


    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->danger = new Danger();
        $this->package = new Package;
        $this->produit = new Produit;
        $this->possede = new Possede();
        $this->contenir = new Contenir();
    }

    public function Insert()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $photo = NULL;
            $fds = NULL;
            $filePhoto = $this->package->filtrer($_FILES['imageUpload']['name']);

            if ($_POST['DispoFDS'] === "oui" && !empty($_FILES['pdfUpload']['name'])) {
                $fileFds = $this->package->filtrer($_FILES['pdfUpload']['name']);
                $fdsUpload = $this->package->fds($fileFds);

                if ($fdsUpload !== 1) {
                    if ($fdsUpload == -5) {
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = "erreur upload fds";
                        $_SESSION['insert']['info'] = $_POST;
                        // "aucun fichier";
                        Route::redirect('/product/new-product');
                    } elseif ($fdsUpload == -1) {
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = "extensionFDS";
                        $_SESSION['insert']['info'] = $_POST;
                        // "extension";
                        Route::redirect('/product/new-product');
                    } elseif ($fdsUpload == -2) {
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = "doublonsFDS";
                        $_SESSION['insert']['insert'] = $fileFds;
                        $_SESSION['insert']['info'] = $_POST;
                        // "déjà en bd";
                        Route::redirect('/product/new-product');
                    }
                } else {
                    // echo 'ok';
                    $fds = $fileFds;
                }
            } else {
                $fds = NULL;
            }


            $photoUpload = $this->package->photos($filePhoto);
            // var_dump($photoUpload);
            // var_dump($_POST);
            // var_dump($_FILES);

            if ($photoUpload !== 1) {
                if ($photoUpload == -5) {
                    $_SESSION['insert'] = [];
                    $_SESSION['insert']['type'] = "erreur uploadphoto";
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                } elseif ($photoUpload == -1) {
                    $_SESSION['insert'] = [];
                    $_SESSION['insert']['type'] = "extension";
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                } elseif ($photoUpload == -2) {
                    $_SESSION['insert'] = [];
                    $_SESSION['insert']['type'] = "doublonPhoto";
                    $_SESSION['insert']['insert'] = $filePhoto;
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                } elseif ($photoUpload == -3) {
                    $_SESSION['insert']['type'] = "volumineuxPhotos";
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                }
            } else {
                // L'image est valide, on stocke juste le nom pour la suite
                $photo = $filePhoto;
            }


            $nom = $this->package->filtrer($_POST['nom']);
            $emballage = $this->package->filtrer($_POST['emballage']);
            $vol = $this->package->filtrer($_POST['vol']);
            $dangers = $_POST['danger'];
            // Convertir le tableau en une chaîne avec des virgules comme séparateur
            $danger = implode(", ", $dangers);
            $atelier = $_POST['atelier'];
            $nature = $this->package->filtrer($_POST['nature']);
            $risque = $this->package->filtrer($_POST['risque']);
            $fabriquant = $this->package->filtrer($_POST['fabriquant']);
            $utilisation = $this->package->filtrer($_POST['utilisation']);
            $requete = $this->produit->create($this->conn, $nom, $emballage, $vol, $nature, $utilisation, $fabriquant, $photo, $fds, $danger, $risque);

            if ($requete == 1) {
                // upload de la photo après l'insertion en bd
                move_uploaded_file($_FILES["imageUpload"]["tmp_name"], __DIR__ . '/../uploads/photo/' . basename($photo));
                // upload de la fds après l'insertion et si le champ disponibilité est à OUI
                if ($fds !== NULL && isset($_FILES["pdfUpload"]["tmp_name"])) {
                    move_uploaded_file($_FILES["pdfUpload"]["tmp_name"], __DIR__ . '/../uploads/pdf/' . basename($fds));
                }
                $idprod = $this->produit->getIdProductByName($this->conn, $nom);

                foreach ($atelier as $key) {
                    $this->contenir->Insert($this->conn, $idprod, $key);
                }
                foreach ($dangers as $key) {
                    $this->possede->add($this->conn, $key, $idprod);
                }

                if ($_POST['DispoFDS'] === "oui" && !empty($_FILES['pdfUpload']['name'])) {
                    $_SESSION['insert'] = [];
                    $_SESSION['insert']['nom'] = $nom;
                    $_SESSION['insert']['type'] = "insertok";
                    Route::redirect('/info-fds/new-info-fds/' . IdEncryptor::encode($this->produit->getIdProductByName($this->conn, $nom)));
                } else {
                    $_SESSION['insert'] = [];
                    $_SESSION['insert']['id'] = $this->produit->getIdProductByName($this->conn, $nom);
                    $_SESSION['insert']['type'] = "insertok";
                    Route::redirect("/" . $_SESSION['chemin']);
                }

            } elseif ($requete == 0) {
                $_SESSION['insert'] = [];
                $_SESSION['insert']['type'] = "insertfalse";
                $_SESSION['insert']['info'] = $_POST;
                Route::redirect('/product/new-product');
            } else {
                $_SESSION['insert'] = [];
                $_SESSION['insert']['info'] = $_POST;
                $_SESSION['insert']['type'] = 'doublonProduit';
                Route::redirect('/product/new-product');
            }



        } else {
            require_once __DIR__ . '/../views/product/new-product.php';
        }
    }

    public function deleteFromWorkshop()
    {
        $id = $_POST['id'];
        $_SESSION['info'] = [];
        $_SESSION['info']['nomprod'] = $_POST['nomprod'];
        $_SESSION['info']['nomatelier'] = $_POST['nomatelier'];
        $idatelier = $_POST['idatelier'];
        $cryptedId = IdEncryptor::encode($idatelier);
        if ($this->contenir->Delete($this->conn, $id)) {
            $_SESSION['info']['type'] = 'deletesuccess';
            Route::redirect("/all-products/$cryptedId");
        } else {
            $_SESSION['info']['type'] = 'deletefailed';
            Route::redirect("/all-products/$cryptedId");
        }

    }

    public function delete()
    {
        $id = $_POST['id'];
        $_SESSION['info'] = [];
        $_SESSION['info']['nomprod'] = $_POST['nomprod'];
        $fds = $_POST['fds'];
        $photo = $_POST['photo'];

        if ($fds == NULL) {
            if ($this->contenir->Delete($this->conn, $id) && $this->possede->delete($this->conn, $id) && $this->produit->Delete($this->conn, $id) && $this->package->deleteFiles($photo, "photo")) {
                $_SESSION['info']['type'] = 'deletesuccess';
                Route::redirect("/product/all-product");
            } else {
                $_SESSION['info']['type'] = 'deletefailed';
                Route::redirect("/product/all-product");
            }
        } else {
            if ($this->contenir->Delete($this->conn, $id) && $this->possede->delete($this->conn, $id) && $this->produit->Delete($this->conn, $id) && $this->package->deleteFiles($photo, "photo") && $this->package->deleteFiles($photo, "fds")) {
                $_SESSION['info']['type'] = 'deletesuccess';
                Route::redirect("/product/all-product");
            } else {
                $_SESSION['info']['type'] = 'deletefailed';
                Route::redirect("/product/all-product");
            }
        }
    }


    public function update($params)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $photo = NULL;
            $fds = NULL;
            $chemin = $_POST['chemin'];
            $filePhoto = $this->package->filtrer($_FILES['imageUpload']['name']);

            if ($_POST['DispoFDS'] === "oui" && !empty($_FILES['pdfUpload']['name'])) {
                $fileFds = $this->package->filtrer($_FILES['pdfUpload']['name']);
                $fdsUpload = $this->package->fds($fileFds);

                if ($fdsUpload !== 1) {
                    if ($fdsUpload == -5) {
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = "erreur upload fds";
                        $_SESSION['insert']['info'] = $_POST;
                        // "aucun fichier";
                        Route::redirect($chemin);
                    } elseif ($fdsUpload == -1) {
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['type'] = "extensionFDS";
                        $_SESSION['insert']['info'] = $_POST;
                        // "extension";
                        Route::redirect($chemin);
                    } elseif ($fdsUpload == -2) {
                        $_SESSION['insert'] = [];
                        $_SESSION['insert']['erreur'] = "doublonsFDS";
                        $_SESSION['insert']['insert'] = $fileFds;
                        $_SESSION['insert']['info'] = $_POST;
                        // "déjà en bd";
                        Route::redirect($chemin);
                    }
                } else {
                    // 'ok';
                    $fds = $fileFds;
                }
            } else {
                $fds = NULL;
            }


            $photoUpload = $this->package->photos($filePhoto);
            // var_dump($photoUpload);
            // var_dump($_POST);
            // var_dump($_FILES);

            if ($photoUpload !== 1) {
                if ($photoUpload == -5) {
                    $_SESSION['insert'] = [];
                    echo $_SESSION['insert']['type'] = "erreur uploadphoto";
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                } elseif ($photoUpload == -1) {
                    $_SESSION['insert'] = [];
                    echo $_SESSION['insert']['type'] = "extension";
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                } elseif ($photoUpload == -2) {
                    $_SESSION['insert'] = [];
                    echo $_SESSION['insert']['type'] = "doublonPhoto";
                    $_SESSION['insert']['insert'] = $filePhoto;
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                } elseif ($photoUpload == -3) {
                    echo $_SESSION['insert']['type'] = "volumineux";
                    $_SESSION['insert']['info'] = $_POST;
                    Route::redirect('/product/new-product');
                }
            } else {
                // L'image est valide, on stocke juste le nom pour la suite
                $photo = $filePhoto;
            }


            $nom = $this->package->filtrer($_POST['nom']);
            $emballage = $this->package->filtrer($_POST['emballage']);
            $vol = $this->package->filtrer($_POST['vol']);
            $dangers = $_POST['danger'];
            // Convertir le tableau en une chaîne avec des virgules comme séparateur
            $danger = implode(", ", $dangers);
            $atelier = $_POST['atelier'];
            $nature = $this->package->filtrer($_POST['nature']);
            $risque = $this->package->filtrer($_POST['risque']);
            $fabriquant = $this->package->filtrer($_POST['fabriquant']);
            $utilisation = $this->package->filtrer($_POST['utilisation']);
        } else {
            $idChiffre = $params['idprod'];
            $id = IdEncryptor::decode($idChiffre);

            if (!$id || !is_numeric($id)) {
                // http_response_code(400);
                // echo "ID invalide.";
                require_once __DIR__ . '/../views/404.php';
                return;
            }
            $idprod = $id;
            require_once __DIR__ . '/../views/product/edit.php';
        }

    }

    public function getDangerProducts($params)
    {
        $idChiffre = $params['idatelier'];
        $idatelier = IdEncryptor::decode($idChiffre);

        if (!$idatelier || !is_numeric($idatelier)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID atelier invalide']);
            return;
        }

        $dangerStats = $this->danger->getDangerStatsByAtelier($this->conn, $idatelier);

        // Récupérer les produits par danger
        $productsData = $this->danger->getProductsByDanger($this->conn, $idatelier);

        // Organiser les produits par danger
        $productsByDanger = [];
        foreach ($productsData as $product) {
            if (!isset($productsByDanger[$product['iddanger']])) {
                $productsByDanger[$product['iddanger']] = [
                    'iddanger' => $product['iddanger'],
                    'nomdanger' => $product['nomdanger'],
                    'products' => []
                ];
            }
            $productsByDanger[$product['iddanger']]['products'][] = $product['nomprod'];
        }

        // Ajouter la liste des produits à chaque danger dans les statistics
        foreach ($dangerStats as &$stat) {
            $stat['products'] = isset($productsByDanger[$stat['iddanger']])
                ? $productsByDanger[$stat['iddanger']]['products']
                : [];
        }

        header('Content-Type: application/json');
        echo json_encode($dangerStats);
    }

    public function allss($params)
    {
        $idChiffre = $params['idatelier'];
        $id = IdEncryptor::decode($idChiffre);

        if (!$id || !is_numeric($id)) {
            // http_response_code(400);
            // echo "ID invalide.";
            require_once __DIR__ . '/../views/404.php';
            return;
        }
        $idatelier = $id;
        require_once __DIR__ . '/../views/product/all-product.php';
    }

    public function showWorkshopDangerChart($params)
    {
        $idChiffre = $params['idatelier'];
        $id = IdEncryptor::decode($idChiffre);

        if (!$id || !is_numeric($id)) {
            require_once __DIR__ . '/../views/404.php';
            return;
        }
        $idatelier = $id;


        // Envoyer les données à la vue
        require_once __DIR__ . '/../views/product/add-product copy.php';
    }

    public function getDangerByProducts()
    {
        $iddanger = isset($_GET['iddanger']);
        $resultat = $this->produit->getDangerProducts($this->conn, $iddanger);
        header('Content-Type: application/json');
        echo $resultat;
    }

    public function getDangerData()
    {
        if (Auth::user()->role == 'superadmin') {
            $result = $this->produit->getDangerData($this->conn);
        } else {
            $result = $this->produit->getDangerDatas($this->conn, Auth::user()->idusine);
        }
        echo $result;
    }

    public function getAllDangerData()
    {
        $result = $this->produit->getDangerData($this->conn);
        echo $result;
    }

    public function tous()
    {
        require_once __DIR__ . '/../views/product/tous.php';
    }

    public function add()
    {
        $idatelier = $_POST['idatelier'];
        $idprod = $_POST['produit'];
        $cryptedId = IdEncryptor::encode($idatelier);
        foreach ($idprod as $id) {
            $this->contenir->Insert($this->conn, $id, $idatelier);
        }
        $_SESSION['add-success'] = [];
        $_SESSION['add-success']['type'] = true;
        $_SESSION['add-success']['info'] = $_POST;

        Route::redirect("/all-products/$cryptedId");
    }

    public function oneprod($params)
    {
        $id = $params['idprod'];
        require_once __DIR__ . '/../views/product/one.php';
    }

    public function all()
    {
        require_once __DIR__ . '/../views/product/all-product.php';
    }

    public function addFDS()
    {
        if (!empty($_FILES['pdfUpload']['name'])) {
            $idprod = $_POST['idprod'];
            $idatelier = $_SESSION['idatelier'];
            $fileFds = $this->package->filtrer($_FILES['pdfUpload']['name']);
            $fdsUpload = $this->package->fds($fileFds);

            if ($fdsUpload !== 1) {
                if ($fdsUpload == -5) {
                    $_SESSION['insert'] = [];
                    $_SESSION['insert']['type'] = "erreur upload fds";
                    $_SESSION['insert']['openModal'] = $_POST['idprod'];
                    Route::redirect('/product/new-product');
                } elseif ($fdsUpload == -1) {
                    $_SESSION['insert'] = [];
                    echo $_SESSION['insert']['type'] = "extensionFDS";
                    $_SESSION['insert']['openModal'] = $_POST['idprod'];
                    // echo "extension";
                    Route::redirect('/product/new-product');
                } elseif ($fdsUpload == -2) {
                    $_SESSION['insert'] = [];
                    echo $_SESSION['insert']['erreur'] = "doublonsFDS";
                    $_SESSION['insert']['insert'] = $fileFds;
                    $_SESSION['insert']['openModal'] = $_POST['idprod'];
                    // echo "déjà en bd";
                    Route::redirect('/product/new-product');
                }
            } else {
                //  echo 'ok';
                $fds = $fileFds;

                if ($this->produit->AddFds($this->conn, $fds, $idprod)) {
                    move_uploaded_file($_FILES["pdfUpload"]["tmp_name"], __DIR__ . '/../uploads/pdf/' . basename($fds));
                    $_SESSION['chemin'] = $_POST['chemin'];
                    $_SESSION['insert'] = [];
                    $_SESSION['insert']['type'] = true;
                    $_SESSION['insert']['nom'] = $this->produit->getNameById($this->conn, $idprod);
                    Route::redirect("/info-fds/new-info-fds/" . IdEncryptor::encode($idprod));
                } else {
                    $_SESSION['insert'] = false;
                }

                Route::redirect("/all-products/$idatelier");
            }
        }

    }
}