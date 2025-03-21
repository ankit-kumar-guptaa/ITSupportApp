<?php
// Redirect to AuthController for logout
header("Location: /controllers/AuthController.php?action=logout");
exit;