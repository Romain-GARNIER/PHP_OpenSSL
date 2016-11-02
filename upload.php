<?php

if(!empty($_FILES)) {

  if(isset($chemin) || isset($nom) || isset($inputName)){

    if( !empty($_FILES[$inputName]['name']) ){

      //$tabExt = array(); // tabeau des extensions accepté

      if(!file_exists($chemin))
        mkdir($chemin, 0777); // création du fichier s'il n'existe pas


        if ($_FILES[$inputName]['error'] > 0)
          echo "Erreur lors du transfert";

        $extension  = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);

        //if(in_array(strtolower($extension),$tabExt))
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $chemin.'/'.$nom.'.'.$extension);

      }

    }

}

?>
