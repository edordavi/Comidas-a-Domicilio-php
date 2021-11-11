<?php
    $titulo="receta estrella comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_recetaestrella.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de las recetas estrella</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaRecetaEstrella("");
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaRecetaEstrella(){
	    var nombre_comercial = document.getElementById("nombre_comercial").value;
        var ingrediente = document.getElementById("ingrediente").value;    
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(ingrediente === ""){
            resultado += "- Rellene correctamente el ingrediente\n";
            esValido=false;
        }
        if(nombre_comercial ===""){
            resultado += "- Rellene correctamente el Nombre Comercial de la receta estrella\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        
        if(ingrediente !=""  && nombre_comercial != ""){

            var cadena = "cls_recetaestrella.php?accion=" + encodeURIComponent("insertar") +
                    "&ingrediente=" + encodeURIComponent(ingrediente) +
                    "&nombre_comercial="+encodeURIComponent(nombre_comercial);
					
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
    
    function actualizaRecetaEstrella(){
        
		var nombre_comercialo = document.getElementById("nombre_comercialo").value;
		var nombre_comercial = document.getElementById("nombre_comercialN").value;
        var ingrediente = document.getElementById("ingredienteN").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(ingrediente ===""){
            resultado += "- Rellene correctamente el ingrediente\n";
            esValido=false;
        }
        if(nombre_comercial ===""){
            resultado += "- Rellene correctamente el Nombre Comercial de la receta estrella\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }

        if(ingrediente != "" && nombre_comercial != ""){
            var cadena = "cls_recetaestrella.php?accion=" + encodeURIComponent("actualizar") +
                    "&nombre_comercial1=" + encodeURIComponent(nombre_comercialo) +
                    "&nombre_comercial2=" + encodeURIComponent(nombre_comercial) +
                    "&ingrediente="+ingrediente;
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
	
	
</script>

<?php
    require_once "../pie.php";
?>

