<?php
function displayHeader(){ 
		?>
<!DOCTYPE html>

<html lang="fr-FR">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/general.css">
	<title> Points assos IIE </title>
</head>
<body>
<nav>
	<ul>
		<li><a href="/"> Accueil </a></li>
		
<?php if (empty($_SESSION['login'])) {
		echo "<li><a href='http://localhost:8080/authentification.php'> Connexion </a></li>";
} else {?>

<!--tout ce qui est affiché dans le menu si l'utilisateur est identifié-->
	<li><a href="deauth.php"> Déconnexion du compte de <? echo $_SESSION["login"] ?></a></li>
	<li><a href="profile.php"> Mon Profile </a></li>
<!--fin de ce qui est affiché dans le menu si l'utilisateur est identifié-->
<?php }
echo "</ul></nav>";
}


function displayAll($users){?>
	 <div class="container">

    <table class="table table-bordered table-hover table-striped">
        <thead style="font-weight: bold">
            <td>#</td>
            <td>Firstname</td>
			<td>Lastname</td>
			<td>Pseudo</td>
            <td>Promo</td>
        </thead>
        <?php /** @var \User\User $user */
        foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user->getId() ?></td>
                <td><?php echo $user->getFirstname() ?></td>
                <td><?php echo $user->getLastname() ?></td>
				<td><?php echo $user->getPseudo() ?></td>
                <td><?php echo $user->getAnnee() ?>A</td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php 
}



?>
