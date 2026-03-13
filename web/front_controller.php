<?php

session_start();
require_once '../dispatcher.php';
require_once '../routing.php';
require_once '../controllers.php';


$actionUrl = $_GET['action'] ?? '/';
dispatch($routing, $actionUrl);