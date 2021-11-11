<?php
    $titulo="Articulos - Comidas a Domicilio";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_articulos.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de Articulos</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaFamilias("","");
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaFamilia(){
        var art = document.getElementById("art").value;
        var tam = document.getElementById("tam").value;
        var prc = document.getElementById("prc").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if (!esValido){
            alert(resultado);
            return;
        }
            var cadena = "cls_articulos.php?accion=" + encodeURIComponent("insertar") +
                    "&art=" + encodeURIComponent(art) + 
                    "&tam=" + encodeURIComponent(tam) +
                    "&prc=" + encodeURIComponent(prc);
            consulta(cadena);
    }
</script>

<?php
    require_once "../pie.php";
?>