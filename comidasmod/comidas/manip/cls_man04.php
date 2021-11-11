<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            default:
                break;
        }
    }
       
    
    function consultaFamilias($fam){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_consulta004();");

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
        
        ?></tr><?php
        }
        foreach ($filas as $fila){
            echo "<tr>";
            foreach ($fila as $columna) {
                echo "<td>".utf8_encode($columna)."</td>";          
            }
            
            echo "</tr>";
        }
        ?>
    </table>
        <?php
    }
?>