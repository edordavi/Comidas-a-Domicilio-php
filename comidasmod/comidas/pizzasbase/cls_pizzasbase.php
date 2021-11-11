
<?php
require_once '../conexionComidas.php';

    if (isset($_GET["accion"])){
        $accion = $_GET["accion"];
        switch ($accion) {
            case "insertar":
                insertaPizzasBase();
                break;
            case "eliminar":
                eliminaPizzasBase();
                break;
            case "actualizar":
                actualizaPizzasBase();
                break;
            default:
                inicio();
                break;
        }
    }
    function insertaPizzasbase(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
        $articulo = $_GET["articulo"];
        $ingrediente=$_GET["ingrediente"];

        $consulta=$db->prepare("CALL sp_nuevo_pizzasbase(:articulo,:ingrediente);");
        $consulta->bindParam(":articulo",$articulo, PDO::PARAM_STR,10);
        $consulta->bindParam(":ingrediente", $ingrediente, PDO::PARAM_STR,4);
        $consulta->execute();
        echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error: ".$consulta->errorCode()."</p>";
        }
        $db = null;
        consultaPizzasBase();
    }
    
    function actualizaPizzasBase(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        
        if (isset($_GET["articulo2"])){
            $articulo1 = $_GET["articulo1"];
            $articulo2 = $_GET["articulo2"];
            $ingrediente1=$_GET["ingrediente1"];
			$ingrediente2=$_GET["ingrediente2"];
			
            $consulta=$db->prepare("CALL sp_actualiza_pizzasbase(:articulo1,:articulo2,:ingrediente1,:ingrediente2);");
            $consulta->bindParam(":articulo1",$articulo1, PDO::PARAM_STR);
            $consulta->bindParam(":articulo2",$articulo2, PDO::PARAM_STR);
            $consulta->bindParam(":ingrediente1", $ingrediente1, PDO::PARAM_STR);
			$consulta->bindParam(":ingrediente2", $ingrediente2, PDO::PARAM_STR);
            $consulta->execute();
            echo "<p>Filas Afectadas: ".$consulta->rowCount()."<br>";
            if($consulta->errorCode()!=="00000"){
                echo "Codigo de Error: ".$consulta->errorCode().
                        "<br>Mensaje de Error: ". print_r($consulta->errorInfo())."</p>";
            }
            $db = null;
            consultaRecetasPizza();   
            
        }else{
            consultaPizzasBaseActualizar($_GET['articulo'],$_GET['ingrediente']);
        }
    }
    
    function eliminaPizzasBase(){
        global $server,$bd,$user,$password;
        
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);
        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $articulo = $_GET["articulo"];
		$ingrediente = $_GET["ingrediente"];
        $consulta=$db->prepare("CALL sp_elimina_pizzasbase(:articulo,:ingrediente);");
        $consulta->bindParam(":articulo",$articulo, PDO::PARAM_STR);
		$consulta->bindParam(":ingrediente",$ingrediente, PDO::PARAM_STR);
        $consulta->execute();
        
        if($consulta->errorCode()!=="00000"){
            echo "Codigo de Error al Eliminar la Fila: ".$consulta->errorCode()."</p>";
        }else{
            echo "Fila eliminada Correctamente";
        }
        $db = null;
        consultaPizzasBase();
    }
    
    function consultaPizzasBaseActualizar($articulo1,$ingrediente1){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }

        $consulta=$db->prepare("CALL sp_get_pizzasbase_esp(:articulo,:ingrediente);");
		$consulta->bindParam(":articulo",$articulo1, PDO::PARAM_STR, 10);
		$consulta->bindParam(":ingrediente",$ingrediente1, PDO::PARAM_STR, 4);
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
						   <input type="text" name="ingredienteo" id="ingredienteo" class="oculto" 
                           placeholder="zzz" maxlength="4"
                           value="<?php echo $filas[0]["INGREDIENTE"];?>"></td>
				<?PHP
						   
						   global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='articuloN' data-native-menu='false' id='articuloN'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT articulo FROM pizzas");
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
						   
				global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ingredienteN' data-native-menu='false' id='ingredienteN'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT ingrediente, nombre_ingrediente FROM ingredientes");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ingre = $row['ingrediente'];
				$nombre = $row['nombre_ingrediente'];
            
			    if($filas[0]["INGREDIENTE"] == $ingre){
				    echo "<option selected='selected' value='".$ingre."'>".$nombre."</option>";
				}else{
				    echo "<option value='".$ingre."'>".$nombre."</option>";
				}
				
				}
			}
			echo "</select></td>";	
						   
				?>
                <td colspan="1"><input type="button" value="Actualizar" onclick="actualizaRecetasPizza();"></td>
            
            </tr>
    </table>
        <?php
    }
    
    function consultaPizzasBase(){
        global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
        $consulta=$db->prepare("CALL sp_get_pizzasbase();");
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
                    "cls_pizzasbase.php?accion=eliminar&articulo={$fila["ARTICULO"]}&ingrediente={$fila["INGREDIENTE"]}");' value='ELIMINAR'>
                </td> 
                <td><input type='button' 
                    onclick='consulta("cls_pizzasbase.php?accion=actualizar&articulo={$fila["ARTICULO"]}&ingrediente={$fila["INGREDIENTE"]}");'
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
						 
	    $consulta = $db->prepare("SELECT DISTINCT articulo FROM pizzas ");
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
						   
			global $server,$bd,$user,$password;
        $db = new PDO("mysql:host=".$server.";dbname=".$bd.";charset=utf8",$user, $password);

        if ($db->errorCode() != 0){
            die("No se ha podido conectar a la base de datos: " .  $db->errorInfo());
        }
		
		echo "<td><select name='ingrediente' data-native-menu='false' id='ingrediente'>";
						 
	    $consulta = $db->prepare("SELECT DISTINCT ingrediente,nombre_ingrediente FROM ingredientes");
	    $consulta->execute();
        $rows = $consulta->fetchAll();
		$db = null;
            if($rows){
                foreach( $rows as $row ){ 
	 
	            $ingre = $row['ingrediente'];
				$nombre = $row['nombre_ingrediente'];
            
				    echo "<option value='".$ingre."'>".$nombre."</option>";
				
				}
			}
			echo "</select></td>";	
						   
                ?>
                <td colspan="2"><input type="button" value="Agregar" onclick="insertaPizzasBase();"></td>
            
            </tr>
    </table>
        <?php
    }
?>