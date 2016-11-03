<?php

if(!empty($_POST)){
	$dn = array(
		"commonName" => $_POST["commonName"],
		"emailAddress" => $_POST["emailAddress"],
		"localityName" => $_POST["localityName"],
		"stateOrProvinceName" => $_POST["stateOrProvinceName"],
		"countryName" => $_POST["countryName"],
		"organizationName" => $_POST["organizationName"],
		"organizationalUnitName" => $_POST["organizationalUnitName"]
	);

	include '../config.php';

	/* Création de la clé privé */
	$privateKey = openssl_pkey_new($configargs);
	/* Création de la requète */
	$requete = openssl_csr_new($dn, $privateKey, $configargs);
	/* Création du cértificat signé avec le certificat de l'exercice A*/
	$certificat = openssl_csr_sign($requete,
	"file://" . dirname(__FILE__) . "/../Exercice_A/files/certificat.crt",
	"file://" . dirname(__FILE__) . "/../Exercice_A/files/privateKey.key",
	365,$configargs);

	/*Exportation de la clé, requete et certificat sous forme de fichiers */

	openssl_pkey_export_to_file($privateKey , "" . dirname(__FILE__) . "/files/privateKey.key",NULL,$configargs);
	openssl_csr_export_to_file($requete , "" . dirname(__FILE__) . "/files/requete.txt");
	openssl_x509_export_to_file($certificat , "" . dirname(__FILE__) . "/files/certificat.crt");

}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>EDS - Exercice B</title>
	</head>
	<link rel="stylesheet" href="../style/paper.css" media="screen" title="no title">
	<!-- Font Awesome-->
	<link rel="stylesheet" href="../style/font-awesome-4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<body>

		<h1>Echanges sécurisés de données sur réseaux</h1>
    <h2>Utilisation d'OpenSSL pour PHP</h2>
		<h3>Générer un certificat personnel à partir d'un certificat racine</h3>

		<div class="col-lg-8">

			<form class="form-horizontal" action="index.php" method="post">
				<fieldset>
	    		<legend>Formulaire</legend>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Prénom Nom</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="commonName" value="Jean-François Pastel">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">E-mail</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="emailAddress" value="jfpastel@skyblog.fr">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Ville</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="localityName" value="Sophia Antipolis">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Département</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="stateOrProvinceName" value="Alpes-Maritimes">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Pays</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="countryName" value="FR">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Organisation</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="organizationName" value="UNSA">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Nom de l'unité</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="organizationalUnitName" value="LPSIL">
							</div>
						</div>




						<div class="form-group">
				      <div class="col-lg-10 col-lg-offset-2">
				        <button class="btn btn-default" type="reset">Cancel</button>
				        <button class="btn btn-primary" type="submit">Submit</button>
				      </div>
		    	</div>
				</fieldset>
			</form>
		</div>

		<?php
			/* A afficher après envoi du formulaire */
			if(!empty($_POST)){
				/* Vérification de la création de la clé, requete et certificat */
				echo '<div class="col-lg-3">
						<ul class="list-group" style="list-style-type: none;">
						    <li>Génération d\'une clé privée   ';
				if (!empty($privateKey) && $privateKey!=null)
		    		echo "<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>";
				else
					echo "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";

				echo '
					</li>
				    <li>Génération d\'une requète   ';
				if (!empty($requete) && $requete!=null)
					echo "<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>";
				else
					echo "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";
					echo '</li>
						<li>Génération du certificat   ';
					if (!empty($certificat) && $certificat!=null)
						echo "<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>";
					else
						echo "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";

						echo '</li>
					</ul>';

				/* Bouton pour les téléchargements */
				echo '
					<ul class="list-group">
						<li class="list-group-item">
							<a class="btn btn-primary btn-lg" href="../download.php?path='.getcwd().'/files/privateKey.pem">Clé privée</a>
						</li>
						<li class="list-group-item">
							<a class="btn btn-primary btn-lg" href="../download.php?path='.getcwd().'/files/requete.txt">Requete</a>
						</li>
						<li class="list-group-item">
							<a class="btn btn-primary btn-lg" href="../download.php?path='.getcwd().'/files/certificat.crt">Certificat</a>
						</li></
					ul>
				</div>';
			}
		?>

	</body>
</html>
