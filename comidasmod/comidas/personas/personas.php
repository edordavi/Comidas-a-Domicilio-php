<?php
    $titulo="Personas - Mariposas";
    $maindir="../";
    require_once $maindir . "conexionComidas.php";
    require_once $maindir . "encabezado.php";
    require_once "cls_personas.php";

?>

<div class="full_width clear" id="datos2">
<fieldset><legend>Datos de Personas</legend>
    <div class="full_width clear" id="datos">
<?php
    consultaPersonas("","");
?>
    </div>
</fieldset>
</div>

<script type="text/javascript">
    function insertaPersona(){
        var dni = document.getElementById("dni").value;
        var pnombre = document.getElementById("pnombre").value;
        var snombre = document.getElementById("snombre").value;
        var papellido = document.getElementById("papellido").value;
        var sapellido = document.getElementById("sapellido").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(dni.length !==15){
            resultado += "- Rellene correctamente el DNI\n";
            esValido=false;
        }
        if(pnombre ===""){
            resultado += "- Rellene correctamente el Primer Nombre\n";
            esValido=false;
        }
        if(papellido ===""){
            resultado += "- Rellene correctamente el Primer Apellido";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        
        if(dni.length == 15 && pnombre != "" && papellido!=""){
            var cadena = "cls_personas.php?accion=" + encodeURIComponent("insertar") +
                    "&dni=" + encodeURIComponent(dni) +
                    "&pnombre="+pnombre +
                    "&snombre=" +snombre + "&papellido=" + papellido +
                    "&sapellido="+sapellido;
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
    
    function actualizaPersona(){
        var dnio = document.getElementById("dnio").value;
        var dni = document.getElementById("dni").value;
        var pnombre = document.getElementById("pnombre").value;
        var snombre = document.getElementById("snombre").value;
        var papellido = document.getElementById("papellido").value;
        var sapellido = document.getElementById("sapellido").value;
        
        //VALIDACIONES
        var resultado = ""; 
        var esValido = true;
        
        if(dni.length !==15){
            resultado += "- Rellene correctamente el DNI\n";
            esValido=false;
        }
        if(pnombre ===""){
            resultado += "- Rellene correctamente el Primer Nombre\n";
            esValido=false;
        }
        if(papellido ===""){
            resultado += "- Rellene correctamente el Primer Apellido";
            esValido=false;
        }
        
        if (!esValido){
            alert(resultado);
            return;
        }
        
        if(dni.length == 15 && pnombre != "" && papellido!=""){
            var cadena = "cls_personas.php?accion=" + encodeURIComponent("actualizar") +
                    "&dni1=" + encodeURIComponent(dnio) +
                    "&dni2=" + encodeURIComponent(dni) +
                    "&pnombre="+pnombre +
                    "&snombre=" +snombre + "&papellido=" + papellido +
                    "&sapellido="+sapellido;
            consulta(cadena);
        }else{
            
            alert("Verifique los campos rellenados");
            
        }
        
    }
</script>

<?php
    require_once "../pie.php";
?>

