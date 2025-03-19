<?php
session_start();
require_once '../controllers/AuthController.php';
$auth = new AuthController(null);
$auth->logout();
?>