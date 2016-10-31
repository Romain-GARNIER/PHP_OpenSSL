<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>EDS - TP PHP OpenSSL</title>
  </head>

	<link rel="stylesheet" href="/style/paper.css" media="screen" title="no title">

  <body>
    <h1>Echanges sécurisés de données sur réseaux</h1>
    <h2>Utilisation d'OpenSSL pour PHP</h2>

    <ul class="list-group">
      <?php
      $current=getcwd();
      $dossier=opendir($current);
      while(false !== ($fichier = readdir($dossier))){
        if($fichier != '.' && $fichier != '..' && is_dir($fichier) && $fichier != 'style') {
          echo '<li class="list-group-item">
                  <a class="btn btn-default btn-lg btn-block" href="./'.$fichier.'">'.$fichier.'</a>
                </li>';
        }
      }
      ?>
    </ul>

  </body>
</html>
