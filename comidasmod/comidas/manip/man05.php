<?php
    $titulo="Manip 05 - Comidas a Domicilio";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_man05.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de Manip05</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaFamilias("");
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaFamilia(){
        var sco = document.getElementById("sco").value;
        var anio = document.getElementById("anio").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(sco.length <2){
            resultado += "- Rellene correctamente el Nombre de Scooter\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
            var cadena = "cls_scooters.php?accion=" + encodeURIComponent("insertar") +
                    "&sco=" + encodeURIComponent(sco) + 
                    "&anio=" + encodeURIComponent(anio);
            consulta(cadena);
    }
    
    function actualizaFamilia(){
        var famo = document.getElementById("famo").value;
        var fam = document.getElementById("fam").value;

        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(fam.length <2){
            resultado += "- Rellene correctamente el Nombre de Familia\n";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
            var cadena = "cls_familias.php?accion=" + encodeURIComponent("actualizar") +
                    "&fam1=" + encodeURIComponent(famo) +
                    "&fam2=" + encodeURIComponent(fam);
            consulta(cadena);
    }
</script>

<?php
    require_once "../pie.php";
?>