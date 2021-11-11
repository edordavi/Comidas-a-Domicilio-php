
<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaIngrediente();
                break;
            case "eliminar":
                eliminaIngrediente();
                break;
            case "actualizar":
                actualizaIngrediente();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaIngrediente(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $ingrediente = $_GET["ingrediente"];
        $nombre=$_GET["nombre"];
        $consulta=$db->prepare("CALL sp_nuevo_ingrediente(:ingrediente,:nombre);");
        $consulta->bindParam(":ingrediente",$ingrediente, PDO::PARAM_STR,4);
        $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR,10);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaIngredientes();
    }
    
    function actualizaIngrediente(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["ingrediente2"])){
            $ingrediente1 = $_GET["ingrediente1"];
            $ingrediente2 = $_GET["ingrediente2"];
            $nombre=$_GET["nombre"];

            $consulta=$db->prepare("CALL sp_actualiza_ingrediente(:ingrediente1,:ingrediente2,:nombre);");
            $consulta->bindParam(":ingrediente1",$ingrediente1, PDO::PARAM_STR);
            $consulta->bindParam(":ingrediente2",$ingrediente2, PDO::PARAM_STR);
            $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaIngredientes();   
            
        }else{
            consultaIngredientesActualizar($_GET['ingrediente']);
        }
    }
    
    function eliminaIngrediente(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $ingrediente = $_GET["ingrediente"];
        $consulta=$db->prepare("CALL sp_elimina_ingrediente(:ingrediente);");
        $consulta->bindParam(":ingrediente",$ingrediente, PDO::PARAM_STR);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaIngredientes();
    }
    
    function consultaIngredientesActualizar($ingrediente1){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }

        $consulta=$db->prepare("CALL sp_get_ingrediente_esp(:ingrediente);");
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
                <td><input type="text" name="ingredienteN" id="ingredienteN" class="textEntry" 
                           placeholder="xxxx" maxlength="4"
                           value="<?php echo $filas[0]["INGREDIENTE"];?>">
						    <input type="text" name="ingredienteo" id="ingredienteo" class="oculto" 
                           placeholder="zzz" maxlength="4"
                           value="<?php echo $filas[0]["INGREDIENTE"];?>"></td>
                <td><input type="text" name="nombreN" id="nombreN" class="textEntry" 
                           placeholder="Nombre" maxlength="25"
                           value="<?php echo $filas[0]["NOMBRE DEL INGREDIENTE"];?>"></td>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaIngrediente();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaIngredientes(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_ingredientes();");
        $consulta->execute();
        $filas=$consulta->fetchAll(PDO::FETCH_ASSOC);
        tabla($filas);
        $db = null;
    }
    
    function tabla($filas){
        ?><table border=2 width=100% id="datos1"><tr><?php
         
        foreach($filas[0] as $indice => $valor){
            echo "<td>". $indice ."</td>";
        }
        
        ?><td colspan="2">ADMINISTRACI&Oacute;N</td></tr><?php
        
        foreach ($filas as $fila){
            echo "<tr>";
            foreach ($fila as $columna) {
                echo "<td>".utf8_encode($columna)."</td>";          
            }
            echo <<<HTML
                <td><input type='button' onclick='consulta(
                    "cls_ingredientes.php?accion=eliminar&ingrediente={$fila["INGREDIENTE"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_ingredientes.php?accion=actualizar&ingrediente={$fila["INGREDIENTE"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
        ?>
            <tr>
                <td><input type="text" name="ingrediente" id="ingrediente" class="textEntry" 
                           placeholder="xxxx" maxlength="4"></td>
                <td><input type="text" name="nombre" id="nombre" class="textEntry" 
                           placeholder="Nombre ingrediente" maxlength="10"></td>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaIngrediente();"></td>
            
            </tr>
    </table>
        <?php
    }
?>