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
        $und = $_GET["und"];
        $vlr = $_GET["vlr"];
        $fch = $_GET["fch"];
        $ped = $_GET["ped"];
        $vnt = $_GET["vnt"];
        
        $consulta=$db->prepare("CALL sp_nueva_ventasproductos(:fch,:ped,:vnt,:art,:tam,:und,:vlr);");
        $consulta->bindParam(":ped",$ped);
        $consulta->bindParam(":vnt",$vnt);
        $consulta->bindParam(":fch",$fch);
        $consulta->bindParam(":art",$art,PDO::PARAM_STR,10);
        $consulta->bindParam(":tam",$tam,PDO::PARAM_STR,1);
        $consulta->bindParam(":und",$und);
        $consulta->bindParam(":vlr",$vlr);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        //if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode();
            echo "Info Error: "; 
            print_r($consulta->errorInfo());
        //}
        echo "</p>";
        $db = null;
        consultaFamilias("","","");
    }
    
    function eliminaFamilia(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        $art = $_GET["art"];
        $tam = $_GET["tam"];
        $und = $_GET["und"];
        
        $consulta=$db->prepare("CALL sp_elimina_ventasproductos(:fch,:ped,:vnt);");
        $consulta->bindParam(":ped",$ped);
        $consulta->bindParam(":vnt",$vnt);
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
    
    function consultaFamilias($fch,$ped,$vnt){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_ventasproductos(:fch,:ped,:vnt);");
        $consulta->bindParam(":fch",$fch);
        $consulta->bindParam(":ped",$ped);
        $consulta->bindParam(":vnt",$vnt);
        $consulta->execute();
//        print_r($consulta->errorInfo());
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
                    "cls_ventasproductos.php?accion=eliminar&art={$fila["FECHA"]}&tam={$fila["PEDIDO"]}&vnt={$fila["VENTA"]}");' value='ELIMINAR'>
                </td> 
HTML;
            echo "</tr>";
        }
        ?>
            <tr>
                <td><input type="date" name="fch" id="fch" class="textEntry" 
                           placeholder="Fecha Pedido"></td><?php
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ped' data-native-menu='false' id='ped'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT pedido FROM pedidos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ped = $row['pedido'];
            
                echo "<option value='".$ped."'>".$ped."</option>";
				
				}
			}
			?></select></td><?php
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='vnt' data-native-menu='false' id='vnt'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT venta FROM ventasproductos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ven = $row['venta'];
            
                echo "<option value='".$ven."'>".$ven."</option>";
				
				}
			}
			?></select></td>
						   
						   <?php
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='art' data-native-menu='false' id='art'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT articulo FROM articulos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $art = $row['articulos'];
            
                echo "<option value='".$art."'>".$art."</option>";
				
				}
			}
			echo "</select></td>";	
						   
						   ?>
                <td><select id="tam" name="tam" class="textEntry">
                        <option value="G" selected>Grande</option>
                        <option value="M">Mediana</option>
                        <option value="P">Pequenia</option>
                    </select></td>
                <td><input type="number" name="und" id="und" class="textEntry" 
                           placeholder="Unidades" maxlength="2"
                           min="1" max="99" step="1"></td>
                <td><input type="number" name="vlr" id="vlr" class="textEntry" 
                           placeholder="Valor Venta" maxlength="4" min="0" 
                           max="9999" step="10"></td>
                <td colspan="2"><input type="button" value="Agregar" 
                                       onclick="insertaFamilia();"></td>
            
            </tr>
    </table>
        <?php
    }
?>