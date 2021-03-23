<?php
require_once("php/conexion.php");

$sql = "SELECT * FROM tipo_docu";
$query = mysqli_query($conexion, $sql);

$sql2 = "SELECT * FROM card";
$query2 = mysqli_query($conexion, $sql2);
$info = mysqli_fetch_assoc($query2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <title>Document</title>
</head>
<body>
    <header>
			<div class="">
			    <h1>COMPRA DE TARJETA</h1>
			</div>
		</header>
    <div class="card">
      <form method="post">
          <h2>DATOS TARJETA</h2>
          <label for="">Seleccione el tipo de tarjeta que desea comprar: </label>
          <select name="tipo_card" id="">
            <option value="0" placeholder=""></option>
            <?php foreach ($query2 as $card) : ?>
            <option value="<?php echo $card['id_card'] ?> ">
            <?php echo $card['name_card'] ?></option>
            <?php endforeach;?>
          </select>
          <input type="submit" name="insertar" value="Seleccionar"/>
      </form>
    </div>

    <div class="users">
      <form id="form_insert">
        <?php 
          if(isset($_POST['insertar'])){
            $card = $_POST['tipo_card'];
            $sql2 = "SELECT * FROM card WHERE id_card = $card";
            $query2 = mysqli_query($conexion, $sql2);
            $info = mysqli_fetch_assoc($query2);


            echo('
                <div class="infoMostrar">
                  <h3>DATOS PAQUETE</h3>
                  <table>
                    <td>TIPO DE TARJETA: </td>
                    <td><label>'.$info["name_card"].'</label></td>
                    </tr>
                    <td>NUMERO DE PERSONAS: </td>
                    <td>'.$info["N_person"].'</td>
                    </tr>
                    <td>NUMERO DE TICKETS: </td>
                    <td><label>'.$info["tickets"].'</label></td>
                    </tr>
                    <td>PRECIO: </td>
                    <td><label >'.$info["precio"].'</label></td>
                  </table>
                  <input type="hidden" name="Eliminar" value=""/>
                  <h2>REGISTRO DE USUARIOS</h2>
              ');
            
            for ($i = 1; $i <= $info["N_person"]; $i++){
                
        ?>
        <table class="table">
          <tr class="fila">
            <td>
              <label for="">Tipo Documento</label>
              <select required name="tipo_docu[]" id="">
                <option value="0" placeholder=""></option>
                <?php foreach ($query as $tip_docu) : ?>
                <option value="<?php echo $tip_docu['id_tipo_docu'] ?> ">
                <?php echo $tip_docu['nom_docu'] ?></option>
                <?php endforeach;?>
              </select>
            </td>
            <td><label for="">Número de Documento</label><input type= "number" required name="id_user[]"/></td>
            <td><label for="">Nombre</label><input type= "text" required name="nombre[]"/></td>
            <td><label for="">Apellidos</label><input type= "text" required name="apellidos[]"/></td>
            <td><label for="">Edad</label><input type= "number" required name="edad[]"/></td>
            <td><label for="">Telefono</label><input type= "number" required name="cel[]"/></td>
            <td><label for="">Correo</label><input type= "email" required name="correo[]"/></td>
          </tr>
        </table>
        
        <?php }
        echo('
          <div class="datosPago">
            <h2>DATOS DE PAGO</h2>
            <table class="table" >
              <tr class="fila">
                <td><label for="">Número de Tarjeta: </label><input type= "number" required name="num_card"/></td>
                <td><label for="">Fecha de Vencimiento:</label><input type= "date" required name="date_vto"/></td>
                <td><label for="">Código de seguridad (CVV):</label><input type= "text" required name="cod_card"/></td>
              </tr>
            </table>
          </div>
          <div class="acciones">
              <input type="submit" value="Comprar" />
          </div>'
        );
        } 
        ?>
       
      </form>
    </div>

    <script src="js/compraCard.js" ></script>
</body>
</html>