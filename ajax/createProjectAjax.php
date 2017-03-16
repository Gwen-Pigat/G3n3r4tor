<?php

require("../parametres.php");

$post= $_POST;

if($post["project_name"] != ""){
	$name = $post["project_name"];
} else{
	$name = "Project_".rand(0,154612).str_shuffle("AZERTY");
}
$bake = new RessourcesBAKE($name);

if(!isset($post["head_top"]) && !isset($post["head_center"]) && !isset($post["head_left"]) && !isset($post["head_right"]) && !isset($post["head_bottom"]) && !isset($post["content_top"]) && !isset($post["content_center"]) && !isset($post["content_left"]) && !isset($post["content_right"]) && !isset($post["content_bottom"]) && !isset($post["foot_top"]) && !isset($post["foot_center"]) && !isset($post["foot_left"]) && !isset($post["foot_right"]) && !isset($post["foot_bottom"])){

	$projet=Database::selectOne("SELECT pro_titre FROM cfg_projects WHERE pro_titre='".$name."'");
	if($projet){
		$result = array(
			"error"=>true,
			"text"=>"Le projet existe déjà"
		);
	} else{
		Database::update("INSERT INTO cfg_projects(pro_titre,pro_location,pro_date) VALUES('".$name."','".URL_CREA.$name."',NOW())");

		$projet=Database::selectOne("SELECT * FROM cfg_projects WHERE pro_titre='".$name."' AND pro_location='".URL_CREA.$name."' AND pro_date=NOW()");
		$result = array(
		"alert"=>true,
		"title"=>"Yesssssssssss !!",
		"text"=>"Le petit projet vient d'être crée !! ^__^",
		"pro_id"=>$projet->pro_id,
		"pro_titre"=>$projet->pro_titre
		);
	}

} else{

	mkdir($name."/vues");
	mkdir($name."/vues/pages");
	touch($name."/vues/pages/erreur.php");

	mkdir($name."/vues/includes", 0777);

	touch($name."/vues/includes/header.php",0777);
	$head_file = fopen($name."/vues/includes/header.php", 'w');
	$header_content = RessourcesBAKE::getHeader();
	fwrite($head_file, $header_content);

	touch($name."/vues/includes/footer.php",0777);
	$foot_file = fopen($name."/vues/includes/footer.php", 'w');
	$foot_content = RessourcesBAKE::getFooter();
	fwrite($foot_file, $foot_content);

	mkdir($name."/vues/includes/template", 0777);
	touch($name."/vues/includes/template/layout.php", 0777);
	$layout_file = fopen($name."/vues/includes/template/layout.php", 'w');
	$layout_content = RessourcesBAKE::getLayout();
	fwrite($layout_file, $layout_content);

	mkdir($name."/vues/pages", 0777);

	if(isset($post["head_top"]) || isset($post["head_center"]) || isset($post["head_left"]) || isset($post["head_right"]) || isset($post["head_bottom"])){
		mkdir($name."/vues/includes/head", 0777);

		if(isset($post["head_top"])){
			touch($name."/vues/includes/head/head_top.php");

		}
		if(isset($post["head_center"])){touch($name."/vues/includes/head/head_center.php");}
		if(isset($post["head_left"])){touch($name."/vues/includes/head/head_left.php");}
		if(isset($post["head_right"])){touch($name."/vues/includes/head/head_right.php");}
		if(isset($post["head_bottom"])){touch($name."/vues/includes/head/head_bottom.php");}

	} 

	if(isset($post["content_top"]) || isset($post["content_center"]) || isset($post["content_left"]) || isset($post["content_right"]) || isset($post["content_bottom"])){
		mkdir($name."/vues/includes/content", 0777);

		if(isset($post["content_top"])){touch($name."/vues/includes/content/content_top.php");}
		if(isset($post["content_center"])){touch($name."/vues/includes/content/content_center.php");}
		if(isset($post["content_left"])){touch($name."/vues/includes/content/content_left.php");}
		if(isset($post["content_right"])){touch($name."/vues/includes/content/content_right.php");}
		if(isset($post["content_bottom"])){touch($name."/vues/includes/content/content_bottom.php");}

	}

	if(isset($post["foot_top"]) || isset($post["foot_center"]) || isset($post["foot_left"]) || isset($post["foot_right"]) || isset($post["foot_bottom"])){
		mkdir($name."/vues/includes/foot", 0777);

		if(isset($post["foot_top"])){touch($name."/vues/includes/foot/foot_top.php");}
		if(isset($post["foot_center"])){touch($name."/vues/includes/foot/foot_center.php");}
		if(isset($post["foot_left"])){touch($name."/vues/includes/foot/foot_left.php");}
		if(isset($post["foot_right"])){touch($name."/vues/includes/foot/foot_right.php");}
		if(isset($post["foot_bottom"])){touch($name."/vues/includes/foot/foot_bottom.php");}

	}


	$result = array(
		"alert"=>true,
		"title"=>"Projet crée avec succès !!",
		"text"=>"Le projet \"".$name."\" vient d'être crée"
	);

}


echo json_encode($result);

 ?>