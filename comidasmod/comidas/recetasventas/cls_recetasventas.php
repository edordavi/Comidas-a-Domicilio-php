
<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaRecetasVentas();
                break;
            case "eliminar":
                eliminaRecetasVentas();
                break;
            case "actualizar":
                actualizaRecetasVentas();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaRecetasVentas(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
        $ventas = $_GET["ventas"];
        $ingrediente=$_GET["ingrediente"];
		
		explode($parts,"~");
		
		$fecha = $parts[0];
		$pedido = $parts[1];
		$venta = $parts[2];
		
        $consulta=$db->prepare("CALL sp_nuevo_recetaspizza(:fehca,:pedido,:venta,:ingrediente);");
        $consulta->bindParam(":fecha",$fecha, PDO::PARAM_STR);
		$consulta->bindParam(":pedido",$pedido, PDO::PARAM_STR,3);
		$consulta->bindParam(":venta",$venta, PDO::PARAM_STR,3);
        $consulta->bindParam(":ingrediente", $ingrediente, PDO::PARAM_STR,4);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaRecetasVentas();
    }
    
    function actualizaRecetasVentas(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["venta2"])){
            $fecha1 = $_GET["fecha1"];
            $fecha2 = $_GET["fecha2"];
			$pedido1 = $_GET["pedido1"];
            $pedido2 = $_GET["pedido2"];
			$venta1 = $_GET["venta1"];
            $venta2 = $_GET["venta2"];
            $ingrediente=$_GET["ingrediente"];
			
            $consulta=$db->prepare("CALL sp_actualiza_recetasventas(:fecha1,:fecha2,:pedido1,:pedido2,:venta1,:venta2,:ingrediente);");
            $consulta->bindParam(":fecha1",$fecha1, PDO::PARAM_STR);
            $consulta->bindParam(":fecha2",$fecha2, PDO::PARAM_STR);
			$consulta->bindParam(":pedido1",$pedido1, PDO::PARAM_STR);
            $consulta->bindParam(":pedido2",$pedido2, PDO::PARAM_STR);
			$consulta->bindParam(":venta1",$venta1, PDO::PARAM_STR);
            $consulta->bindParam(":venta2",$venta2, PDO::PARAM_STR);
            $consulta->bindParam(":ingrediente", $ingrediente, PDO::PARAM_STR);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaRecetasVentas();   
            
        }else{
            consultaRecetasPizzaActualizar($_GET['fecha'],$_GET['pedido'],$_GET['venta'],$_GET['ingrediente']);
        }
    }
    
    function eliminaRecetasVentas(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
        $ventas = $_GET["ventas"];
        $ingrediente=$_GET["ingrediente"];
		
		explode($parts,"~");
		
		$fecha = $parts[0];
		$pedido = $parts[1];
		$venta = $parts[2];
		
		$ingrediente = $_GET["ingrediente"];
        $consulta=$db->prepare("CALL sp_elimina_recetasventas(:fecha,:pedido,:venta,:ingrediente);");
        $consulta->bindParam(":fecha",$fecha, PDO::PARAM_STR);
		$consulta->bindParam(":pedido",$pedido, PDO::PARAM_STR);
		$consulta->bindParam(":venta",$venta, PDO::PARAM_STR);
		$consulta->bindParam(":ingrediente",$ingrediente, PDO::PARAM_STR);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaRecetasVentas();
    }
    
    function consultaRecetasVentasActualizar($fecha1,$pedido1,$venta1,$ingrediente1){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }

        $consulta=$db->prepare("CALL sp_get_recetasventas_esp(:fecha,:pedido,:venta,:ingrediente);");
		$consulta->bindParam(":fecha",$fecha1, PDO::PARAM_STR);
		$consulta->bindParam(":pedido",$pedido1, PDO::PARAM_STR);
		$consulta->bindParam(":venta",$venta1, PDO::PARAM_STR);
		$consulta->bindParam(":ingrediente",$ingrediente1, PDO::PARAM_STR, 4);
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
						    <input type="text" name="fechao" id="fechao" class="oculto" 
                           placeholder="zzz" maxlength="10"
                           value="<?php echo $filas[0]["FECHA"];?>"></td>
						   <input type="text" name="pedidoo" id="pedidoo" class="oculto" 
                           placeholder="zzz" maxlength="10"
                           value="<?php echo $filas[0]["PEDIDO"];?>"></td>
						   <input type="text" name="ventao" id="ventao" class="oculto" 
                           placeholder="zzz" maxlength="10"
                           value="<?php echo $filas[0]["VENTA"];?>"></td>
						   <input type="text" name="ingredienteo" id="ingredienteo" class="oculto" 
                           placeholder="zzz" maxlength="4"
                           value="<?php echo $filas[0]["INGREDIENTE"];?>"></td>
				<?PHP
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ventasN' data-native-menu='false' id='ventasN'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT fecha_pedido,pedido,venta FROM ventasproductos ");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $fec = $row['fecha_pedido'];
				$ped = $row['pedido'];
				$ven = $row['venta'];
            
			    if($filas[0]["FECHA"] == $fec && $filas[0]["PEDIDO"] == $ped && $filas[0]["VENTA"] == $ven){
				    echo "<option selected='selected' value='".$fec."~".$ped."~".$ven."'>".$fec." ".$ped." ".$ven."</option>";
				}else{
				    echo "<option value='".$fec."~".$ped."~".$ven."'>".$fec." ".$ped." ".$ven."</option>";
				}
				
				}
			}
			echo "</select></td>";	
						   
				global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ingredienteN' data-native-menu='false' id='ingredienteN'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT ingrediente, nombre_ingrediente FROM ingredientes");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ingre = $row['ingrediente'];
				$nombre = $row['nombre_ingrediente'];
            
			    if($filas[0]["INGREDIENTE"] == $ingre){
				    echo "<option selected='selected' value='".$ingre."'>".$nombre."</option>";
				}else{
				    echo "<option value='".$ingre."'>".$nombre."</option>";
				}
				
				}
			}
			echo "</select></td>";	
						   
				?>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaRecetasPizza();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaRecetasVentas(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_recetasventas();");
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
                    "cls_recetasventas.php?accion=eliminar&fecha={$fila["FECHA"]}&pedido={$fila["PEDIDO"]}&venta={$fila["VENTA"]}&ingrediente={$fila["INGREDIENTE"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_recetasventas.php?accion=actualizar&fecha={$fila["FECHA"]}&pedido={$fila["PEDIDO"]}&venta={$fila["VENTA"]}&ingrediente={$fila["INGREDIENTE"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr><?PHP
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ventas' data-native-menu='false' id='ventas'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT fecha_pedido,pedido,venta FROM ventasproductos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $fec = $row['fecha_pedido'];
				$ped = $row['pedido'];
				$ven = $row['venta'];
            
                echo "<option value='".$fec."~".$ped."~".$ven."'>".$fec." ".$ped." ".$ven."</option>";
				
				}
			}
			echo "</select></td>";	
						   
			global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ingrediente' data-native-menu='false' id='ingrediente'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT ingrediente,nombre_ingrediente FROM ingredientes");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ingre = $row['ingrediente'];
				$nombre = $row['nombre_ingrediente'];
            
				    echo "<option value='".$ingre."'>".$nombre."</option>";
				
				}
			}
			echo "</select></td>";	
						   
                ?>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaRecetasVentas();"></td>
            
            </tr>
    </table>
        <?php
    }
?>