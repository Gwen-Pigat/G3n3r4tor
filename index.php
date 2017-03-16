<?php require("parametres.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/animate.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/buttons.css">
 	<link href="https://fonts.googleapis.com/css?family=Ravi+Prakash" rel="stylesheet"> 
	<title>Mini Project GENERATOR</title>
</head>
<body>
<div class="container">
	<h1 class="text-center animated title title_fade white">Pix's Generator</h1>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">	
			<form class="animated" method="POST" id="post_datas">
				<div class="input-group">
					<div class="input-group-addon addon-black">Nom du projet</div>
					<input class="form-control" type="text" name="project_name" />
				</div>
				<?php include("php/head_blocs.php"); include("php/content_blocs.php"); include("php/foot_blocs.php"); ?>
				<button class="btn btn-grad-red btn-block"><i class="fa fa-check"></i> Valider</button>
			</form>
			<div id="results"></div>
		</div>
	</div>
	<div id="projets_box">
		<h2 class="text-center white title_fade animated">Liste des projets</h2>
		<div class="row">
			<!-- Chargement des projets en AJAX -->
		</div>
	</div>
</div>
</body>
<script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/fonctions.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
</html>