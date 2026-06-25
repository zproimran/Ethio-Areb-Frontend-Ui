<?php
// ethioareb/logout.php - Logout
session_start();
session_destroy();
header('Location: ../');
exit();
?>