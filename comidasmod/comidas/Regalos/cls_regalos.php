<?php
require_once '../conexioncomidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertarRegalo();
                break;
            case "eliminar":
                eliminarRegalo();
                break;
            case "actualizar":
                actualizaRegalo();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertarRegalo(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $regalo = $_GET["regalo"];
        $motivo = $_GET["motivo"];
        $limite = $_GET["limite"];
        $consulta=$db->prepare("CALL sp_nuevo_regalo(:regalo,:motivo,:limite);");
        $consulta->bindParam(":regalo",$regalo, PDO::PARAM_STR, 5);
        $consulta->bindParam(":motivo", $motivo, PDO::PARAM_STR, 4);
        $consulta->bindParam(":limite", $limite, PDO::PARAM_STR, 4);     
		$consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaRegalo();
    }
    
    function actualizaRegalo(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["regalo"])){
            $regalo = $_GET["regalo"];
			$motivo=$_GET["motivo"];
			$limite=$_GET["limite"];
            $consulta=$db->prepare("CALL sp_actualiza_regalo(:regalo,:motivo,:limite);");
            $consulta->bindParam(":regalo",$regalo, PDO::PARAM_STR, 5);
            $consulta->bindParam(":motivo", $motivo, PDO::PARAM_STR, 4);
            $consulta->bindParam(":limite", $limite, PDO::PARAM_STR, 4); 
			$consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaRegalo();   //cambiar por consulta cliente
            
        }else{
            consultaRegaloActualizar($_GET["regalo"]);
        }
    }
    
    function eliminarRegalo(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $regalo = $_GET["regalo"];
        $consulta=$db->prepare("CALL sp_elimina_regalo(:regalo);");
        $consulta->bindParam(":regalo",$regalo, PDO::PARAM_STR, 5);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaRegalo();//cambiar por colsulta personas
    }
    
    function consultaRegaloActualizar(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_regalo();");
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
                           placeholder="xxxx" maxlength="15"
                           value="<?php echo $filas[0]["REGALO"];?>">  				   
                <td><input type="text" name="motivo" id="motivo" class="textEntry" 
                           placeholder="Motivo" maxlength="25"
                           value="<?php echo $filas[0]["MOTIVO"];?>"></td>
                <td><input type="text" name="limite" id="limite" class="textEntry"
                           placeholder="Limite" maxlength="25"
                           value="<?php echo $filas[0]["LIMITE"];?>"></td>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaRegalo();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaRegalo(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_regalo();"); //cambiar CALL sp_get_personas
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
                    "cls_regalos.php?accion=eliminar&regalo={$fila["REGALO"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_regalos.php?accion=actualizar&regalo={$fila["REGALO"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr>
                <td><input type="text" name="regalo" id="regalo" class="textEntry" 
                           placeholder="regalo" maxlength="15"></td>
                <td><input type="text" name="motivo" id="motivo" class="textEntry" 
                           placeholder="Motivo" maxlength="25"></td>
                <td><input type="text" name="limite" id="limite" class="textEntry"
                           placeholder="Limite" maxlength="25"></td>            
                <td colspan="2"><input type="button" value="Agregar" onclick="insertarRegalo();"></td>
            
            </tr>
    </table>
        <?php
    }
?>