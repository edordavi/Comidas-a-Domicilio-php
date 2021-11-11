<?php
    $titulo="Tipos de pedidos - Comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_tipospedidos.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Tipos de Pedidos</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaPedido();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertarPedidos(){
        var clase = document.getElementById("clase").value;
        var incremento = document.getElementById("incremento").value;
        var minimo = document.getElementById("minimo").value;
		                
        //VALIDACIONES
               
        
            var cadena = "cls_tipospedidos.php?accion=" + encodeURIComponent("insertar") +
                    "&clase=" + encodeURIComponent(clase) +
                    "&incremento="+incremento+
                    "&minimo="+minimo;
            consulta(cadena);
        
        
    }
    
    function actualizaPedido(){
        var clase = document.getElementById("clase").value;
        var incremento = document.getElementById("incremento").value;
        var minimo = document.getElementById("minimo").value;
        
        //SIN VALIDACIONES no hay tiempo
                
        
            var cadena = "cls_personas.php?accion=" + encodeURIComponent("actualizar") +
                   "&clase=" + encodeURIComponent(clase) +
                    "&incremento="+incremento+
                    "&minimo="+minimo;
            consulta(cadena);
			       
        
    }
</script>

<?php
    require_once "../pie.php";
?>

