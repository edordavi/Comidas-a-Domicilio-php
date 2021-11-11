<?php
    $titulo="Recetas de las pizzas comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_pizzasbase.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de los ingredientes base de las pizzas</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaPizzasBase();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaPizzasBase(){
        var articulo = document.getElementById("articulo").value;
        var ingrediente = document.getElementById("ingrediente").value;

        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(articulo === ""){
            resultado += "- Rellene correctamente el articulo\n";
            esValido=false;
        }
        if(ingrediente ===""){
            resultado += "- Rellene correctamente el ingrediente\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        if(articulo !=""  && ingrediente != ""){

            var cadena = "cls_pizzasbase.php?accion=" + encodeURIComponent("insertar") +
                    "&articulo=" + encodeURIComponent(articulo) +
                    "&ingrediente="+encodeURIComponent(ingrediente);
					
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
    
    function actualizaPizzasBase(){

        var articuloo = document.getElementById("articuloo").value;
        var articulo = document.getElementById("articuloN").value;
		var ingredienteo = document.getElementById("ingredienteo").value;
        var ingrediente = document.getElementById("ingredienteN").value;
		
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(articulo ===""){
            resultado += "- Rellene correctamente el articulo\n";
            esValido=false;
        }
        if(ingrediente ===""){
            resultado += "- Rellene correctamente el ingrediente\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        
		alert('im here');
        if(articulo != "" && ingrediente != ""){
            var cadena = "cls_recetaspizza.php?accion=" + encodeURIComponent("actualizar") +
                    "&articulo1=" + encodeURIComponent(articuloo) +
                    "&articulo2=" + encodeURIComponent(articulo) +
                    "&ingrediente1="+ encodeURIComponent(ingredienteo) +
					"&ingrediente2="+ encodeURIComponent(ingrediente);
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
	
	
</script>

<?php
    require_once "../pie.php";
?>

