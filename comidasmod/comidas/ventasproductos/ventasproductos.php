<?php
    $titulo="Ventas-Productos - Comidas a Domicilio";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_ventasproductos.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de Ventas-Productos</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaFamilias("","","");
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaFamilia(){
        var fch = document.getElementById("fch").value;
        var ped = document.getElementById("ped").value;
        var vnt = document.getElementById("vnt").value;
        var art = document.getElementById("art").value;
        var tam = document.getElementById("tam").value;
        var und = document.getElementById("und").value;
        var vlr = document.getElementById("vlr").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if (!esValido){
            alert(resultado);
            return;
        }
            var cadena = "cls_ventasproductos.php?accion=" + encodeURIComponent("insertar") +
                    "&fch=" + encodeURIComponent(fch) + 
                    "&ped=" + encodeURIComponent(ped) +
                    "&vnt=" + encodeURIComponent(vnt) +
                    "&art=" + encodeURIComponent(art) + 
                    "&tam=" + encodeURIComponent(tam) +
                    "&und=" + encodeURIComponent(und) +
                    "&vlr=" + encodeURIComponent(vlr);
            consulta(cadena);
    }
</script>

<?php
    require_once "../pie.php";
?>