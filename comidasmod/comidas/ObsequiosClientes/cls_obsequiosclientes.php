<?php
require_once '../conexioncomidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertarObesequioc();
                break;
            case "eliminar":
                eliminarObesequioc();
                break;
            case "actualizar":
                actualizaObesequioc();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertarObesequioc(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $regalo = $_GET["regalo"];
        $motivo = $_GET["motivo"];
        $cliente = $_GET["cliente"];
        $fecha = $_GET["fecha"];
        $consulta=$db->prepare("CALL sp_nuevo_cliente_obsequio(:regalo,:motivo,:cliente,:fecha);");
        $consulta->bindParam(":regalo",$regalo, PDO::PARAM_STR, 5);
        $consulta->bindParam(":motivo", $motivo, PDO::PARAM_STR, 4);
        $consulta->bindParam(":cliente", $cliente, PDO::PARAM_STR, 5);
        $consulta->bindParam(":fecha", $fecha, PDO::PARAM_STR, 30);
		$consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaClienteOb();//cambiar por consultaclientes OJO
    }
    
    function actualizaClienteOb(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["regalo"])){
            $regalo = $_GET["regalo"];
			$motivo=$_GET["motivo"];
			$cliente=$_GET["cliente"];
			$fecha=$_GET["fecha"];
            $consulta=$db->prepare("CALL sp_actualiza_cliente_obesquio(:regalo,:motivo,:cliente,:fecha);");
            $consulta->bindParam(":regalo",$regalo, PDO::PARAM_STR, 5);
			$consulta->bindParam(":motivo", $motivo, PDO::PARAM_STR, 4);
			$consulta->bindParam(":cliente", $cliente, PDO::PARAM_STR, 5);
			$consulta->bindParam(":fecha", $fecha, PDO::PARAM_STR, 30);
			$consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaClienteOb();   //cambiar por consulta cliente
            
        }else{
            consultaClienteActualizarOb($_GET["cliente"]);
        }
    }
    
    function eliminarObesequioc(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $regalo = $_GET["regalo"];
        $consulta=$db->prepare("CALL sp_elimina_cliente_obsequio(:regalo);");
        $consulta->bindParam(":regalo",$regalo, PDO::PARAM_STR, 5);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaClienteOb();//cambiar por colsulta personas
    }
    
    function consultaClienteActualizarOb(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_clientes_obsequio();");
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
                <td><input type="text" name="regalo" id="regalo" class="textEntry" 
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["regalo"];?>">  
					<input type="text" name="regalo1" id="regalo1" class="oculto" 		
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["REGALO"];?>"></td>						   
                <td><input type="text" name="motivo" id="motivo" class="textEntry" 
                           placeholder="Motivo" maxlength="25"
                           value="<?php echo $filas[0]["MOTIVO"];?>"></td>
                <td><input type="text" name="cliente" id="cliente" class="textEntry"
                           placeholder="Cliente #" maxlength="25"
                           value="<?php echo $filas[0]["CLIENTE"];?>"></td>
                <td><input type="text" name="fecha" id="fecha" class="textEntry"
                           placeholder="Fecha" maxlength="25"
                           value="<?php echo $filas[0]["FECHA"];?>"></td>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaClienteOb();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaClienteOb(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_clientes_obsequio();"); //cambiar CALL sp_get_personas
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
                    "cls_obsequiosclientes.php?accion=eliminar&regalo={$fila["REGALO"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_obsequiosclientes.php?accion=actualizar&regalo={$fila["REGALO"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr>
						   
						   <?php 
			
			global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='regalo' data-native-menu='false' id='regalo'>";
						 
	    $consulta = $db->prepare("SELECT regalo FROM regalos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
				$nomb = $row['regalo'];
            
                echo "<option value='".$nomb."'>".$nomb."</option>";
				
				}
			}
			
			?>
						   
						   </td>
                <td><input type="text" name="motivo" id="motivo" class="textEntry" 
                           placeholder="Motivo" maxlength="1"></td>
						   
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
			
			?>
						   
						   </td>
                <td><input type="date" name="fecha" id="fecha"></td>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaClienteOB();"></td>
            
            </tr>
    </table>
        <?php
    }
?>