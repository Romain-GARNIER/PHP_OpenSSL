<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>EDS - Exercice D</title>
  </head>

  <?php

  if(!empty($_FILES)) {

    //variables necessaire pour 'upload.php'
    $chemin="files";

    $nom="signature";
    $inputName='signature';
    include("../upload.php");

    $nom="publicKey";
    $inputName='pubKey';
    include("../upload.php");

    $nom="docSignee";
    $inputName='file';
    include("../upload.php");

    $pubkeyid = file_get_contents("./files/publicKey.key");
    $pubkeyid = openssl_pkey_get_public($pubkeyid);
    //var_dump($pubkeyid);

    $signature = file_get_contents($chemin."/signature.dat");

    $file = file_get_contents($chemin."/docSignee.".$extension);

    // indique si la signature est correcte
    $ok = openssl_verify($file, $signature, $pubkeyid);
    openssl_free_key($pubkeyid);

  }

  ?>

  <link rel="stylesheet" href="../style/paper.css" media="screen" title="no title">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <body>

    <h1>Echanges sécurisés de données sur réseaux</h1>

    <h2>Utilisation d'OpenSSL pour PHP</h2>

    <h3>Vérification de la signature d'un document</h3>
    <hr>

    <div class="col-lg-9">
      <form class="form-horizontal" action="index.php#" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Téléchargement</legend>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="">Document</label>
            <div class="col-lg-10">
              <input class="form-control" type="file" name="file" style="cursor: pointer;">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="">Signature du document</label>
            <div class="col-lg-10">
              <input class="form-control" type="file" name="signature" style="cursor: pointer;">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="">Votre clé publique</label>
            <div class="col-lg-10">
              <input class="form-control" type="file" name="pubKey" style="cursor: pointer;">
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              <button id=btn_valid class="btn btn-primary" type="submit">Envoyer</button>
            </div>
        </div>
        </fieldset>
      </form>
      <?php

      if(!empty($_FILES)){
        if($ok==1){
          echo '<div class="alert alert-dismissible alert-success">
                  <button class="close" type="button" data-dismiss="alert">&times;</button>
                  Signature valide !
                </div>';
              }
        elseif($ok==0){
          echo '<div class="alert alert-dismissible alert-warning">
                  <button class="close" type="button" data-dismiss="alert">&times;</button>
                  Signature erronée !
                </div>';
              }
        else{
          echo '<div class="alert alert-dismissible  alert-danger">
                  <button class="close" type="button" data-dismiss="alert">&times;</button>
                  Signature erronée !
                </div>';
              }
      }

      ?>

      <?php //Bouton retour
      echo '<a href=".\..\"> <input type="button" value="Retour" /> </a>'
      ?>
    </div>

  </body>

</html>
