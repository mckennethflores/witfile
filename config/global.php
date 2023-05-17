<?php
/* error_reporting(0); */
define("DB_HOST","localhost");
define("DB_NAME","uploadfilesdb");
define("DB_USERNAME","root");
define("DB_PASSWORD","");
define("DB_ENCODE","utf8");
define("PRO_NOMBRE","CRMG");

define("ROL_ADMINISTRADOR",1);
define("ROL_VENDEDOR",2);

const NOMBRE_EMPRESA = "Witbun";
const BASE_URL = "http://localhost/uploadFiles";

$subCarpeta = "acmp/bce-v1.2/";
$host = "http://".$_SERVER["HTTP_HOST"]."/".$subCarpeta;
$documentPathProject = $_SERVER["DOCUMENT_ROOT"]."/".$subCarpeta;

define("URL_PAGE",$host);
define("DOCUMENT_PATH_PROJECT",$documentPathProject);


?>
