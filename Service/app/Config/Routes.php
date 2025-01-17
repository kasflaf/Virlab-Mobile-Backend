<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// In app/Config/Routes.php

// Group routes for authentication
$routes->group("auth", function ($routes) {
    $routes->post("register", "AuthController::register");
    $routes->post("login", "AuthController::login");

    // Apply 'auth' filter for logout and delete account routes
    $routes->delete("delete", "AuthController::deleteAccount", [
        "filter" => "auth",
    ]);
});

$routes->group("user", function ($routes) {
    $routes->get("score", "UserScoreController::getScore", [
        "filter" => "auth",
    ]);
    $routes->post("score/update", "UserScoreController::updateScore", [
        "filter" => "auth",
    ]);
});
