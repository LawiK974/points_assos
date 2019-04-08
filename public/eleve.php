<?php
include('./admin/functions.php');
// On prolonge la session
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: http://localhost:8080/authentification.php');
  exit();
}
displayHeader();
?>
</body>
</html>

