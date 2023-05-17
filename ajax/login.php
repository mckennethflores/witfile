<?php
session_start();
require "../config/Conexion.php";
require_once "../modelos/Login.php";

$opselected = $_GET["opselected"];
$value = "SELECCIONE";
$login = new Login();

switch ($_GET["op"]){

            case "selectRol":
            
            $rspta = $login->listarRol();
            optionselected($opselected,$value);

            while ($reg = $rspta->fetch_object()){
                echo '<option value=' . $reg->id_rol . '>' . ucfirst($reg->nom_rol) . '</option>';
            }
        break;

    }