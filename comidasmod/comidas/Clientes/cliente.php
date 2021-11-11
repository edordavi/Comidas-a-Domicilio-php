<?php
    $titulo="Clientes - Comidas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_clientes.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos del cliente</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaCliente();
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaCliente(){
        var clienteid = document.getElementById("clienteid").value;
        var nbcliente = document.getElementById("nbcliente").value;
        var apcliente = document.getElementById("apcliente").value;
		var drcliente = document.getElementById("drcliente").value;
        var telcliente = document.getElementById("telcliente").value;
        var cspizza = document.getElementById("cspizza").value;
		var csbocadillos = document.getElementById("csbocadillos").value;
		var cscomplemento = document.getElementById("cscomplemento").value;
        
        //VALIDACIONES
               
        
            var cadena = "cls_clientes.php?accion=" + encodeURIComponent("insertar") +
                    "&clienteid=" + encodeURIComponent(clienteid) +
                    "&nbcliente="+nbcliente +
                    "&apcliente=" +apcliente + "&drcliente=" + drcliente +
                    "&telcliente="+telcliente + "&cspizza="+cspizza + "&csbocadillos="+csbocadillos 
					+ "&cscomplemento="+cscomplemento;
            consulta(cadena);
        
        
    }
    
    function actualizaCliente(){
        var clienteid = document.getElementById("clienteid").value;
        var nbcliente = document.getElementById("nbcliente").value;
        var apcliente = document.getElementById("apcliente").value;
		var drcliente = document.getElementById("drcliente").value;
        var telcliente = document.getElementById("telcliente").value;
        var cspizza = document.getElementById("cspizza").value;
		var csbocadillos = document.getElementById("csbocadillos").value;
		var cscomplemento = document.getElementById("cscomplemento").value;
        
        //SIN VALIDACIONES no hay tiempo
                
        
            var cadena = "cls_personas.php?accion=" + encodeURIComponent("actualizar") +
                    "&clienteid=" + encodeURIComponent(clienteid) +
                    "&nbcliente="+nbcliente +
                    "&apcliente=" +apcliente + "&drcliente=" + drcliente +
                    "&telcliente="+telcliente + "&cspizza="+cspizza + "&csbocadillos="+csbocadillos 
					+ "&cscomplemento="+cscomplemento;
            consulta(cadena);
			       
        
    }
</script>

<?php
    require_once "../pie.php";
?>

