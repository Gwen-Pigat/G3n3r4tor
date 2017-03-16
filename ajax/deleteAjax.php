<?php

require("../parametres.php");

if(isset($_GET["projet"]) && !empty($_GET["projet"]) && $_GET["projet"] != "flush"){
	$req="SELECT * FROM cfg_projects WHERE pro_id=".$_GET["projet"];
	$projet=Database::selectOne($req);
	if($projet){
		Database::update("DELETE FROM cfg_projects WHERE pro_id=".$_GET["projet"]);
		RessourcesBAKE::deleteProject($projet->pro_location);
		$result= array(
			"alert"=>true,
			"title"=>"OK !! ;)",
			"text"=>"Projet supprimé"
		);
	} else{
		$result= array(
			"alert"=>true,
			"errorcode"=>true,
			"title"=>"Erreur",
			"text"=>"Une erreur à eut lieu : erreur de sélection du projet"
		);
	}
} else{
	$projets=Database::selectAll("SELECT * FROM cfg_projects");
	if($projets){
		foreach($projets as $projet){
			Database::update("DELETE FROM cfg_projects WHERE pro_id=".$projet->pro_id);
			RessourcesBAKE::deleteProject($projet->pro_location);
		}
		$result= array(
			"alert"=>true,
			"errorcode"=>true,
			"title"=>"FLUSH DONE",
			"text"=>"le flush est terminé Gwen ;)"
		);
	} else{
		$result= array(
			"alert"=>true,
			"errorcode"=>true,
			"title"=>"Erreur",
			"text"=>"Erreur req des projets"
		);
	}
}

echo json_encode($result);