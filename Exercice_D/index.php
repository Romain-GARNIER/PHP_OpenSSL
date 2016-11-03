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

	include '../config.php';

  	$privateKey = openssl_pkey_new($configargs);
    $priv_key_id=openssl_pkey_get_private($privateKey);
    openssl_pkey_export($privateKey,$privateKeyOut, "",$configargs);

    $details = openssl_pkey_get_details($privateKey);
    $public_key_pem = $details['key'];
    //var_dump($public_key_pem);

    if(openssl_sign($file,$signature,$priv_key_id)){
      file_put_contents($chemin.'/'.$filename, $signature);
      //var_dump($signature);
      file_put_contents("$chemin/privateKey.pem",$privateKeyOut);
      file_put_contents("$chemin/publicKey.pem",$public_key_pem);
    }
    else {
      echo "ERREUR";
    }

  }

  ?>

  <link rel="stylesheet" href="../style/paper.css" media="screen" title="no title">

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
              <button class="btn btn-default" type="reset">Annulé</button>
              <button id=btn_valid class="btn btn-primary" type="submit">Validé</button>
            </div>
        </div>
        </fieldset>
      </form>
    </div>

    <?php
    if(!empty($_FILES['file']['name'])){
      $path=getcwd().'/'.$chemin.'/'.$filename;
      echo '<div class=col-lg-3>
              <ul class="list-group">
                <li class="list-group-item">
                  <a class="btn btn-primary btn-lg" href="../download.php?path='.getcwd().'/'.$chemin.'/privateKey.pem">Clé privée</a>
                </li>
                <li class="list-group-item">
                  <a class="btn btn-primary btn-lg" href="../download.php?path='.getcwd().'/'.$chemin.'/publicKey.pem">Clé publique</a>
                </li>
                <li class="list-group-item">
                  <a class="btn btn-primary btn-lg" href="../download.php?path='.$path.'">Signature</a>
                </li></
              </ul>

            </div>';
    }
    ?>
    <?php //Bouton retour
    echo '<a href=".\..\"> <input type="button" value="Retour" /> </a>'
    ?>
  </body>
</html>
