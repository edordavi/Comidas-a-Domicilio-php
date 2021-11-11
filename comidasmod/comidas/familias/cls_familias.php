<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaFamilia();
                break;
            case "eliminar":
                eliminaFamilia();
                break;
            case "actualizar":
                actualizaFamilia();
                break;
            default:
                break;
        }
    }
    function insertaFamilia(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $fam = $_GET["fam"];
        $consulta=$db->prepare("CALL sp_nueva_familia(:fam);");
        $consulta->bindParam(":fam",$fam, PDO::PARAM_STR, 50);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaFamilias("");
    }
    
    function actualizaFamilia(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["fam2"])){
            $fam1 = $_GET["fam1"];
            $fam2 = $_GET["fam2"];
            $consulta=$db->prepare("CALL sp_actualiza_familia(:fam1,:fam2);");
            $consulta->bindParam(":fam1",$fam1, PDO::PARAM_STR, 50);
            $consulta->bindParam(":fam2",$fam2, PDO::PARAM_STR, 50);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaFamilias("");   
            
        }else{
            consultaFamiliasActualizar($_GET["fam"]);
        }
    }
    
    function eliminaFamilia(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $fam = $_GET["fam"];
        $consulta=$db->prepare("CALL sp_elimina_familia(:fam);");
        $consulta->bindParam(":fam",$fam, PDO::PARAM_STR, 50);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaFamilias("");
    }
    
    function consultaFamiliasActualizar($fam){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_familias(:fam);");
        $consulta->bindParam(":fam",$fam, PDO::PARAM_STR, 50);
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
                <td><input type="text" name="fam" id="fam" class="textEntry" 
                           placeholder="Nombre de Familia" maxlength="50"
                           value="<?php echo $filas[0]["FAMILIA"];?>">
                            <input type="text" name="famo" id="famo" class="oculto" 
                           placeholder="Nombre de Familia" maxlength="50"
                           value="<?php echo $filas[0]["FAMILIA"];?>"></td>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaFamilia();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaFamilias($fam){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_familias(:fam);");
        $consulta->bindParam(":fam",$fam, PDO::PARAM_STR, 50);
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
                    "cls_familias.php?accion=eliminar&fam={$fila["FAMILIA"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_familias.php?accion=actualizar&fam={$fila["FAMILIA"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
        ?>
            <tr>
                <td><input type="text" name="fam" id="fam" class="textEntry" 
                           placeholder="Nombre de Familia" maxlength="50">
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaFamilia();"></td>
            
            </tr>
    </table>
        <?php
    }
?>