<?php
set_error_handler(function() { /* ignore errors */ });

if(!empty($_POST)){
    if(!empty($_POST['text'])){
        //Récuperation des clés
        $publicKey = openssl_pkey_get_public("file://" . dirname(__FILE__) . "/../Exercice_B/files/certificat.crt");
        $privateKey = openssl_pkey_get_private("file://" . dirname(__FILE__) . "/../Exercice_B/files/privateKey.key");
        //Encodage/décodage du message
        $encrypt_text_succeed = openssl_public_encrypt($_POST['text'],$encrypt_text,$publicKey);
        $decrypt_text_succeed = openssl_private_decrypt($encrypt_text,$decrypt_text,$privateKey);

        //Affiche un message si les clés n'ont pas pu être récuperées
        if($publicKey==false||$privateKey==false){
            echo '<script>alert("Erreur de récuperation du certificat de l\'exercice B, les avez-vous générés ? ")</script>';
        }
    }
}
 ?>
 <!DOCTYPE html>
 <html>
 	<head>
 		<meta charset="utf-8">
 		<title>EDS - Exercice C</title>
 	</head>
 	<link rel="stylesheet" href="../style/paper.css" media="screen" title="no title">
 	<!-- Font Awesome-->
 	<link rel="stylesheet" href="../style/font-awesome-4.7.0/css/font-awesome.min.css">

 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Un peu de style...-->
    <style>
    textarea{
         border-style: solid;
         border-width: 2px;
        border-color: #778899;
    width : 40em;}
    </style>
 	<body>

        <h1>Echanges sécurisés de données sur réseaux</h1>
    <h2>Utilisation d'OpenSSL pour PHP</h2>
		<h3>Chiffrement/déchiffrement pour assurer la confidentialité</h3>
        <hr>

		<div class="col-lg-8">

<!-- Champ de saisie du texte-->
        <fieldset>
        <legend>Votre text</legend>
<form class="form-horizontal" action="index.php" method="post">
    <textarea name="text" >Entrez votre texte...</textarea>
    <button class="btn btn-primary" type="submit">Envoyer</button>
</form>
</fieldset>

<!-- Champ d'affichage du texte encodé-->
<fieldset>
<legend>Votre texte encrypté</legend>
<textarea style="height:10em" readonly>
    <?php
    //Si on a envoyé un texte
    if(!empty($_POST['text']))
    //Si l'encodage a reussi
    if($encrypt_text_succeed)
    //On affiche le texte encodé dans le textarea
        echo $encrypt_text;
    ?>
</textarea>
</fieldset>

<!-- Champ affichage du texte décodé-->
<fieldset>
<legend>Votre text decrypté</legend>
<textarea readonly>
    <?php
    //Si on a envoyé un texte
    if(!empty($_POST['text']))
    //Si l'encodage a reussi
    if($decrypt_text_succeed)
    //On affiche le texte encodé dans le textarea
        echo $decrypt_text;
    ?></textarea>
</fieldset>
<?php //Bouton retour
echo '<a href=".\..\"> <input type="button" value="Retour" /> </a>'
?>
</div>


    </body>
    </html>
