
<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaProductoEstrella();
                break;
            case "eliminar":
                eliminaProductoEstrella();
                break;
            case "actualizar":
                actualizaProductoEstrella();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaProductoEstrella(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $nombre_comercial = $_GET["nombre_comercial"];
        $articulo=$_GET["articulo"];
        $consulta=$db->prepare("CALL sp_nuevo_productoestrella(:nombre_comercial,:articulo);");
        $consulta->bindParam(":nombre_comercial",$nombre_comercial, PDO::PARAM_STR,15);
        $consulta->bindParam(":articulo", $articulo, PDO::PARAM_STR,10);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaProductoEstrella();
    }
    
    function actualizaProductoEstrella(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["nombre_comercial2"])){
            $nombre_comercial1 = $_GET["nombre_comercial1"];
            $nombre_comercial2 = $_GET["nombre_comercial2"];
            $articulo=$_GET["articulo"];

            $consulta=$db->prepare("CALL sp_actualiza_productoestrella(:nombre_comercial1,:nombre_comercial2,:articulo);");
            $consulta->bindParam(":nombre_comercial1",$nombre_comercial1, PDO::PARAM_STR);
            $consulta->bindParam(":nombre_comercial2",$nombre_comercial2, PDO::PARAM_STR);
            $consulta->bindParam(":articulo", $articulo, PDO::PARAM_STR);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaProductoEstrella();   
            
        }else{
            consultaProductoEstrellaActualizar($_GET['nombre_comercial']);
        }
    }
    
    function eliminaProdcutoEstrella(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $nombre_comercial = $_GET["nombre_comercial"];
        $consulta=$db->prepare("CALL sp_elimina_productoestrella(:nombre_comercial);");
        $consulta->bindParam(":nombre_comercial",$nombre_comercial, PDO::PARAM_STR);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaIngredientes();
    }
    
    function consultaProductoEstrellaActualizar($nombre_comercial1){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }

        $consulta=$db->prepare("CALL sp_get_productoestrella_esp(:nombre_comercial);");
		$consulta->bindParam(":nombre_comercial",$nombre_comercial1, PDO::PARAM_STR, 15);
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
                <td><input type="text" name="nombre_comercialN" id="nombre_comercialN" class="textEntry" 
                           placeholder="nombre del prodcuto comercial" maxlength="15"
                           value="<?php echo $filas[0]["NOMBRE COMERCIAL"];?>">
						    <input type="text" name="nombre_comercialo" id="nombre_comercialo" class="oculto" 
                           placeholder="zzz" maxlength="15"
                           value="<?php echo $filas[0]["NOMBRE COMERCIAL"];?>"></td>
						   
						   <?PHP
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='articuloN' data-native-menu='false' id='articuloN'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT articulo FROM articulos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $arti = $row['articulo'];
            
			    if($filas[0]["ARTICULO"] == $arti){
				    echo "<option selected='selected' value='".$arti."'>".$arti."</option>";
				}else{
				    echo "<option value='".$arti."'>".$arti."</option>";
				}
				
				}
			}
			echo "</select></td>";
						   
                ?>
                <td colspan="1">
				<input type="button" value="Actualizar" onclick="actualizaProductoEstrella();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaProductoEstrella(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_productoestrella();");
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
                    "cls_productoestrella.php?accion=eliminar&nombre_comercial={$fila["NOMBRE COMERCIAL"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_productoestrella.php?accion=actualizar&nombre_comercial={$fila["NOMBRE COMERCIAL"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr>
                <td><input type="text" name="nombre_comercial" id="nombre_comercial" class="textEntry" 
                           placeholder="nombre comercial del producto" maxlength="15"></td>
                <?PHP
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='articulo' data-native-menu='false' id='articulo'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT articulo FROM articulos");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $arti = $row['articulo'];
            
				    echo "<option value='".$arti."'>".$arti."</option>";
				
				}
			}
			echo "</select></td>";
						   
                ?>
                <td colspan="2">
				<input type="button" value="Agregar" onclick="insertaProductoEstrella();"></td>
            
            </tr>
    </table>
        <?php
    }
?>