<?php
    $titulo="receta estrella comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_productoestrella.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de los productos estrella</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaProductoEstrella();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaProductoEstrella(){
	    var nombre_comercial = document.getElementById("nombre_comercial").value;
        var articulo = document.getElementById("articulo").value;    
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(articulo === ""){
            resultado += "- Rellene correctamente el articulo\n";
            esValido=false;
        }
        if(nombre_comercial ===""){
            resultado += "- Rellene correctamente el Nombre Comercial del producto\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        
        if(articulo !=""  && nombre_comercial != ""){

            var cadena = "cls_productoestrella.php?accion=" + encodeURIComponent("insertar") +
                    "&articulo=" + encodeURIComponent(articulo) +
                    "&nombre_comercial="+encodeURIComponent(nombre_comercial);
					
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
    
    function actualizaProductoEstrella(){
        
		var nombre_comercialo = document.getElementById("nombre_comercialo").value;
		var nombre_comercial = document.getElementById("nombre_comercialN").value;
        var articulo = document.getElementById("articuloN").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(articulo ===""){
            resultado += "- Rellene correctamente el articulo\n";
            esValido=false;
        }
        if(nombre_comercial ===""){
            resultado += "- Rellene correctamente el Nombre Comercial del producto estrella \n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }

        if(articulo != "" && nombre_comercial != ""){
            var cadena = "cls_productoestrella.php?accion=" + encodeURIComponent("actualizar") +
                    "&nombre_comercial1=" + encodeURIComponent(nombre_comercialo) +
                    "&nombre_comercial2=" + encodeURIComponent(nombre_comercial) +
                    "&articulo="+articulo;
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
	
	
</script>

<?php
    require_once "../pie.php";
?>

