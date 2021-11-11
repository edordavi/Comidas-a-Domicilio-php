
<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaRecetaEstrella();
                break;
            case "eliminar":
                eliminaRecetaEstrella();
                break;
            case "actualizar":
                actualizaRecetaEstrella();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaRecetaEstrella(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $ingrediente = $_GET["ingrediente"];
        $nombre_comercial=$_GET["nombre_comercial"];
        $consulta=$db->prepare("CALL sp_nueva_recetaestrella(:nombre_comercial,:ingrediente);");
        $consulta->bindParam(":nombre_comercial", $nombre_comercial, PDO::PARAM_STR,14);
		$consulta->bindParam(":ingrediente",$ingrediente, PDO::PARAM_STR,4);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaRecetaEstrella();
    }
    
    function actualizaRecetaEstrella(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["nombre_comercial2"])){
            $nombre_comercial1 = $_GET["nombre_comercial1"];
            $nombre_comercial2 = $_GET["nombre_comercial2"];
            $ingrediente=$_GET["ingrediente"];

            $consulta=$db->prepare("CALL sp_actualiza_recetaestrella(:nombre_comercial1,:nombre_comercial2,:ingrediente);");
            $consulta->bindParam(":nombre_comercial1",$nombre_comercial1, PDO::PARAM_STR);
            $consulta->bindParam(":nombre_comercial2",$nombre_comercial2, PDO::PARAM_STR);
            $consulta->bindParam(":ingrediente", $ingrediente, PDO::PARAM_STR);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaRecetaEstrella();   
            
        }else{
            consultaRecetaEstrellaActualizar($_GET['nombre_comercial']);
        }
    }
    
    function eliminaRecetaEstrella(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $nombre_comercial = $_GET["nombre_comercial"];
        $consulta=$db->prepare("CALL sp_elimina_recetaestrella(:nombre_comercial);");
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
    
    function consultaRecetaEstrellaActualizar($nombre_estrella1){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }

        $consulta=$db->prepare("CALL sp_get_recetaestrella_esp(:nombre_comercial);");
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
                           placeholder="nombre" maxlength="14"
                           value="<?php echo $filas[0]["NOMBRE COMERCIAL"];?>">
						    <input type="text" name="nombre_comercialo" id="nombre_comercialo" class="oculto" 
                           placeholder="zzzz" maxlength="14"
                           value="<?php echo $filas[0]["NOMBRE COMERCIAL"];?>"></td><?php
						 
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ingredienteN' data-native-menu='false' id='ingredienteN'>";
						 
	    $consulta = $db->prepare("SELECT ingrediente,nombre_ingrediente FROM ingredientes");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ingre = $row['ingrediente'];
				$nomb = $row['nombre_ingrediente'];
            
                echo "<option value='".$ingre."'>".$nomb."</option>";
				
				}
			}
			echo "</select></td>";		   
						   
                ?><td colspan="1"><input type="button" value="Actualizar" onclick="actualizaRecetaEstrella();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaRecetaEstrella(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_recetaestrella();");
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
                    "cls_recetaestrella.php?accion=eliminar&nombre_comercial={$fila["NOMBRE COMERCIAL"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_recetaestrella.php?accion=actualizar&nombre_comercial={$fila["NOMBRE COMERCIAL"]}");'
                        value="ACTUALIZAR"></td>
HTML;
            echo "</tr>";
        }
		}
        ?>
            <tr>
			<?php 
			
			global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='nombre_comercial' data-native-menu='false' id='nombre_comercial'>";
						 
	    $consulta = $db->prepare("SELECT nombre_comercial FROM productosestrella");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
				$nomb = $row['nombre_comercial'];
            
                echo "<option value='".$nomb."'>".$nomb."</option>";
				
				}
			}
			
			?>
               </td><?php
						   
                global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ingrediente' data-native-menu='false' id='ingrediente'>";
						 
	    $consulta = $db->prepare("SELECT ingrediente,nombre_ingrediente FROM ingredientes");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ingre = $row['ingrediente'];
				$nomb = $row['nombre_ingrediente'];
            
                echo "<option value='".$ingre."'>".$nomb."</option>";
				
				}
			}
			echo "</select></td>";	
                ?><td colspan="2"><input type="button" value="Agregar" onclick="insertaRecetaEstrella();"></td>
            
            </tr>
    </table>
        <?php
    }
?>