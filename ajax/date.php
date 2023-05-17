<?php
date_default_timezone_set('America/Lima');
/* function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
   
    $interval = date_diff($datetime1, $datetime2);
   
    return $interval->format($differenceFormat);
   
} 
    echo dateDifference("2021-09-06" ,"2021-09-12" , $differenceFormat = '%a' );
*/

    function restarFecha($fechaFinal, $formatoDiferencia = '%a' )
    {
        $hoy = date("Y-m-d");

        $fechaFinal = date_create($fechaFinal);
        $hoy = date_create($hoy);

        $resultado = date_diff($hoy, $fechaFinal);

        return $resultado->format($formatoDiferencia);
    }
    $resultado =  restarFecha("2021-09-09", $formatoDiferencia = '%a' );

    if($resultado == '2'){
        echo var_dump(true);
    }else{
        echo var_dump(false);
    }
?>
