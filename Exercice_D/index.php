<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>EDS - Exercice D</title>
  </head>

  <?php

  if(!empty($_FILES)) {


    $filename='signature.dat';

    //variables necessaire pour 'upload.php'
    $inputName='file';
    $chemin="files";
    $nom="docSign";

    include("../upload.php");

    $file=file_get_contents($chemin.'/'.$nom.'.'.$extension);

    //Définition de la variable $configargs
	include '../config.php';

    //Création de la clé privée
  	$privateKey = openssl_pkey_new($configargs);
    $priv_key_id=openssl_pkey_get_private($privateKey);

    //Récuperation de la clé public
    $details = openssl_pkey_get_details($privateKey);
    $public_key_pem = $details['key'];

    //Création de la signature
    if(openssl_sign($file,$signature,$priv_key_id)){
      file_put_contents($chemin.'/'.$filename, $signature);
      file_put_contents("$chemin/publicKey.key",$public_key_pem);
      openssl_pkey_export_to_file($privateKey , "" . dirname(__FILE__) . "/files/privateKey.key",NULL,$configargs);

    }
    else {
        echo '<script>alert("Erreur lors de la génération de la signature")</script>';
    }

  }

  ?>

  <link rel="stylesheet" href="../style/paper.css" media="screen" title="no title">
  <!-- Font Awesome-->
  <link rel="stylesheet" href="../style/font-awesome-4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <body>
    <h1>Echanges sécurisés de données sur réseaux</h1>

    <h2>Utilisation d'OpenSSL pour PHP</h2>

    <h3>Signature d'un document</h3>

    <div class="col-lg-9">
      <form class="form-horizontal" action="index.php#" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Téléchargement</legend>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="">Document à signer</label>
            <div class="col-lg-10">
              <input class="form-control" type="file" name="file" style="cursor: pointer;">
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              <button id=btn_valid class="btn btn-primary" type="submit">Envoyer</button>
            </div>
        </div>
        </fieldset>
      </form>
      <?php //Bouton retour
      echo '<a href=".\..\"> <input type="button" value="Retour" /> </a>'
      ?>
    </div>

    <?php
    if(!empty($_FILES['file']['name'])){
      $path=getcwd().'/'.$chemin.'/'.$filename;
      /* Vérification de la création de la clé, requete et certificat */
      echo '<div class="col-lg-3">
              <ul class="list-group" style="list-style-type: none;">
                  <li>Génération d\'une clé privée   ';
      if (!empty($privateKey) && $privateKey!=null) //Affiche l'icon correspondant à la reussite ou echec de la création de la clé
          echo "<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>";
      else
          echo "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";

      echo '
          </li>
          <li>Récuperation de la clé publique   ';
      if (!empty($public_key_pem) && $public_key_pem!=null)
          echo "<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>";
      else
          echo "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";
          echo '</li>
              <li>Génération de la signature   ';
          if (!empty($signature) && $signature!=null)
              echo "<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>";
          else
              echo "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";

              echo '</li>
          </ul>';
          echo '
              <ul class="list-group">
                <li class="list-group-item">
                  <a class="btn btn-primary btn-lg" href="../download.php?path='.getcwd().'/'.$chemin.'/privateKey.key">Clé privée</a>
                </li>
                <li class="list-group-item">
                  <a class="btn btn-primary btn-lg" href="../download.php?path='.getcwd().'/'.$chemin.'/publicKey.key">Clé publique</a>
                </li>
                <li class="list-group-item">
                  <a class="btn btn-primary btn-lg" href="../download.php?path='.$path.'">Signature</a>
                </li></
              </ul>

            </div>';
    }
    ?>

  </body>
</html>
