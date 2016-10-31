<?php
$File=$_GET['path'];
  header('Content-Transfer-Encoding: binary'); //Transfert en binaire (fichier)
  header('Content-Disposition: attachment; filename="'.basename($File).'"'); //Nom du fichier
  header('Content-Length:'. filesize($File)); //Taille du fichier
//Envoi du fichier dont le chemin est passé en paramètre
  readfile($File);

 ?>
