
<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaPersona();
                break;
            case "eliminar":
                eliminaPersona();
                break;
            case "actualizar":
                actualizaPersona();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaPersona(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $dni = $_GET["dni"];
        $pnombre=$_GET["pnombre"];
        $snombre=$_GET["snombre"];
        $papellido=$_GET["papellido"];
        $sapellido=$_GET["sapellido"];
        $consulta=$db->prepare("CALL sp_nueva_persona(:dni,:pnombre,:snombre,:papellido,:sapellido);");
        $consulta->bindParam(":dni",$dni, PDO::PARAM_STR, 15);
        $consulta->bindParam(":pnombre", $pnombre, PDO::PARAM_STR, 25);
        $consulta->bindParam(":snombre", $snombre, PDO::PARAM_STR, 25);
        $consulta->bindParam(":papellido", $papellido, PDO::PARAM_STR, 25);
        $consulta->bindParam(":sapellido", $sapellido, PDO::PARAM_STR, 25);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaPersonas("","");
    }
    
    function actualizaPersona(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["pnombre"])){
            $dni1 = $_GET["dni1"];
            $dni2 = $_GET["dni2"];
            $pnombre=$_GET["pnombre"];
            $snombre=$_GET["snombre"];
            $papellido=$_GET["papellido"];
            $sapellido=$_GET["sapellido"];
            $consulta=$db->prepare("CALL sp_actualiza_persona(:dni1,:dni2,:pnombre,:snombre,:papellido,:sapellido);");
            $consulta->bindParam(":dni1",$dni1, PDO::PARAM_STR, 15);
            $consulta->bindParam(":dni2",$dni2, PDO::PARAM_STR, 15);
            $consulta->bindParam(":pnombre", $pnombre, PDO::PARAM_STR, 25);
            $consulta->bindParam(":snombre", $snombre, PDO::PARAM_STR, 25);
            $consulta->bindParam(":papellido", $papellido, PDO::PARAM_STR, 25);
            $consulta->bindParam(":sapellido", $sapellido, PDO::PARAM_STR, 25);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaPersonas("","");   
            
        }else{
            consultaPersonasActualizar($_GET["dni"],"");
        }
    }
    
    function eliminaPersona(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $dni = $_GET["dni"];
        $consulta=$db->prepare("CALL sp_elimina_persona(:dni);");
        $consulta->bindParam(":dni",$dni, PDO::PARAM_STR, 15);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaPersonas("","");
    }
    
    function consultaPersonasActualizar($dni,$nombre){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_personas(:dni,:nombre);");
        $consulta->bindParam(":dni",$dni, PDO::PARAM_STR, 15);
        $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR, 25);
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
                <td><input type="text" name="dni" id="dni" class="textEntry" 
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["DNI"];?>">
                            <input type="text" name="dnio" id="dnio" class="oculto" 
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"
                           value="<?php echo $filas[0]["DNI"];?>"></td>
                <td><input type="text" name="pnombre" id="pnombre" class="textEntry" 
                           placeholder="Primer Nombre" maxlength="25"
                           value="<?php echo $filas[0]["PRIMER NOMBRE"];?>"></td>
                <td><input type="text" name="snombre" id="snombre" class="textEntry"
                           placeholder="Segundo Nombre" maxlength="25"
                           value="<?php echo $filas[0]["SEGUNDO NOMBRE"];?>"></td>
                <td><input type="text" name="papellido" id="papellido" class="textEntry"
                           placeholder="Primer Apellid" maxlength="25"
                           value="<?php echo $filas[0]["PRIMER APELLIDO"];?>"></td>
                <td><input type="text" name="sapellido" id="sapellido" class="textEntry"
                           placeholder="Segundo Apellido" maxlength="25"
                           value="<?php echo $filas[0]["SEGUNDO APELLIDO"];?>"></td>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaPersona();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaPersonas($dni,$nombre){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_personas(:dni,:nombre);");
        $consulta->bindParam(":dni",$dni, PDO::PARAM_STR, 15);
        $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR, 25);
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
                    "cls_personas.php?accion=eliminar&dni={$fila["DNI"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_personas.php?accion=actualizar&dni={$fila["DNI"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
        ?>
            <tr>
                <td><input type="text" name="dni" id="dni" class="textEntry" 
                           placeholder="xxxx-xxxx-xxxxx" maxlength="15"></td>
                <td><input type="text" name="pnombre" id="pnombre" class="textEntry" 
                           placeholder="Primer Nombre" maxlength="25"></td>
                <td><input type="text" name="snombre" id="snombre" class="textEntry"
                           placeholder="Segundo Nombre" maxlength="25"></td>
                <td><input type="text" name="papellido" id="papellido" class="textEntry"
                           placeholder="Primer Apellid" maxlength="25"></td>
                <td><input type="text" name="sapellido" id="sapellido" class="textEntry"
                           placeholder="Segundo Apellido" maxlength="25"></td>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaPersona();"></td>
            
            </tr>
    </table>
        <?php
    }
?>