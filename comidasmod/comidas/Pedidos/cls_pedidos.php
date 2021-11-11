<?php
require_once '../conexioncomidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaPedido();
                break;
            case "eliminar":
                eliminaPedido();
                break;
            case "actualizar":
                actualizaPedido();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaPedido(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $fecha = $_GET["fecha"];
        $pedido = $_GET["pedido"];
        $clase = $_GET["clase"];
        $total = $_GET["total"];
        $cliente = $_GET["cliente"];
		$dni = $_GET["dni"];
		$valor = $_GET["valor"];
		$incremento = $_GET["incremento"];
        $consulta=$db->prepare("CALL sp_nuevo_pedido1(:fecha,:pedido,:clase,:total,:cliente,:dni,:valor,:incremento);");
        $consulta->bindParam(":fecha",$fecha, PDO::PARAM_STR, 20);
        $consulta->bindParam(":pedido", $pedido, PDO::PARAM_STR, 20);
        $consulta->bindParam(":clase", $clase, PDO::PARAM_STR, 4);
        $consulta->bindParam(":total", $total, PDO::PARAM_STR, 5);
        $consulta->bindParam(":cliente", $cliente, PDO::PARAM_STR, 9);
		$consulta->bindParam("dni", $dni, PDO::PARAM_STR, 9);
		$consulta->bindParam(":valor", $valor, PDO::PARAM_STR, 4);
		$consulta->bindParam(":incremento", $incremento, PDO::PARAM_STR, 3);
		$consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaPedido();//cambiar por consultaclientes OJO
    }
    
    function actualizaPedido(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["pedido"])){
            $fecha = $_GET["fecha"];
        $pedido = $_GET["pedido"];
        $clase = $_GET["clase"];
        $total = $_GET["total"];
        $cliente = $_GET["cliente"];
		$dni = $_GET["dni"];
		$valor = $_GET["valor"];
		$incremento = $_GET["incremento"];
        $consulta=$db->prepare("CALL sp_actualiza_pedido1(:fecha,:pedido,:clase,:total,:cliente,:dni,:valor,:incremento);");
        $consulta->bindParam(":fecha",$fecha, PDO::PARAM_STR, 20);
        $consulta->bindParam(":pedido", $pedido, PDO::PARAM_STR, 20);
        $consulta->bindParam(":clase", $clase, PDO::PARAM_STR, 4);
        $consulta->bindParam(":total", $total, PDO::PARAM_STR, 5);
        $consulta->bindParam(":cliente", $cliente, PDO::PARAM_STR, 9);
		$consulta->bindParam("dni", $dni, PDO::PARAM_STR, 9);
		$consulta->bindParam(":valor", $valor, PDO::PARAM_STR, 4);
		$consulta->bindParam(":incremento", $incremento, PDO::PARAM_STR, 3);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaPedido();   //cambiar por consulta cliente
            
        }else{
            consultaPedidoActualizar($_GET["fecha"]);
        }
    }
    
    function eliminaPedido(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $fecha = $_GET["fecha"];
        $consulta=$db->prepare("CALL sp_elimina_pedido1(:fecha);");
        $consulta->bindParam(":fecha",$fecha, PDO::PARAM_STR, 15);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaPedido();//cambiar por colsulta personas
    }
    
    function consultaPedidoActualizar(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_pedido1();");
        $consulta->execute();
        $filas=$consulta->fetchAll(PDO::FETCH_ASSOC);
        tablaActualizar($filas);
        $db = null;
    }
    
    function tablaActualizar($filas){
        ?><table border=2 width=100% id="datos1"><tr><?php
         
        foreach($filas[0] as $indice => $valor){
            echo "<td>". $indice ."</td>";
        }
        
        ?><td colspan="1">ADMINISTRACI&Oacute;N</td></tr><?php
                
        ?>
            <tr>
                <td><input type="text" name="fecha" id="fecha" class="textEntry" 
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["FECHA"];?>">  
					<input type="text" name="fecha1" id="fecha1" class="oculto" 		
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["FECHA"];?>"></td>						   
                <td><input type="text" name="pedido" id="pedido" class="textEntry" 
                           placeholder="Pedido" maxlength="25"
                           value="<?php echo $filas[0]["PEDIDO"];?>"></td>
                <td><input type="text" name="clase" id="clase" class="textEntry"
                           placeholder="Clase" maxlength="25"
                           value="<?php echo $filas[0]["CLASE"];?>"></td>
                <td><input type="text" name="total" id="total" class="textEntry"
                           placeholder="Total" maxlength="25"
                           value="<?php echo $filas[0]["TOTAL"];?>"></td>
                <td><input type="text" name="cliente" id="cliente" class="textEntry"
                           placeholder="Cliente" maxlength="25"
                           value="<?php echo $filas[0]["CLIENTE"];?>"></td>
				<td><input type="text" name="dni" id="dni" class="textEntry"
                           placeholder="Dni" maxlength="25"
                           value="<?php echo $filas[0]["DNI"];?>"></td>
				<td><input type="text" name="valor" id="valor" class="textEntry"
                           placeholder="Valor" maxlength="25"
                           value="<?php echo $filas[0]["VALOR"];?>"></td>
				<td><input type="text" name="incremento" id="incremento" class="textEntry"
                           placeholder="Incremento" maxlength="25"
                           value="<?php echo $filas[0]["INCREMENTO"];?>"></td>			
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaPedido();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaPedido(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_pedido1();"); //cambiar CALL sp_get_personas
        $consulta->execute();
        $filas=$consulta->fetchAll(PDO::FETCH_ASSOC);
        tabla($filas);
        $db = null;
    }
    
    function tabla($filas){
        ?><table border=2 width=100% id="datos1"><tr><?php
         if($filas){
        foreach($filas[0] as $indice => $valor){
            echo "<td>". $indice ."</td>";
        }
		}
        
        ?><td colspan="2">ADMINISTRACI&Oacute;N</td></tr><?php
        
		if($filas){
        foreach ($filas as $fila){
            echo "<tr>";
            foreach ($fila as $columna) {
                echo "<td>".utf8_encode($columna)."</td>";          
            }
            echo <<<HTML
                <td><input type='button' onclick='consulta(
                    "cls_pedidos.php?accion=eliminar&fecha={$fila["FECHA"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_pedidos.php?accion=actualizar&fecha={$fila["FECHA"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr>
                <td><input type="date" name="fecha" id="fecha"></td>
                <td><input type="text" name="pedido" id="pedido" class="textEntry" 
                           placeholder="Pedido" maxlength="25"></td>
						   
						   <?php 
			
			global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='clase' data-native-menu='false' id='clase'>";
						 
	    $consulta = $db->prepare("SELECT clase_pedidos FROM tipospedidos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
				$nomb = $row['clase_pedidos'];
            
                echo "<option value='".$nomb."'>".$nomb."</option>";
				
				}
			}
			
			?>
						   
						   </td>
                <td><input type="text" name="total" id="total" class="textEntry"
                           placeholder="Total" maxlength="25"></td>
						   
						   <?php 
			
			global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='cliente' data-native-menu='false' id='cliente'>";
						 
	    $consulta = $db->prepare("SELECT cliente FROM cliente");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
				$nomb = $row['cliente'];
            
                echo "<option value='".$nomb."'>".$nomb."</option>";
				
				}
			}
			
			?></td>
						  
						   
						   <?php 
			
			global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='dni' data-native-menu='false' id='dni'>";
						 
	    $consulta = $db->prepare("SELECT dni_repartidor FROM repartidores");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
				$nomb = $row['dni_repartidor'];
            
                echo "<option value='".$nomb."'>".$nomb."</option>";
				
				}
			}
			
			?>
						   
						   </td>			
				<td><input type="text" name="valor" id="valor" class="textEntry"
                           placeholder="Valor" maxlength="25"></td>		   
				<td><input type="text" name="incremento" id="incremento" class="textEntry"
                           placeholder="Incremento" maxlength="25"></td>		   
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaPedido();"></td>
            
            </tr>
    </table>
        <?php
    }
?>