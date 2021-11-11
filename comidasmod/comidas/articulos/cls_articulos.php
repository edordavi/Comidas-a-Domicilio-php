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
        $art = $_GET["art"];
        $tam = $_GET["tam"];
        $prc = $_GET["prc"];
        $consulta=$db->prepare("CALL sp_nuevo_articulo(:art,:tam,:prc);");
        $consulta->bindParam(":art",$art, PDO::PARAM_STR, 10);
        $consulta->bindParam(":tam",$tam, PDO::PARAM_STR, 1);
        $consulta->bindParam(":prc",$prc);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaFamilias("","");
    }
    
    function eliminaFamilia(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $art = $_GET["art"];
        $tam = $_GET["tam"];
        $consulta=$db->prepare("CALL sp_elimina_articulos(:art,:tam);");
        $consulta->bindParam(":art",$art, PDO::PARAM_STR, 10);
        $consulta->bindParam(":tam",$tam, PDO::PARAM_STR, 1);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaFamilias("","");
    }
    
    function consultaFamilias($art,$tam){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_articulos(:art,:tam);");
        $consulta->bindParam(":art",$art, PDO::PARAM_STR, 10);
        $consulta->bindParam(":tam",$tam, PDO::PARAM_STR, 1);
        $consulta->execute();
        $filas=$consulta->fetchAll(PDO::FETCH_ASSOC);
        tabla($filas);
        $db = null;
    }
    
    function tabla($filas){
        ?><table border=2 width=100% id="datos1"><?php
        if(!isset($filas[0])){
           echo "<p>Aqui no hay datos por ahora</p>"; 
        }else{ 
            echo "<tr>";
            foreach($filas[0] as $indice => $valor){
                echo "<td>". $indice ."</td>";
            }
        
        ?><td colspan="1">ADMINISTRACI&Oacute;N</td></tr><?php
        }
        foreach ($filas as $fila){
            echo "<tr>";
            foreach ($fila as $columna) {
                echo "<td>".utf8_encode($columna)."</td>";          
            }
            echo <<<HTML
                <td><input type='button' onclick='consulta(
                    "cls_articulos.php?accion=eliminar&art={$fila["ARTICULO"]}&tam={$fila["TAMANIO"]}");' value='ELIMINAR'>
                </td> 
HTML;
            echo "</tr>";
        }
        ?>
            <tr>
                <td><input type="text" name="art" id="art" class="textEntry" 
                           placeholder="Nombre de Articulo" maxlength="10"></td>
                <td><select id="tam" name="tam" class="textEntry">
                        <option value="G" selected>Grande</option>
                        <option value="M">Mediana</option>
                        <option value="P">Pequenia</option>
                    </select></td>
                <td><input type="number" name="prc" id="prc" class="textEntry" 
                           placeholder="Precio de Articulo" maxlength="4" min="0" max="9999" step="10"></td>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaFamilia();"></td>
            
            </tr>
    </table>
        <?php
    }
?>