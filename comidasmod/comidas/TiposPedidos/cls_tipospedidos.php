<?php
require_once '../conexioncomidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertarTipoPedidos();
                break;
            case "eliminar":
                eliminarTipoPedidos();
                break;
            case "actualizar":
                actualizaTipoPedidos();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertarTipoPedidos(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $clase = $_GET["clase"];
        $incremento = $_GET["incremento"];
        $minimo = $_GET["minimo"];
        $consulta=$db->prepare("CALL sp_nuevo_tipopedido(:clase,:incremento,:minimo);");
        $consulta->bindParam(":clase",$clase, PDO::PARAM_STR, 20);
        $consulta->bindParam(":incremento", $incremento, PDO::PARAM_STR, 5);
        $consulta->bindParam(":minimo", $minimo, PDO::PARAM_STR, 4);     
		$consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaPedido();
    }
    
    function actualizaTipoPedidos(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["clase"])){
            $clase = $_GET["clase"];
			$incremento=$_GET["incremento"];
			$minimo=$_GET["minimo"];
            $consulta=$db->prepare("CALL sp_actualiza_pedido(:clase,:incremento,:minimo);");
            $consulta->bindParam(":clase",$clase, PDO::PARAM_STR, 20);
			$consulta->bindParam(":incremento", $incremento, PDO::PARAM_STR, 5);
			$consulta->bindParam(":minimo", $minimo, PDO::PARAM_STR, 4); 
			$consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaPedido();   //cambiar por consulta cliente
            
        }else{
            consultaPedidoActualizar($_GET["clase"]);
        }
    }
    
    function eliminarTipoPedidos(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $clase = $_GET["clase"];
        $consulta=$db->prepare("CALL sp_elimina_pedido(:clase);");
        $consulta->bindParam(":clase",$clase, PDO::PARAM_STR, 5);
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
        $consulta=$db->prepare("CALL sp_get_tipopedido();");
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
                <td><input type="text" name="clase" id="clase" class="textEntry" 
                           placeholder="xxxx" maxlength="15"
                           value="<?php echo $filas[0]["CLASE"];?>">  
					<input type="text" name="clase1" id="clase1" class="oculto" 		
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["CLASE"];?>"></td>						   
                <td><input type="text" name="incremento" id="incremento" class="textEntry" 
                           placeholder="Incremento" maxlength="25"
                           value="<?php echo $filas[0]["INCREMENTO"];?>"></td>
                <td><input type="text" name="minimo" id="minimo" class="textEntry"
                           placeholder="Minimo" maxlength="25"
                           value="<?php echo $filas[0]["MINIMO"];?>"></td>
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
        $consulta=$db->prepare("CALL sp_get_tipopedido();"); //cambiar CALL sp_get_personas
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
                    "cls_tipospedidos.php?accion=eliminar&clase={$fila["CLASE"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_tipospedidos.php?accion=actualizar&clase={$fila["CLASE"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr>
                <td><input type="text" name="clase" id="clase" class="textEntry" 
                           placeholder="Clase" maxlength="15"></td>
                <td><input type="text" name="incremento" id="incremento" class="textEntry" 
                           placeholder="Incremento" maxlength="25"></td>
                <td><input type="text" name="minimo" id="minimo" class="textEntry"
                           placeholder="Minimo" maxlength="25"></td>            
                <td colspan="2"><input type="button" value="Agregar" onclick="insertarPedidos();"></td>
            
            </tr>
    </table>
        <?php
    }
?>