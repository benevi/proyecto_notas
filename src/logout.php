<?php
session_start();

// Destruye todo el contenido de la sesión
session_unset();
session_destroy();


header("Location: ../public/login.php");
exit();
?>