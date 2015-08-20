<?php if (isset($_GET['Etudiant'])){ ?>

<form class="col-md-8 col-md-offset-2" method="POST" action="">
	<h1><?php echo $row->Prenom; ?></h1>
	<h2>Votre nouveau mot de passe :</h2>
	<input name="password" type="password" placeholder="Ecrivez ici" required>
	<input name="password_confirm" type="password" placeholder="Confirmez" required>
<br>
<button type="submit" class="btn btn-danger"><i class=" fa fa-envelope"></i> Envoyer</button>
</form>

<?php

	// Verification du formulaire

	if (isset($_POST) && isset($_POST['password']) && isset($_POST['password_confirm']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
		
		// On vérifie que les mots de passe matchent

		if ($_POST['password'] != $_POST['password_confirm']) {
		echo "<script>alert(\"Les mots de passe doivent être identique\")</script>";
		header("Refresh: 0; url=index.php?Etudiant&password_reset=$_GET[password_reset]");
		}
		elseif ($_POST['password'] == $_POST['password_confirm']) {

		$link->query("UPDATE Etudiant SET Password='$_POST[password]'");
		$link->query("UPDATE Etudiant SET token_password='' WHERE token_password='$_GET[password_reset]'");

		echo "<script>alert(\"Votre mot de passe à bien été ré_initialisé, vous pouvez à présent vous connecter avec celui-ci\")</script>";
		header("Refresh: 0; url=index.php?Etudiant");
		}
	}
}


if (isset($_GET['Employeur'])){ ?>

<form class="col-md-8 col-md-offset-2" method="POST" action="">
	<h1><?php echo $row->Entreprise; ?></h1>
	<h2>Votre nouveau mot de passe :</h2>
	<input name="password" type="password" placeholder="Ecrivez ici" required>
	<input name="password_confirm" type="password" placeholder="Confirmez" required>
<br>
<button type="submit" class="btn btn-danger"><i class=" fa fa-envelope"></i> Envoyer</button>
</form>

<?php

	// Verification du formulaire

	if (isset($_POST) && isset($_POST['password']) && isset($_POST['password_confirm']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
		
		// On vérifie que les mots de passe matchent

		if ($_POST['password'] != $_POST['password_confirm']) {
		echo "<script>alert(\"Les mots de passe doivent être identique\")</script>";
		header("Refresh: 0; url=index.php?Employeur&password_reset=$_GET[password_reset]");
		}
		elseif ($_POST['password'] == $_POST['password_confirm']) {

		$link->query("UPDATE EntrepriseProfil SET Password='$_POST[password]'");
		$link->query("UPDATE EntrepriseProfil SET token_password='' WHERE token_password='$_GET[password_reset]'");

		echo "<script>alert(\"Votre mot de passe à bien été ré_initialisé, vous pouvez à présent vous connecter avec celui-ci\")</script>";
		header("Refresh: 0; url=index.php?Employeur");
		}
	}
}

 ?>