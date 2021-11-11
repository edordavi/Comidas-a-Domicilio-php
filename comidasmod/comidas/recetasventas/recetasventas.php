<?php
    $titulo="Recetas de las pizzas comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_recetasventas.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de las Recetas pedidas en las ventas</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaRecetasVentas();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaRecetasVentas(){
        var ventas = document.getElementById("ventas").value;
        var ingrediente = document.getElementById("ingrediente").value;
		var split = ventas.split("~");

        //VALIDACIONES

        if(ventas !=""  && ingrediente != ""){

		var fecha = split[0];
		var pedido = split[1];
		var venta = split[2];
		
            var cadena = "cls_recetasventas.php?accion=" + encodeURIComponent("insertar") +
                    "&fecha=" + encodeURIComponent(fecha) +
					"&pedido=" + encodeURIComponent(pedido) +
					"&venta=" + encodeURIComponent(venta) +
                    "&ingrediente="+encodeURIComponent(ingrediente);
					
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
    
    function actualizaRecetasVentas(){

        var ventaso = document.getElementById("ventaso").value;
        var ventas = document.getElementById("ventasN").value;
        var ingrediente = document.getElementById("ingredienteN").value;
		
        //VALIDACIONES

        if(ventas != "" && ingrediente != ""){
		
		var fecha1 = split[0];
		var pedido1 = split[1];
		var venta1 = split[2];
		
		var fecha2 = split[0];
		var pedido2 = split[1];
		var venta2 = split[2];
		
            var cadena = "cls_recetasventas.php?accion=" + encodeURIComponent("actualizar") +
                    "&fecha1=" + encodeURIComponent(fecha1) +
					"&pedido1=" + encodeURIComponent(pedido1) +
					"&venta1=" + encodeURIComponent(venta1) +
                    "&fecha2=" + encodeURIComponent(fecha2) +
					"&pedido2=" + encodeURIComponent(pedido2) +
					"&venta2=" + encodeURIComponent(venta2) +
					"&ingrediente="+ encodeURIComponent(ingrediente);
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
	
	
</script>

<?php
    require_once "../pie.php";
?>

