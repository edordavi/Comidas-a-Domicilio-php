<?php
    $titulo="ingredientes comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_ingredientes.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de los ingredientes</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaIngredientes("");
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaIngrediente(){
        var ingrediente = document.getElementById("ingrediente").value;
        var nombre = document.getElementById("nombre").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(ingrediente === ""){
            resultado += "- Rellene correctamente el ingrediente\n";
            esValido=false;
        }
        if(nombre ===""){
            resultado += "- Rellene correctamente el Nombre del ingrediente\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        
        if(ingrediente !=""  && nombre != ""){

            var cadena = "cls_ingredientes.php?accion=" + encodeURIComponent("insertar") +
                    "&ingrediente=" + encodeURIComponent(ingrediente) +
                    "&nombre="+encodeURIComponent(nombre);
					
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
    
    function actualizaIngrediente(){

        var ingredienteo = document.getElementById("ingredienteo").value;
        var ingrediente = document.getElementById("ingredienteN").value;
        var nombre = document.getElementById("nombreN").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(ingrediente ===""){
            resultado += "- Rellene correctamente el ingrediente\n";
            esValido=false;
        }
        if(nombre ===""){
            resultado += "- Rellene correctamente el Nombre del ingrediente\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }

        if(ingrediente != "" && nombre != ""){
            var cadena = "cls_ingredientes.php?accion=" + encodeURIComponent("actualizar") +
                    "&ingrediente1=" + encodeURIComponent(ingredienteo) +
                    "&ingrediente2=" + encodeURIComponent(ingrediente) +
                    "&nombre="+nombre;
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
	
	
</script>

<?php
    require_once "../pie.php";
?>

