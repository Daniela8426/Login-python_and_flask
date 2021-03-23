<?php
    $conexion= new mysqli("localhost","root","","comprautopia");
    if($conexion->connect_error)
    {
        die("fallo la conexion" . mysqli_connect_errno());
    }
?>