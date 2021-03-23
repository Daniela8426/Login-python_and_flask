<?php
require_once("conexion.php");

//Datos users
$cedula = $_POST['id_user'];
$tip_docu = $_POST['tipo_docu'];
$nom = $_POST['nombre'];
$ape = $_POST['apellidos'];
$edad = $_POST['edad'];
$cel = $_POST['cel'];
$correo = $_POST['correo'];

//Datos de pago
$num_card = $_POST['num_card'];
$date_vto = $_POST['date_vto'];
$cod_card = $_POST['cod_card'];

$consul = "INSERT INTO usuarios (cedula, tipo_docu, tipo_user, nombre,apellido, celular, correo, edad) VALUES ";

for ($i=0; $i < count($cedula); $i++) { 
    $consul.="('".$cedula[$i]."', '".$tip_docu[$i]."',1, '".$nom[$i]."', '".$ape[$i]."', '".$cel[$i]."', '".$correo[$i]."', '".$edad[$i]."'),";
}
$cadena_final = substr($consul, 0, -1);
$cadena_final.=";";

if($conexion->query($cadena_final)):
    
    //fecha de vencimiento
    $fechaHoy = date("Y-m-d");
    $holaaa= date_create($fechaHoy);
    $fecha = date_add ($holaaa, date_interval_create_from_date_string("10 days"));
    $lol = date_format($fecha, "y,m,d");
    
    //Datos tarjeta seleccionada
    $person= count($cedula);
    $caon = "SELECT * FROM card WHERE N_person = $person";
    $in=$conexion->query($caon);
    $info = mysqli_fetch_assoc($in);
    $id_card = $info['id_card'];
    $tickest = $info['tickets'];
    $valor = $info['precio'];


    $factura = "INSERT INTO compra (id_compra, id_card, cedula, date, id_estados,tickest,date_vcto, number_of_card,date_vcto_card, cod_card,valor ) VALUES ('','$id_card','".$cedula[0]."','$fechaHoy',1,'$tickest','$lol','$num_card','$date_vto','$cod_card','$valor')";
    $insertarCard=$conexion->query($factura); 

    $docu = $cedula[0];

    $compracodigo = "SELECT * FROM compra WHERE cedula = '$docu' ";
    $query2 = mysqli_query($conexion, $compracodigo);
    $fila = mysqli_fetch_assoc($query2);

    $qr = "INSERT INTO codigo (id_qr, id_compra, cedula) VALUES";
    for ($ar=0; $ar < count($cedula); $ar++) { 
        $qr.="('', '".$fila['id_compra']."','".$cedula[$ar]."'),";
    }
    $cade = substr($qr, 0, -1);
    $cade.=";";
    $conexion->query($cade);

    echo json_encode(array('ERROR' => false));

else:
    echo json_encode(array('ERROR' => true));

endif;



?>