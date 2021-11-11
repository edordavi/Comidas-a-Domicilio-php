<?php
    $titulo="Clientes - Comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_pedidos.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos del pedido</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaPedido();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaPedido(){
        var fecha = document.getElementById("fecha").value;
        var pedido = document.getElementById("pedido").value;
        var clase = document.getElementById("clase").value;
		var total = document.getElementById("total").value;
        var cliente = document.getElementById("cliente").value;
        var dni = document.getElementById("dni").value;
		var valor = document.getElementById("valor").value;
		var incremento = document.getElementById("incremento").value;
        
        //VALIDACIONES
               
        
            var cadena = "cls_pedidos.php?accion=" + encodeURIComponent("insertar") +
                    "&fecha=" + encodeURIComponent(fecha) +
                    "&pedido="+pedido+
                    "&clase="+clase+"&total="+total+
                    "&cliente="+cliente + "&dni="+dni+"&valor="+valor 
					+ "&incremento="+incremento;
            consulta(cadena);
        
        
    }
    
    function actualizaCliente(){
        var fecha = document.getElementById("fecha").value;
        var pedido = document.getElementById("pedido").value;
        var clase = document.getElementById("clase").value;
		var total = document.getElementById("total").value;
        var cliente = document.getElementById("cliente").value;
        var dni = document.getElementById("dni").value;
		var valor = document.getElementById("valor").value;
		var incremento = document.getElementById("incremento").value;
        
        //SIN VALIDACIONES no hay tiempo
                
        
            var cadena = "cls_pedidos.php?accion=" + encodeURIComponent("actualizar") +
                   "&fecha=" + encodeURIComponent(fecha) +
                    "&pedido="+pedido+
                    "&clase="+clase+"&total="+total+
                    "&cliente="+cliente + "&dni="+dni+"&valor="+valor 
					+ "&incremento="+incremento;
            consulta(cadena);
			       
        
    }
</script>

<?php
    require_once "../pie.php";
?>

