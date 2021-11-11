
<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaClaseArticulo();
                break;
            case "eliminar":
                eliminaClaseArticulo();
                break;
            case "actualizar":
                actualizaClaseArticulo();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaClaseArticulo(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $articulo = $_GET["articulo"];
        $tipoarticulo=$_GET["tipoarticulo"];
        $consulta=$db->prepare("CALL sp_nuevo_clasearticulo(:articulo,:tipoarticulo);");
        $consulta->bindParam(":articulo",$articulo, PDO::PARAM_STR,10);
        $consulta->bindParam(":tipoarticulo", $tipoarticulo, PDO::PARAM_STR,1);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaClaseArticulos();
    }
    
    function actualizaClaseArticulo(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["articulo2"])){
            $articulo1 = $_GET["articulo1"];
            $articulo2 = $_GET["articulo2"];
            $tipoarticulo=$_GET["tipoarticulo"];

            $consulta=$db->prepare("CALL sp_actualiza_clasearticulo(:articulo1,:articulo2,:tipoarticulo);");
            $consulta->bindParam(":articulo1",$articulo1, PDO::PARAM_STR);
            $consulta->bindParam(":articulo2",$articulo2, PDO::PARAM_STR);
            $consulta->bindParam(":tipoarticulo", $tipoarticulo, PDO::PARAM_STR);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaClaseArticulos();   
            
        }else{
            consultaClaseArticulosActualizar($_GET['articulo']);
        }
    }
    
    function eliminaClaseArticulo(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $articulo = $_GET["articulo"];
        $consulta=$db->prepare("CALL sp_elimina_clasearticulo(:articulo);");
        $consulta->bindParam(":articulo",$articulo, PDO::PARAM_STR);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaClaseArticulos();
    }
    
    function consultaClaseArticulosActualizar($articulo1){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }

        $consulta=$db->prepare("CALL sp_get_clasearticulo_esp(:articulo);");
		$consulta->bindParam(":articulo",$articulo1, PDO::PARAM_STR, 10);
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
						    <input type="text" name="articuloo" id="articuloo" class="oculto" 
                           placeholder="zzz" maxlength="10"
                           value="<?php echo $filas[0]["ARTICULO"];?>"></td>
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
						   
                ?><td><select name="tipoarticuloN" id="tipoarticuloN"><?php
				if( $filas[0]["TIPO DE ARTICULO"] == "P"){
				    echo "<option selected='selected' value='P'>Pizza</option>";
				}else{
				    echo "<option value='P'>Pizza</option>";
				}
				if( $filas[0]["TIPO DE ARTICULO"] == "B"){
				    echo "<option selected='selected' value='B'>Bocadillos</option>";
				}else{
				    echo "<option value='B'>Bocadillos</option>";
				}
				if( $filas[0]["TIPO DE ARTICULO"] == "C"){
                    echo "<option selected='selected' value='C'>Complemento</option>";				
				}else{
				    echo "<option value='C'>Complemento</option>";
				}
				?></td>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaClaseArticulo();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaClaseArticulos(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_clasearticulo();");
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
                    "cls_clasearticulos.php?accion=eliminar&articulo={$fila["ARTICULO"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_clasearticulos.php?accion=actualizar&articulo={$fila["ARTICULO"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr><?PHP
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='articulo' data-native-menu='false' id='articulo'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT articulo FROM articulos WHERE articulos.articulo NOT IN (SELECT articulo FROM clasearticulos)");
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
						   
                ?><td><select name="tipoarticulo" id="tipoarticulo">
				<option value='P'>Pizza</option>
				<option value='B'>Bocadillos</option>
				<option value='C'>Complemento</option>
				</td>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaClaseArticulo();"></td>
            
            </tr>
    </table>
        <?php
    }
?>