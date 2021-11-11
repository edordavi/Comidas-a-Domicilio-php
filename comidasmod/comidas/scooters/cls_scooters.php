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
        $sco = $_GET["sco"];
        $anio = $_GET["anio"];
        $consulta=$db->prepare("CALL sp_nuevo_scooter(:sco,:anio);");
        $consulta->bindParam(":sco",$sco, PDO::PARAM_STR,6 );
        $consulta->bindParam(":anio",$anio);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaFamilias("");
    }
    
    function eliminaFamilia(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $sco = $_GET["sco"];
        $consulta=$db->prepare("CALL sp_elimina_scooter(:sco);");
        $consulta->bindParam(":sco",$sco, PDO::PARAM_STR, 6);
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
    
    function consultaFamilias($fam){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_scooters(:sco);");
        $consulta->bindParam(":sco",$fam, PDO::PARAM_STR, 6);
        $consulta->execute();
        $filas=$consulta->fetchAll(PDO::FETCH_ASSOC);
        tabla($filas);
        $db = null;
    }
    
    function tabla($filas){
        ?><table border=2 width=100% id="datos1"><?php
        if(!isset($filas[0])){
           echo "Aqui no hay datos por ahora"; 
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
                    "cls_scooters.php?accion=eliminar&sco={$fila["SCOOTER"]}");' value='ELIMINAR'>
                </td> 
HTML;
            echo "</tr>";
        }
        ?>
            <tr>
                <td><input type="text" name="sco" id="sco" class="textEntry" 
                           placeholder="Nombre de Scooter" maxlength="6"></td>
                <td><input type="number" name="anio" id="anio" class="textEntry" 
                           placeholder="Anio de Scooter" maxlength="4" max="9999" min="1000" step="1"></td>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaFamilia();"></td>
            
            </tr>
    </table>
        <?php
    }
?>