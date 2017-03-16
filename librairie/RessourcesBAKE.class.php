<?php 


class RessourcesBAKE{

    private $name;
    private $title;

	public function __construct($name){

        //Gestion de droit
        $oldmask = umask(0);

        $name=explode("/",$name);
        $name=implode("",$name);
        $this->name = "../../Projets/".$name;
        $this->title=substr($this->name,14,50);

        mkdir($this->name, 0777,true);
        mkdir($this->name."/public",0777);
        mkdir($this->name."/librairie");
        mkdir($this->name."/php");
        mkdir($this->name."/public/ajax",0777);
        mkdir($this->name."/public/js",0777);
        mkdir($this->name."/public/css",0777);

        //Création de la HOME
        RessourcesBAKE::setGlobalFile("Home");
        //Création du parametres.php
        RessourcesBAKE::setGlobalFile("PARAM");
        //Création DATAS PHP
        RessourcesBAKE::setGlobalFile("PHP|DATAS");
        //Création de la class DATABASE
        RessourcesBAKE::setGlobalFile("DATA|CLASSE");
        //Création AJAX
        RessourcesBAKE::setGlobalFile("AJAX");
        //Création du JS
        RessourcesBAKE::setGlobalFile("JS");
        //Création du SweetAlert depuis le min
        RessourcesBAKE::setGlobalFile("SWAL|CSS");
        //Création CSS sweetAlert
        RessourcesBAKE::setGlobalFile("SWAL|JS");

        //Création fichier CSS de base
        touch($this->name."/public/css/style.css",0777);

        //Gestion de droit
        umask($oldmask);

        return $this->title;
        
	}


	private function getHeader(){
		$str = '<?php require("parametres.php"); ?>
        <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<title>'.$this->title.' | Accueil</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">'.$this->title.'</h1>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <form role="form" method="post" id="form_datas">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input id="nom" type="text" class="form-control" name="nom" />
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>   
                        <input id="prenom" type="text" class="form-control" name="prenom" />
                    </div>
                    <button class="btn btn-success btn-block"><i class="fa fa-check"></i> Valider</button>
                </form>
                <div id="results"></div>
            </div>
        </div>
    </div>
';

		return $str;
	}


	private function getFooter(){
		$str='<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="public/js/fonctions.js"></script>
<script type="text/javascript" src="public/js/sweetalert.min.js"></script>
</body>
</html>';
	   return $str;
	}
    

    private function setGlobalFile($type){

        switch($type){
            case "Home":
                touch($this->name."/index.php",0777);
                $data = fopen($this->name."/index.php", 'w');
                $data_content = $this->getHeader().$this->getFooter();
                fwrite($data, $data_content);
            break;
            case "JS":
                touch($this->name."/public/js/fonctions.js",0777);
                $data = fopen($this->name."/public/js/fonctions.js", 'w');
                $data_content = RessourcesBAKE::getFonctionsJS();
                fwrite($data, $data_content);
            break;
            case "SWAL|JS":
                touch($this->name."/public/js/sweetalert.min.js",0777);
                $data = fopen($this->name."/public/js/sweetalert.min.js", 'w');
                $data_content = file_get_contents("../ressources/sweetalert.min.js");
                fwrite($data, $data_content);
            break;
            case "SWAL|CSS":
                touch($this->name."/public/css/sweetalert.css",0777);
                $data = fopen($this->name."/public/css/sweetalert.css", 'w');
                $data_content = file_get_contents("../ressources/sweetalert.css");
                fwrite($data, $data_content);
            break;
            case "PARAM":
                touch($this->name."/parametres.php",0777);
                $data = fopen($this->name."/parametres.php", 'w');
                $data_content = RessourcesBAKE::getParametresFile();
                fwrite($data, $data_content);
            break;
            case "DATA|CLASSE":
                touch($this->name."/librairie/Database.class.php",0777);
                $data = fopen($this->name."/librairie/Database.class.php", 'w');
                $data_content = file_get_contents("../librairie/Database.class.php");
                fwrite($data, $data_content);
            break;
            case "PHP|DATAS":
                touch($this->name."/php/datas.php",0777);
                $data = fopen($this->name."/php/datas.php", 'w');
            break;
            case "AJAX":
                touch($this->name."/public/ajax/formAjax.php",0777);
                $data = fopen($this->name."/public/ajax/formAjax.php", 'w');
                $data_content = RessourcesBAKE::getAjaxDefault();
                fwrite($data, $data_content);
            break;
            default:
                touch($this->name."/error_log.txt",0777);
                $data = fopen($this->name."/error_log.txt", 'w');
                $data_content = $this->getErrorFile($type);
                fwrite($data, $data_content);
            break;
        }
    }

