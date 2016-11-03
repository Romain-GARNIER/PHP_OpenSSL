<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>EDS - TP PHP OpenSSL</title>
  </head>

	<link rel="stylesheet" href="./style/paper.css" media="screen" title="no title">

  <body>
    <h1>Echanges sécurisés de données sur réseaux</h1>
    <h2>Utilisation d'OpenSSL pour PHP</h2>
    <h3 style="margin-left:2em">Par Romain Garnier et Damien Rogé</h3>
    <hr>


<p style="margin :2em"> Si vous avez installé ce site web sur votre propre serveur merci de spécifier votre chemin vers openssl.cnf dans config.php </p>
    <!-- Liste des exercies (sous-dossiers du repertoire courant)-->
    <ul style="margin:2em" class="list-group">
      <?php
      $current=getcwd();
      $dossier=opendir($current);
      while(false !== ($fichier = readdir($dossier))){
        if($fichier != '.' && $fichier != '..' && is_dir($fichier) && $fichier != 'style'&& $fichier != '.git') {
          echo '<li style="width:50%" class="list-group-item">
                  <a class="btn btn-default btn-lg btn-block" href="./'.$fichier.'">'.$fichier.'</a>
                </li>';
        }
      }
      ?>
    </ul>

  </body>
</html>
