<?php
include('./admin/functions.php');
// On prolonge la session
session_start();
// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login']) || empty($_SESSION['president']) ) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: authentification.php');
  exit();
}
if(empty($_SESSION['event']) || empty($_SESSION['association'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: president.php');
  exit();
}

  //Gros machin copié depuis authentification.php
require '../vendor/autoload.php';
//postgres
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");

$userRepository = new \User\UserRepository($connection);
$users = $userRepository->fetchAll();
$user = $users[$_SESSION['login']];
$asso=$connection->query('select * from associations where id_asso='.$_SESSION["association"])->fetch(\PDO::FETCH_OBJ);
$events=$connection->query('select * from events where id_event='.$_SESSION['event'])->fetch(\PDO::FETCH_OBJ);
$eleves = $connection->query('select * from score left join users using (id_user) where id_event='.$_SESSION['event'])->fetchAll(\PDO::FETCH_OBJ);

displayHeader();
if (!empty($_POST['points'])) {
	$connection->query("update score set notation=".$_POST["points"].' where id_user='.$_POST['usertomodif']);
	echo "Note modifiée";
}
if (!empty($_POST['usertoadd'])){
	$connection->query("insert into score(id_user,id_event,notation) values (".$_POST['usertoadd'].",".$_SESSION['event'].",10)");
	echo "Elève rajouté !";
}
?>
<div class="gestion" id="gestion_evenements">

	<table class="table table-bordered table-hover table-striped">
	<caption>Classement des participations pour l'évènement <?php echo $events->name." du ".$events->date_ev." pour l'association ".$asso->name ?></caption>
		<tr>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Pseudo</th>
			<th>Promo</th>
			<th>Participation</th>
		</tr>
		<?php foreach ($eleves as $eleve) : ?>
		<tr>
			<form method="post">
			<td> <?php echo $eleve->firstname ?> </td>
			<td> <?php echo $eleve->lastname ?> </td>
			<td> <?php echo $eleve->pseudo ?> </td>
			<td> <?php echo $eleve->year+3 ?> </td>

			<td><input type="number" min="1" max="10" name="points" class="tableinput" value="<?php echo $eleve->notation ?>"></td>
			<td class="actions">
				<input type="number" value="<?php echo $eleve->id_user ?>" name="usertomodif" class="idevent" readonly/>
				<input type="submit" name="submit" value="Modifier" />
			</td>
			</form>

		</tr>
		<?php endforeach; ?>
	</table>

<!--TODO rajouter un élève dans l'evenement-->
</body>
</html>
