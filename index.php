<?php

    require_once __DIR__. '/core/Route.php';
    // require_once __DIR__. '/models/package.php';
    require_once __DIR__. '/controllers/UserControllers.php';
    require_once __DIR__. '/controllers/ProductControllers.php';
    require_once __DIR__. '/controllers/AtelierController.php';
    require_once __DIR__. '/controllers/FdsController.php';
	require_once __DIR__. '/utilities/session.php';
    require_once __DIR__. '/models/idcrypt.php';
    require_once __DIR__.'/models/danger.php';
    require_once __DIR__ . '/middlewares/AuthMiddleware.php';
    require_once __DIR__. '/models/tokens.php';

    $conn = Database::getInstance()->getConnection();

    // Contrôleur
    $UserController = new UserControllers($conn);
    $ProductController = new ProductController($conn);
    $AtelierController = new AtelierController($conn);
    $FdsController = new FdsController($conn);

    // Route::add('GET', '/login', [$UserController, 'Login']);
    // Route::add('POST', '/', [$UserController, 'Login']);



    Route::add('GET', '/', [$UserController, 'Logs']);
    Route::add('POST', '/', [$UserController, 'Logs']);

    Route::add('GET', '/update-password', [$UserController, 'updatePassword']);
    Route::add('POST', '/update-password', [$UserController, 'updatePassword']);


    Route::add('GET', '/change-password/{token}', [$UserController, 'changePassword']);
    Route::add('POST', '/change-password/{token}', [$UserController, 'changePassword']);

    Route::add('GET', '/admin/new-user', [$UserController, 'CreateUser'], [AuthMiddleware::class]);
    Route::add('POST', '/user/new-user', [$UserController, 'CreateUser']);
    Route::add('GET', '/dashboard', [$UserController, 'dashboard'], [AuthMiddleware::class]);
    Route::add('POST', '/logout', [UserControllers::class , 'logout']);


    Route::add('GET', '/product/new-product', [$ProductController, 'Insert']);
    Route::add('POST', '/product/new-product', [$ProductController, 'Insert']);
    Route::add('POST', '/product/delete', [$ProductController, 'deleteFromWorkshop'] );
    Route::add('POST', '/product/add', [$ProductController, 'add'] );
    Route::add('GET','/product/more-detail/{idprod}', [$ProductController, 'oneprod']);


    Route::add('GET', '/product/all-product', [$ProductController, 'all']);

    
    // Route::add('GET', '/product/all-product/{idatelier}', [$ProductController, 'alls']);
    Route::add('GET', '/product/all-product/{idatelier}', [$ProductController, 'allss']);
    Route::add('GET', '/api/product/dangers/{idatelier}', [$ProductController, 'getProductDangersByAtelier']);


    Route::add('GET', '/product/edit-product/{idprod}', [$ProductController, 'update']);
    Route::add('POST', '/product/edit-product', [$ProductController, 'update']);
    
    Route::add('GET', '/all-products/{idatelier}', [$ProductController, 'showWorkshopDangerChart']);
    

    Route::add('POST', '/workshop/edit', [$AtelierController, 'edit']);
    Route::add('GET', '/workshop/all-workshop', [$AtelierController, 'all']);
    Route::add('POST', '/workshop/add', [$AtelierController, 'add']);
    Route::add('POST', '/workshop/delete', [$AtelierController, 'delete']);
    Route::add('GET', '/workshop/new-workshop', [$AtelierController, 'Insert']);


    

    Route::add('GET', '/info-fds/new-info-fds', [$FdsController, 'Insert']);






    
    // Dispatcher
    Route::dispatch();