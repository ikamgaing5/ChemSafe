<?php

require_once __DIR__ . '/core/Route.php';
require_once __DIR__ . '/models/connexion.php';
require_once __DIR__ . '/models/auth.php';
require_once __DIR__ . '/models/historique_acces.php';
require_once __DIR__ . '/models/Historique.php';
require_once __DIR__ . '/utilities/session.php';
require_once __DIR__ . '/models/idcrypt.php';
require_once __DIR__ . '/models/atelier.php';
require_once __DIR__ . '/models/produit.php';
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/fds.php';
require_once __DIR__ . '/models/contenir.php';
require_once __DIR__ . '/models/package.php';
require_once __DIR__ . '/models/possede.php';
require_once __DIR__ . '/models/usine.php';
require_once __DIR__ . '/models/danger.php';
require_once __DIR__ . '/middlewares/AuthMiddleware.php';
require_once __DIR__ . '/models/tokens.php';
require_once __DIR__ . '/controllers/UserControllers.php';
require_once __DIR__ . '/controllers/FactoryController.php';
require_once __DIR__ . '/controllers/ProductControllers.php';
require_once __DIR__ . '/controllers/AtelierController.php';
require_once __DIR__ . '/controllers/FdsController.php';
require_once __DIR__ . '/controllers/HistoriqueController.php';


$conn = Database::getInstance()->getConnection();
$atelier = new Atelier();
$produit = new Produit();
$user = new User();
$contenir = new Contenir();
$package = new Package();

// Contrôleur
$UserController = new UserControllers($conn);
$ProductController = new ProductController($conn);
$AtelierController = new AtelierController($conn);
$FdsController = new FdsController($conn);
$FactoryController = new FactoryController($conn);
$HistoriqueController = new HistoriqueController($conn);

// Route::add('GET', '/login', [$UserController, 'Login']);
// Route::add('POST', '/', [$UserController, 'Login']);



Route::add('GET', '/', [$UserController, 'Logs']);
Route::add('POST', '/', [$UserController, 'Logs']);

// Route::add('GET', '/update-password', [$UserController, 'updatePassword']);
// Route::add('POST', '/update-password', [$UserController, 'updatePassword']);


// Route::add('GET', '/change-password/{token}', [$UserController, 'changePassword']);
// Route::add('POST', '/change-password/{token}', [$UserController, 'changePassword']);

Route::add('GET', '/admin/new-user', [$UserController, 'CreateUser'], [AuthMiddleware::class]);
Route::add('POST', '/user/new-user', [$UserController, 'CreateUser']);
Route::add('GET', '/dashboard', [$UserController, 'dashboard'], [AuthMiddleware::class]);
Route::add('GET', '/showgraphs', [$AtelierController, 'showGraphs']);
Route::add('GET', '/showgraph', [$AtelierController, 'dashboard']);
Route::add('GET', '/getDangerProducts', [$ProductController, 'getDangerByProducts']);
Route::add('GET', '/getDangerData', [$ProductController, 'getDangerData']);
Route::add('POST', '/logout', [UserControllers::class, 'logout']);




######################################## ROUTES POUR LES PRODUITS ######################################## 
Route::add('GET', '/product/new-product', [$ProductController, 'Insert'], [AuthMiddleware::class]);
Route::add('POST', '/product/new-product', [$ProductController, 'Insert']);
Route::add('POST', '/product/delete', [$ProductController, 'deleteFromWorkshop']);
Route::add('POST', '/product/add', [$ProductController, 'add']);
Route::add('GET', '/product/more-detail/{idprod}', [$ProductController, 'oneprod'], [AuthMiddleware::class]);
Route::add('POST', '/product/updateFDS', [$ProductController, 'addFDS']);
Route::add('POST', '/product/updatePhoto', [ProductController::class, 'addPhoto']);
Route::add('GET', '/product/all-product', [$ProductController, 'all'], [AuthMiddleware::class]);
// Route::add('GET', '/product/all-product/{idatelier}', [$ProductController, 'alls']);
Route::add('GET', '/product/all-product/{idatelier}', [$ProductController, 'allss'], [AuthMiddleware::class]);
// Route::add('GET', '/api/product/dangers/{idatelier}', [$ProductController, 'getProductDangersByAtelier']);
Route::add('GET', '/api/product/dangers/{idatelier}', [$ProductController, 'getDangerProducts'], [AuthMiddleware::class]);
Route::add('GET', '/product/edit-product/{idprod}', [$ProductController, 'update'], [AuthMiddleware::class]);
Route::add('POST', '/product/edit-product', [$ProductController, 'update']);
Route::add('GET', '/all-products/{idatelier}', [$ProductController, 'showWorkshopDangerChart'], [AuthMiddleware::class]);
Route::add('POST', '/product/delete-everywhere', [$ProductController, 'delete']);
Route::add('GET', '/all-products', [$ProductController, 'tous']);
Route::add('GET', '/getAllDanderData', [$ProductController, 'getAllDangerData']);

###########################################################################################################





######################################## ROUTES POUR LES ATELIERS ######################################## 
Route::add('POST', '/workshop/edit', [$AtelierController, 'edit']);
Route::add('GET', '/workshop/all-workshop/{idusine}', [$AtelierController, 'all'], [AuthMiddleware::class]);
Route::add('POST', '/workshop/add', [$AtelierController, 'add']);
Route::add('POST', '/workshop/delete', [$AtelierController, 'delete']);
Route::add('GET', '/workshop/new-workshop', [$AtelierController, 'Insert'], [AuthMiddleware::class]);
Route::add('GET', '/workshop/all-workshop/', [$AtelierController, 'alls'], [AuthMiddleware::class]);



############################################################################################################


######################################## ROUTES POUR LES USINES ######################################## 
Route::add('GET', '/factory/all-factory', [$FactoryController, 'all'], [AuthMiddleware::class]);
Route::add('POST', '/factory/add', [$FactoryController, 'create']);

##############################################################################################################

######################################## ROUTES POUR LES FDS ######################################## 
Route::add('GET', '/info-fds/new-info-fds/{idprod}', [$FdsController, 'Insert'], [AuthMiddleware::class]);
Route::add('POST', '/fds/add-info', [$FdsController, 'Insert']);

###########################################################################################################


######################################## ROUTES POUR LES HISTORIQUES ######################################## 
Route::add('GET', '/history/user', [$HistoriqueController, 'user'], [AuthMiddleware::class]);
// Route::add('POST', '/fds/add-info', [$FdsController, 'Insert']);

Route::add('GET', '/history/workshop', [$HistoriqueController, 'workshop'], [AuthMiddleware::class]);
###########################################################################################################


// Dispatcher
Route::dispatch();

?>