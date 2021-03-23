<?php
require_once("php/conexion.php");

$sql = "SELECT * FROM tip_docu";
$query = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_assoc($query);

$sql2 = "SELECT * FROM tip_card";
$query2 = mysqli_query($conexion, $sql2);
$fila2 = mysqli_fetch_assoc($query2);

?>

<html lang="es">

	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>

		<script>

            $(function(){
				// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
				$("#adicional").on('click', function(){
					$("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla");
				});
			 
				// Evento que selecciona la fila y la elimina 
				$(document).on("click",".eliminar",function(){
					var parent = $(this).parents().get(0);
					$(parent).remove();
				});
			});
			
    	/* 	let numero = 1;
            let nuevo = function() {
            numero++;
            jQuery('.inputs').append(`<section id="${numero}"><button type="button" onclick="nuevo();">Agregar</button><button class="btn-danger" onclick="eliminar(${numero})">Eliminar</button></section>`);
            console.log(numero)
            if (numero ==5){
                alert("Para ya")
            }}

            let eliminar = function(n) {
            jQuery("section").remove(`#${n}`); 
}*/
		</script>
	</head>

	<body>
		<header>
			<div class="">
			    <h1>COMPRA DE TARJETA</h1>
			</div>
		</header>
        <!-- <div class="inputs"> -->
        <form method="post">
            <div class="card">
                <h2>DATOS TARJETA</h2>
                <label for="">Seleccione el tipo de tarjeta que desea comprar: </label>
                <select name="tipo_card" id="">
                    <option value="0" placeholder=""></option>
                    <?php foreach ($query2 as $tip_card) : ?>
                    <option value="<?php echo $tip_card['id_tip_card'] ?> ">
                    <?php echo $tip_card['nom_tip_card'] ?></option>
                    <?php endforeach;?>
                </select>

            </div>
            <div class="usuarios">
                <h2>REGISTRO DE USUARIOS</h2>
                <table class="table"  id="tabla">
                        <tr class="fila-fija">
                        <td>
                            <label for="">Tipo de Documento: </label>
                            <select required name="tipo_docu[]" id="">
                                <option value="0" placeholder=""></option>
                                <?php foreach ($query as $tip_docu) : ?>
                                    <option value="<?php echo $tip_docu['id_tip_docu'] ?> ">
                                    <?php echo $tip_docu['nom_tip_doci'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td><label for="">Numero de Documento</label><input type= "number" required name="id_user[]"/></td>
                        <td><label for="">Nombre</label><input type= "text" required name="nombre[]"/></td>
                        <td><label for="">Apellidos</label><input type= "text" required name="apellidos[]"/></td>
                        <td><label for="">Edad</label><input type= "number" required name="edad[]"/></td>
                        <td><label for="">Telefono</label><input type= "number" required name="cel[]"/></td>
                        <td><label for="">Correo</label><input type= "email" required name="correo[]"/></td>
                        <td class="eliminar"><input type="button"   value="Menos -"/></td>
                    </tr>
                </table>
            </div>
            
            <!-- <button type="button" onclick="nuevo();">Agregar</button>
            <input type="submit" name="insertar"> -->
            <div class="btn-der">
				<input type="submit" name="insertar" value="Insertar Alumno" class="btn btn-info"/>
				<button id="adicional" name="adicional" type="button" class="btn btn-warning"> Más + </button>

			</div>

        </form>
        <!-- </div> -->
			<?php

				if(isset($_POST['insertar']))

				{
                    $items0 = ($_POST['tipo_card']);
                    $items1 = ($_POST['id_user']);
                    $items2 = ($_POST['tipo_docu']);
                    $items3 = ($_POST['nombre']);
                    $items4 = ($_POST['apellidos']);
                    $items5 = ($_POST['edad']);
                    $items6 = ($_POST['cel']);
                    $items7 = ($_POST['correo']);
				 
				
				while(true) {

				    $item1 = current($items1);
				    $item2 = current($items2);
				    $item3 = current($items3);
				    $item4 = current($items4);
                    $item5 = current($items5);
                    $item6 = current($items6);
                    $item7 = current($items7);
				    
				    ////// ASIGNARLOS A VARIABLES ///////////////////
                    
				    $id_user=(( $item1 !== false) ? $item1 : ", &nbsp;");
				    $tip_docu=(( $item2 !== false) ? $item2 : ", &nbsp;");
				    $nom=(( $item3 !== false) ? $item3 : ", &nbsp;");
				    $ape=(( $item4 !== false) ? $item4 : ", &nbsp;");
                    $edad=(( $item5 !== false) ? $item5 : ", &nbsp;");
                    $cel=(( $item6 !== false) ? $item6 : ", &nbsp;");
                    $correo=(( $item7 !== false) ? $item7 : ", &nbsp;");

				    //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
				    $valores='('.$id_user.',"'.$tip_docu.'","'.$nom.'","'.$ape.'","'.$edad.'","'.$cel.'","'.$correo.'",1),';

				    //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
				    $valoresQ= substr($valores, 0, -1);
				    
				    ///////// QUERY DE INSERCIÓN ////////////////////////////
				    $sql = "INSERT INTO users (id_user, id_tip_docu, nombres,apellidos, edad, cel, correo, id_tip_user) 
					VALUES $valoresQ";

					
					$sqlRes=$conexion->query($sql) or mysql_error();

				    
				    // Up! Next Value
				    $item1 = next( $items1 );
				    $item2 = next( $items2 );
				    $item3 = next( $items3 );
				    $item4 = next( $items4 );
                    $item5 = next( $items5 );
                    $item6 = next( $items6 );
                    $item7 = next( $items7 );
				    
				    // Check terminator
				    if($item1 === false && $item2 === false && $item3 === false && $item4 === false && $item5 === false && $item6 === false && $item7 === false) break;
    
				}
		
				}

			?>



		</section> 

		<footer>
		</footer>
	</body>

</html>


