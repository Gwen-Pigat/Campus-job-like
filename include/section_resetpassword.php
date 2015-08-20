<div>

<form class="col-md-8 col-md-offset-2" method="POST" action="">
	<h1>Nouveau mot de passe</h1>
	<input name="password" type="password" placeholder="Ecrivez ici" required>
	<input name="password_confirm" type="password" placeholder="Confirmez" required>
<br>
<button type="submit" class="btn btn-danger"><i class=" fa fa-envelope"></i> Envoyer</button>
</form>
</div>

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


 ?>