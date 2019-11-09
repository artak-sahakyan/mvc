<?php
use controllers\AdminController;
use controllers\TaskController;

spl_autoload_register(function ($class) {
    require_once '../'.$class . '.php';
});


$action = $_GET['action'] ?? '';
if(!$action && $_SERVER['REQUEST_URI'] == '/') {
    $action = 'index';
}

if($action == 'index') {
    $controller = new TaskController();
    die($controller->index());
}


if($action == 'login') {
    $controller = new AdminController();
    die($controller->login());
}

if($action == 'logout') {
    $controller = new AdminController();
    die($controller->logout());
}

if($action == 'edit' && !empty($_GET['id'])) {
    $controller = new AdminController();
    die($controller->edit($_GET['id']));
}

if($action == 'approve' && !empty($_GET['id'])) {
    $controller = new AdminController();
    die($controller->approve($_GET['id']));
}

header("HTTP/1.0 404 Not Found");
exit;