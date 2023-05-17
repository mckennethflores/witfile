<?php
session_start();
require_once "../modelos/Auxiliar.php";

$auxiliar=new Auxiliar();


    switch($_GET["op"]){

        case 'selectAuxiliar':
            require_once "../modelos/Auxiliar.php";
            $auxiliar = new Auxiliar();
            $rspta = $auxiliar->listar();
            echo '<option value="0" selected disabled>Seleccione porfavor</option>';    
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id . '>' . $reg->valor . '</option>';
            }
        break;
        case 'listarFrecuenciaPago':
            require_once "../modelos/Auxiliar.php";
            $auxiliar = new Auxiliar();
            $rspta = $auxiliar->listarFrecuenciaPago();
            echo '<option value="0" selected disabled>Seleccione porfavor</option>';    
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id . '>' . $reg->valor . '</option>';
            }
        break;
}