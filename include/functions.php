<?php 

class sessionHandle{
	
	function sessionDestroy(){
		session_start();
		session_destroy();	
	}

	function profilWait(){
		$link = new mysqli("localhost","root","motdepasselocalhostgwen","JobFinder")or die("Erreur Connexion BDD");
		$link->query("DELETE FROM EntrepriseProfil WHERE Statut_profil='En attente'");
		$link->query("DELETE FROM Etudiant WHERE Statut_profil='En attente'");
		$link->query("DELETE FROM Offre WHERE Statut='En attente'");
	}
}

$session = new sessionHandle();

 ?>