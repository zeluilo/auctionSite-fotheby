<?php

require '../functions/loadTemplate.php';
require '../database.php';
require '../classes/DatabaseTable.php';
require '../Controllers/AdminController.php';
require '../Controllers/UserController.php';

// Check if the user is logged in or registered
$isLoggedInOrRegistered = isset($_SESSION['userDetails']);

// Check if the logged-in user's checkAdmin is "USER"
$isUser = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'USER';
$isSeller = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'SELLER';

$categoryTable = new DatabaseTable($pdo, 'category', 'catId');
$auctionTable = new DatabaseTable($pdo, 'auction', 'aucId');
$userTable = new DatabaseTable($pdo, 'users', 'userId');
$biddingTable = new DatabaseTable($pdo, 'bidding', 'bidId');
$userAuctionTable = new DatabaseTable($pdo, 'UserAuction', 'aucID');

// View Table
$auction_catTable = new DatabaseTable($pdo, 'auction_cat', 'aucId');
$auction_userTable = new DatabaseTable($pdo, 'user_auction', 'userId');
$user_bid_categoryTable = new DatabaseTable($pdo, 'user_bid_category', 'bidId');
$reviewAuctionTable = new DatabaseTable($pdo, 'review_auction', 'userId');

$controllers = [];
$controllers['admin'] = new \Controllers\AdminController($categoryTable, $auctionTable, $auction_catTable, $userTable, $biddingTable, $auction_userTable, $user_bid_categoryTable, $reviewAuctionTable);
$controllers['user'] = new \Controllers\UserController($categoryTable, $auctionTable, $auction_catTable, $userTable, $auction_userTable, $user_bid_categoryTable, $biddingTable, $userAuctionTable);

$route = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');

if ($route == '') {
    // Redirect unregistered users, sellers, and users to the home page of the user
    if (!$isLoggedInOrRegistered) {
        $page = $controllers['user']->home();
    } elseif ($isUser || $isSeller) {
        $page = $controllers['user']->home();
    } else {
        $page = $controllers['admin']->home();
    }
} else {
    list($controllerName, $functionName) = explode('/', $route);
    $controller = $controllers[$controllerName];
    $page = $controller->$functionName();
}


$output = loadTemplate('../template/' . $page['template'], $page['variables']);
$title = $page['title'];

if (!$isLoggedInOrRegistered || ($isUser || $isSeller)) {
    require '../template/userlayout.html.php';
} else {
    require '../template/layout.html.php';
}


?>
