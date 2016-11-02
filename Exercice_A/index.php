<?php

if(!empty($_POST)){
	$dn = array(
		"commonName" => $_POST["commonName"],
		"organizationName" => $_POST["organizationName"],
		"organizationalUnitName" => $_POST["organizationalUnitName"],
		"emailAddress" => $_POST["emailAddress"],
		"localityName" => $_POST["localityName"],
		"stateOrProvinceName" => $_POST["stateOrProvinceName"],
		"countryName" => $_POST["countryName"]
	);

	// $dn = array(
	// 	"commonName" => "Université de Nice Sophia Antipolis",
	// 	"organizationName" => 'UNSA',
	// 	"organizationalUnitName" => "LPSIL",
	// 	"emailAddress" => "contact@unsa.fr",
	// 	"localityName" => "Sophia Antipolis",
	// 	"stateOrProvinceName" => "Alpes-Maritimes",
	// 	"countryName" => "FR"
	// );

	$configargs = array(
		"config" =>
		"C:\\Program Files (x86)\\EasyPHP-Devserver-16.1\\eds-binaries\\php\\php704vc14x86x161003104536\\extras\\ssl\\openssl.cnf"
	);

	/* Creat the private and public key */
	$privateKey = openssl_pkey_new($configargs);

	$requete = openssl_csr_new($dn, $privateKey, $configargs);

	$certificat =openssl_csr_sign($requete,null,$privateKey,1095,$configargs);

	openssl_pkey_export($privateKey,$privateKeyOut, "",$configargs);
	openssl_csr_export($requete, $requeteOut);
	openssl_x509_export($certificat, $certificatOut);

	if(!file_exists("files"))
		mkdir("files", 0777);

	file_put_contents("./files/privateKey.pem",$privateKeyOut);
	file_put_contents("./files/requete.txt",$requeteOut);
	file_put_contents("./files/certificat.crt",$certificatOut);

}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>EDS - Exercice A</title>
	</head>
	<link rel="stylesheet" href="../style/paper.css" media="screen" title="no title">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<body>
		<h1>Echanges sécurisés de données sur réseaux</h1>
    <h2>Utilisation d'OpenSSL pour PHP</h2>
		<h3>Générer un certificat racine d'une autorité de certification</h3>

		<div class="col-lg-8">
			<form class="form-horizontal" action="index.php" method="post">
				<fieldset>
	    		<legend>Formulaire</legend>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Nom de l'organistion</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="commonName" value="Université de Nice Sophia Antipolis">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" for="">Acronyme</label>
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
							<label class="col-lg-2 control-label" for="">E-mail</label>
							<div class="col-lg-10">
								<input class="form-control" type="text" name="emailAddress" value="contact@unsa.fr">
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
				      <div class="col-lg-10 col-lg-offset-2">
				        <button class="btn btn-default" type="reset">Cancel</button>
				        <button class="btn btn-primary" type="submit">Submit</button>
				      </div>
		    	</div>
				</fieldset>
			</form>
		</div>

		<?php

			if(!empty($_POST)){
				echo '<div class="col-lg-3">
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
					</ul>
				</div>';
			}
		?>

	</body>
</html>
