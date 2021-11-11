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
        $fch = $_GET["fch"];
        $cst = $_GET["cst"];
        $consulta=$db->prepare("CALL sp_nuevo_abastecer(:sco,:fch,:cst);");
        $consulta->bindParam(":sco",$sco, PDO::PARAM_STR,6 );
        $consulta->bindParam(":fch",$fch);
        $consulta->bindParam(":cst",$cst);
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
        $sco = $_GET["sco"];
        $fch = $_GET["fch"];
        $consulta=$db->prepare("CALL sp_elimina_abastecer(:sco,:fch);");
        $consulta->bindParam(":sco",$sco, PDO::PARAM_STR, 6);
        $consulta->bindParam(":fch",$fch);
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
    
    function consultaFamilias($fam,$fch){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_abastecer(:sco,:fch);");
        $consulta->bindParam(":sco",$fam, PDO::PARAM_STR, 6);
        $consulta->bindParam(":fch",$fch);
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
                    "cls_abastecer.php?accion=eliminar&sco={$fila["SCOOTER"]}&fch={$fila["FECHA"]}");' value='ELIMINAR'>
                </td> 
HTML;
            echo "</tr>";
        }
        ?>
            <tr>
                <?PHP
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='sco' data-native-menu='false' id='sco'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT scooter FROM scooter");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $scu = $row['scooter'];
            
                echo "<option value='".$scu."'>".$scu."</option>";
				
				}
			}
			echo "</select></td>";	
						   
                ?><td><input type="date" name="fch" id="fch" class="textEntry" 
                           placeholder="Fecha de Abastecer" maxlength="4"></td>
                <td><input type="number" name="cst" id="cst" class="textEntry" 
                           placeholder="Costo de Abastecer" maxlength="3" min="0" max="999" step="10"></td>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaFamilia();"></td>
            
            </tr>
    </table>
        <?php
    }
?>