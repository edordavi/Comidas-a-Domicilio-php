<?php
    $titulo="clases de articulos comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_clasearticulos.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de las clases de articulos</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaClaseArticulos();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaClaseArticulo(){
        var articulo = document.getElementById("articulo").value;
        var tipoarticulo = document.getElementById("tipoarticulo").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(articulo === ""){
            resultado += "- Rellene correctamente el articulo\n";
            esValido=false;
        }
        if(tipoarticulo ===""){
            resultado += "- Rellene correctamente el tipo de articulo\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        if(articulo !=""  && tipoarticulo != ""){

            var cadena = "cls_clasearticulos.php?accion=" + encodeURIComponent("insertar") +
                    "&articulo=" + encodeURIComponent(articulo) +
                    "&tipoarticulo="+encodeURIComponent(tipoarticulo);
					
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
    
    function actualizaClaseArticulo(){

        var articuloo = document.getElementById("articuloo").value;
        var articulo = document.getElementById("articuloN").value;
        var tipoarticulo = document.getElementById("tipoarticuloN").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(articulo ===""){
            resultado += "- Rellene correctamente el articulo\n";
            esValido=false;
        }
        if(tipoarticulo ===""){
            resultado += "- Rellene correctamente el tipo de articulo\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }

        if(articulo != "" && tipoarticulo != ""){
            var cadena = "cls_clasearticulos.php?accion=" + encodeURIComponent("actualizar") +
                    "&articulo1=" + encodeURIComponent(articuloo) +
                    "&articulo2=" + encodeURIComponent(articulo) +
                    "&tipoarticulo="+ encodeURIComponent(tipoarticulo);
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
	
	
</script>

<?php
    require_once "../pie.php";
?>

