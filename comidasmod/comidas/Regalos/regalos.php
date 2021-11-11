<?php
    $titulo="Regalos - Comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_regalos.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos del Regalo</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaRegalo();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertarRegalo(){
        var regalo = document.getElementById("regalo").value;
        var motivo = document.getElementById("motivo").value;
        var limite = document.getElementById("limite").value;
		                
        //VALIDACIONES
               
        
            var cadena = "cls_regalos.php?accion=" + encodeURIComponent("insertar") +
                    "&regalo=" + encodeURIComponent(regalo) +
                    "&motivo="+motivo +
                    "&limite=" +limite;
            consulta(cadena);
        
        
    }
    
    function actualizaRegalo(){
        var regalo = document.getElementById("regalo").value;
        var motivo = document.getElementById("motivo").value;
        var limite = document.getElementById("limite").value;
        
        //SIN VALIDACIONES no hay tiempo
                
        
            var cadena = "cls_personas.php?accion=" + encodeURIComponent("actualizar") +
                   "&regalo=" + encodeURIComponent(regalo) +
                    "&motivo="+motivo +
                    "&limite=" +limite;
            consulta(cadena);
			       
        
    }
</script>

<?php
    require_once "../pie.php";
?>