    private function getErrorFile($type){
        $str = "Le fichier ".$this->name." n'a pas pu être généré\n Type : ".$type;
        return $str;
    }

    private static function getParametresFile(){
        $content = '<?php
define("URL","http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
error_reporting(E_ALL);
ini_set("display_errors", 1);
require ("librairie/Database.class.php");
$pdo = new Database();';
        return $content;
    }

    private static function getAjaxDefault(){
        $content = '<?php
$post=$_POST;

foreach($post as $key=>$data){
    if($data != ""){
        $post[$key]=htmlspecialchars($data);
    } else{
        $error=true;
    }
}
if(!$error){
    $result = array(
        "alert"=>true,
        "title"=>"Yesssssssssss !!",
        "text"=>"Le process est bon !!"
    );
} else{
    $result = array(
        "alert"=>true,
        "errorcode"=>true,
        "errormsg"=>"Tous les champs sont obligatoires :(",
    );
}
echo json_encode($result);
    ';
        return $content;
    }

    public static function deleteProject($projet){
        unlink($projet."/index.php");
        unlink($projet."/php/datas.php");
        unlink($projet."/public/js/fonctions.js");
        unlink($projet."/public/js/sweetalert.min.js");
        unlink($projet."/public/css/style.css");
        unlink($projet."/public/css/sweetalert.css");
        unlink($projet."/public/ajax/formAjax.php");
        unlink($projet."/librairie/Database.class.php");
        unlink($projet."/parametres.php");

        rmdir($projet."/public/js");
        rmdir($projet."/public/css");
        rmdir($projet."/public/ajax");
        rmdir($projet."/public");
        rmdir($projet."/php");
        rmdir($projet."/librairie");
        rmdir($projet);
    }


	private static function getFonctionsJS(){
	$file = '/* BLOC MESSAGE DE RETOUR AJAX */
function msgbox(div,error,errormsg){$(div).hide();$(div).html(errormsg);if(error){$(div).addClass("alert alert-danger");}else{$(div).removeClass(\'alert alert-danger\').addClass(\'alert alert-success\');}$(div).fadeIn("fast");}
/* PERMET DE VIDER LE FORMULAIRE APRES RETOUR VALIDE */
function vider_formulaire(form) {$(\':input\',form).not(\':button, :submit, :reset, :hidden\').val(\'\').removeAttr(\'checked\').removeAttr(\'selected\');}

function ajax_form(id_form,id_result,url_ajax){
    $(id_form).submit(function(){
        $.ajax({
            type:\'post\',
            url:url_ajax,
            data:$(this).serialize(),
            dataType:\'json\',
            success:function(data){
                if(data.alert){
                    if(data.errorcode){
                        alert(data.errormsg,"error");
                    } else{
                        swal({
                            title: data.title,
                            text: data.text,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                } else{
                    msgbox(id_result,data.errorcode,data.errormsg);
                }
            },error:function(xhr, ajaxOptions, thrownError){
            	msgbox(id_result,true,\'Error : \' + xhr.responseText +\' \'+ajaxOptions+\' \'+xhr.status+\' \'+thrownError);
            }
        });
        return false;
    });
}
function alert(msg,type){
    sweetAlert(\'\', msg, type);
}

ajax_form("#form_datas","#results","public/ajax/formAjax.php");';
	
	return $file;

	}


    public function getLayout(){
        $file='<?php 

include("vues/includes/header.php");

echo "\r<div class=\"container\">\r".$content."\r</div>\r";

include("vues/includes/footer.php");

?>';
        return $file;
    }



}





 ?>