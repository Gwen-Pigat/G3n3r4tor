<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("librairie/Database.class.php");
require("librairie/RessourcesBAKE.class.php");
require("php/datas.php");

define("URL",$_SERVER["REQUEST_URI"]);
define("URL_CREA","../../Projets/");