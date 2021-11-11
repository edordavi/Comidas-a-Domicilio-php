<?php
    $titulo="Clientes - Comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_obsequiosclientes.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos del obsequio del cliente</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaClienteOb();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaClienteOB(){
        var regalo = document.getElementById("regalo").value;
        var motivo = document.getElementById("motivo").value;
        var cliente = document.getElementById("cliente").value;
		var fecha = document.getElementById("fecha").value;
                
        //VALIDACIONES
               
        
            var cadena = "cls_obsequiosclientes.php?accion=" + encodeURIComponent("insertar") +
                    "&regalo=" + encodeURIComponent(regalo) +
                    "&motivo="+motivo +
                    "&cliente=" +cliente + "&fecha=" + fecha;
            consulta(cadena);
        
        
    }
    
    function actualizaClienteOb(){
       var regalo = document.getElementById("regalo").value;
        var motivo = document.getElementById("motivo").value;
        var cliente = document.getElementById("cliente").value;
		var fecha = document.getElementById("fecha").value;
        
        //SIN VALIDACIONES no hay tiempo
                
        
            var cadena = "cls_personas.php?accion=" + encodeURIComponent("actualizar") +
                     "&regalo=" + encodeURIComponent(regalo) +
                    "&motivo="+motivo +
                    "&cliente=" +cliente + "&fecha=" + fecha;
            consulta(cadena);
			       
        
    }
</script>

<?php
    require_once "../pie.php";
?>

