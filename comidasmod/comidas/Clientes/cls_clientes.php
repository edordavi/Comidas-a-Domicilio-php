<?php
require_once '../conexioncomidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaCliente();
                break;
            case "eliminar":
                eliminaCliente();
                break;
            case "actualizar":
                actualizaCliente();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaCliente(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $clienteid = $_GET["clienteid"];
        $nbcliente = $_GET["nbcliente"];
        $apcliente = $_GET["apcliente"];
        $drcliente = $_GET["drcliente"];
        $telcliente = $_GET["telcliente"];
		$cspizza = $_GET["cspizza"];
		$csbocadillos = $_GET["csbocadillos"];
		$cscomplemento = $_GET["cscomplemento"];
        $consulta=$db->prepare("CALL sp_nuevo_cliente(:clienteid,:nbcliente,:apcliente,:drcliente,:telcliente,:cspizza,:csbocadillos,:cscomplemento);");
        $consulta->bindParam(":clienteid",$clienteid, PDO::PARAM_STR, 5);
        $consulta->bindParam(":nbcliente", $nbcliente, PDO::PARAM_STR, 20);
        $consulta->bindParam(":apcliente", $apcliente, PDO::PARAM_STR, 40);
        $consulta->bindParam(":drcliente", $drcliente, PDO::PARAM_STR, 30);
        $consulta->bindParam(":telcliente", $telcliente, PDO::PARAM_STR, 9);
		$consulta->bindParam(":cspizza", $cspizza, PDO::PARAM_STR, 3);
		$consulta->bindParam(":csbocadillos", $csbocadillos, PDO::PARAM_STR, 3);
		$consulta->bindParam(":cscomplemento", $cscomplemento, PDO::PARAM_STR, 3);
		$consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaCliente();//cambiar por consultaclientes OJO
    }
    
    function actualizaCliente(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["nbcliente"])){
            $clienteid = $_GET["clienteid"];
			$nbcliente=$_GET["nbcliente"];
			$apcliente=$_GET["apcliente"];
			$drcliente=$_GET["drcliente"];
			$telcliente=$_GET["telcliente"];
			$cspizza=$_GET["cspizza"];
			$csbocadillos=$_GET["csbocadillos"];
			$cscomplemento=$_GET["cscomplemento"];
            $consulta=$db->prepare("CALL sp_actualiza_cliente(:clienteid,:nbcliente,:apcliente,:drcliente,:telcliente,:cspizza,:csbocadillos,:cscomplemento);");
            $consulta->bindParam(":clienteid",$clienteid, PDO::PARAM_STR, 5);
			$consulta->bindParam(":nbcliente", $nbcliente, PDO::PARAM_STR, 20);
			$consulta->bindParam(":apcliente", $apcliente, PDO::PARAM_STR, 40);
			$consulta->bindParam(":drcliente", $drcliente, PDO::PARAM_STR, 30);
			$consulta->bindParam(":telcliente", $telcliente, PDO::PARAM_STR, 9);
			$consulta->bindParam(":cspizza", $cspizza, PDO::PARAM_STR, 3);
			$consulta->bindParam(":csbocadillos", $csbocadillos, PDO::PARAM_STR, 3);
			$consulta->bindParam(":cscomplemento", $cscomplemento, PDO::PARAM_STR, 3);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaCliente();   //cambiar por consulta cliente
            
        }else{
            consultaClienteActualizar($_GET["clienteid"]);
        }
    }
    
    function eliminaCliente(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $clienteid = $_GET["clienteid"];
        $consulta=$db->prepare("CALL sp_elimina_cliente(:clienteid);");
        $consulta->bindParam(":clienteid",$clienteid, PDO::PARAM_STR, 15);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaCliente();//cambiar por colsulta personas
    }
    
    function consultaClienteActualizar(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_clientes();");
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
                <td><input type="text" name="clienteid" id="clienteid" class="textEntry" 
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["ID"];?>">  
					<input type="text" name="clienteid1" id="clienteid1" class="oculto" 		
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["ID"];?>"></td>						   
                <td><input type="text" name="nbcliente" id="nbcliente" class="textEntry" 
                           placeholder="Nombre" maxlength="25"
                           value="<?php echo $filas[0]["NOMBRE"];?>"></td>
                <td><input type="text" name="apcliente" id="apcliente" class="textEntry"
                           placeholder="Apellido" maxlength="25"
                           value="<?php echo $filas[0]["APELLIDOS"];?>"></td>
                <td><input type="text" name="drcliente" id="drcliente" class="textEntry"
                           placeholder="Direccion" maxlength="25"
                           value="<?php echo $filas[0]["DIRECCION"];?>"></td>
                <td><input type="text" name="telcliente" id="telcliente" class="textEntry"
                           placeholder="Telefono" maxlength="25"
                           value="<?php echo $filas[0]["TELEFONO"];?>"></td>
				<td><input type="text" name="cspizza" id="cspizza" class="textEntry"
                           placeholder="Consumo de Pizza" maxlength="25"
                           value="<?php echo $filas[0]["PIZZA"];?>"></td>
				<td><input type="text" name="csbocadillos" id="csbocadillos" class="textEntry"
                           placeholder="Telefono" maxlength="25"
                           value="<?php echo $filas[0]["BOCADILLOS"];?>"></td>
				<td><input type="text" name="cscomplemento" id="cscomplemento" class="textEntry"
                           placeholder="Telefono" maxlength="25"
                           value="<?php echo $filas[0]["COMPLEMENTOS"];?>"></td>			
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaCliente();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaCliente(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_clientes();"); //cambiar CALL sp_get_personas
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
                    "cls_clientes.php?accion=eliminar&clienteid={$fila["ID"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_clientes.php?accion=actualizar&clienteid={$fila["ID"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr>
                <td><input type="text" name="clienteid" id="clienteid" class="textEntry" 
                           placeholder="xxxxxx" maxlength="6"></td>
                <td><input type="text" name="nbcliente" id="nbcliente" class="textEntry" 
                           placeholder="Nombre" maxlength="25"></td>
                <td><input type="text" name="apcliente" id="apcliente" class="textEntry"
                           placeholder="Apellido" maxlength="25"></td>
                <td><input type="text" name="drcliente" id="drcliente" class="textEntry"
                           placeholder="Direccion" maxlength="25"></td>
                <td><input type="text" name="telcliente" id="telcliente" class="textEntry"
                           placeholder="Telefono" maxlength="25"></td>
				<td><input type="text" name="cspizza" id="cspizza" class="textEntry"
                           placeholder="consumo de pizza" maxlength="25"></td>			
				<td><input type="text" name="csbocadillos" id="csbocadillos" class="textEntry"
                           placeholder="consumo de Bocadillos" maxlength="25"></td>		   
				<td><input type="text" name="cscomplemento" id="cscomplemento" class="textEntry"
                           placeholder="consumo de Complementos" maxlength="25"></td>		   
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaCliente();"></td>
            
            </tr>
    </table>
        <?php
    }
?>