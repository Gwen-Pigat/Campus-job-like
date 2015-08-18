<section class="social-media">
<a href=""><i class="fa fa-facebook-square fa-3x"></i></a>
<a href=""><i class="fa fa-linkedin-square fa-3x"></i></a>
<a href=""><i class="fa fa-twitter-square fa-3x"></i></a>
<a href=""><i class="fa fa-youtube-square fa-3x"></i></a>
</section>

<section class="categorie">
<?php echo "<a href='index.php?Employeur'><button class='btn-employeur'>Employeur</button></a>
<button class='btn-login' data-toggle='modal' data-target='#Connexion'>Se connecter</button>"; ?>
</section>

<div class='container text-center'>
<div class="logo">
<img src="img/icon.png"><br>
<span class='title'>SpeedJob</span>
</div>
<h1 class="main">Etudiant :<br>  trouve un stage ou un job</h1>

<!-- Test de slider -->

	<br><br><br>

<button class='btn-custom' data-toggle="modal" data-target="#myModal"><strong>Trouve ton stage maintenant</strong></button>
</div>


<!-- Modal de l'inscription -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Formulaire d'inscription</h4>
        </div>
        <div class="modal-body">
          <p>Veuilez remplir tout les champs ci-dessous afin de valider votre inscription.</p>
          <center>
          <form method="POST" action="php/redirect_master.php?inscription">
            <input type="text" name="nom" placeholder="Votre nom" required>
            <input type="text" name="prenom" placeholder="Votre prénom" required><br>
            <input type="email" name="email_e" placeholder="E-mail" required>
            <input type="password" name="password_e" placeholder="Mot de passe"  required><br>
            <input class="btn btn-danger" type="submit" value="Valider">
          </form>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Retour</button>
        </div>
      </div>    
    </div>
  </div>

<!-- Modal pour connexion  -->
  <div class="modal fade" id="Connexion" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content col-md-12">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Connexion à votre compte</h4>
        </div>
        <div class="modal-body">
          <center>
          <form class="col-md-12" method="POST" action="php/redirect_master.php">
            <input class="col-md-12" type="email" name="email_e" placeholder="Votre adresse e-mail" required>
            <input class="col-md-12" type="password" name="password_e" placeholder="Votre mot de passe" required><br>
            <a href="" data-toggle="modal" data-target="#password">
              <p class="col-md-12 password_send">Mot de passe oublié ?</p>
            </a>
            <input class="btn btn-custom col-md-12" type="submit" value="Valider">
          </form>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Retour</button>
        </div>
      </div>    
    </div>
  </div>

  <!-- Modal pour mot de passe  -->
  <div class="modal fade" id="password" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content col-md-12">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mot de passe oublié ?</h4>
          <p class="text-center" style="margin-top: 4%">Pas d'inquiétude<br>
Donnez nous votre e-mail et nous vous enverrons un lien afin de ré-initialiser votre mot de passe.</p>
        </div>
        <div class="modal-body">
          <center>
            <?php $random = str_shuffle("1234567890azertyuiop");
          echo "<form class='col-md-12' action='' method='POST'>
            <input class='col-md-12' type='text' placeholder='Votre e-mail' name='email_send_etudiant'><br>
            <input class='btn btn-custom col-md-12' type='submit' value='Valider'>
          </form>"; ?>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Retour</button>
        </div>
      </div>    
    </div>
  </div>

<?php 

// Redirection si adresse e-mail déja utilisée lors d'inscritpion

  if (isset($_GET) && isset($_GET['email_already_used'])) {
      echo "<div class='box col-md-4 col-md-offset-4 text-center'>Adresse email déja utilisée !!<br /><i class='fa fa-spinner fa-refresh fa-3x'></i></div>";
  }


// Envoi du mail pour ré-initialiser le mot de passe étudiant

  if (isset($_POST) && isset($_POST['email_send_etudiant'])) {
    if (!empty($_POST['email_send_etudiant'])) {

      extract($_POST);

      $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM Etudiant WHERE Email='$_POST[email_send_etudiant]'"));

    require 'PHPMailer/class.phpmailer.php';

    // Instantiate it
    $mail = new phpmailer();

    // Define who the message is from
    $mail->FromName = 'JobFinder - Mot de passe';

    // Set the subject of the message
    $mail->Subject = "$row[Prenom]";

    // Add the body of the message
    $body = "Bonjour $row[Prenom].\n
    Suite à votre demande de ré-initilisaton du mot de passe, nous vous prions de bien vouloir cliquez sur le lien suivant :\n
    http://localhost/PHP/ProjetEtudiant/index.php?Etudiant$row[id_crypt]&$random&email=$row[Email]";
    // Add a recipient address
    $mail->AddAddress("$row[Email]");

    if(!$mail->Send())
        echo ('');
    else
        echo ('');

        echo "<div class='col-md-4 col-md-offset-4 box'>Un e-mail vous a été envoyé <br><i class='fa fa-spinner fa-pulse fa-3x'></i></div>";
    }
  }