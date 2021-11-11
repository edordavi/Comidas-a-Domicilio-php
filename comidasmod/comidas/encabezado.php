<?php
if (!isset($titulo)){
    $titulo = 'Comidas';
}
if(!isset($maindir))
{
    $maindir="";
}
?>
<html lang="es" dir="ltr">
    <head>
        <title><?php echo $titulo; ?></title>
        <meta charset="ISO-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo $maindir;?>styles/layout.css" 
               type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo $maindir;?>styles/mediaqueries.css" 
              type="text/css" media="all">
        <script src="<?php echo $maindir;?>scripts/jquery.1.9.0.min.js"></script>
        <script src="<?php echo $maindir;?>scripts/jquery-mobilemenu.min.js"></script>
        <script type="text/javascript" src="<?php echo $maindir;?>scripts/ajax.js"></script>
        <!--[if lt IE 9]>
        <link rel="stylesheet" href="styles/ie.css" type="text/css" media="all">
        <script src="scripts/ie/css3-mediaqueries.min.js"></script>
        <script src="scripts/ie/ie9.js"></script>
        <script src="scripts/ie/html5shiv.min.js"></script>
        <![endif]-->
        
    </head>
    <body>
        <div class="wrapper row1">
          <header id="header" class="clear">
            <hgroup>
              <h1>Comidas a Domicilio</h1>
            </hgroup>
          </header>
        </div>
            <div class="wrapper row2">
                  <nav id="topnav">
                    <ul class="clear">
                      <li class="active first"><a href="index.php">Inicio</a></li>
                      <li><a class="drop" href="#">Manipulaci&oacute;n</a>
                          <ul>
                              <li><a href="<?php echo $maindir;?>manip/man01.php">Consulta # 1</a></li>
                              <li><a href="<?php echo $maindir;?>manip/man02.php">Consulta # 2</a></li>
                              <li><a href="<?php echo $maindir;?>manip/man03.php">Consulta # 3</a></li>
                              <li><a href="<?php echo $maindir;?>manip/man04.php">Consulta # 4</a></li>
                              <li><a href="<?php echo $maindir;?>manip/man05.php">Consulta # 5</a></li>
                              <li><a href="<?php echo $maindir;?>manip/man06.php">Consulta # 6</a></li>
                          </ul>
                      </li>
                      <li><a href="#" class="drop">Mantenimiento1</a>
                          <ul>
                              <li><a href="<?php echo $maindir;?>scooters/scooters.php">Scooters</a></li>
                              <li><a href="<?php echo $maindir;?>abastecer/abastecer.php">Abastecer</a></li>
                              <li><a href="<?php echo $maindir;?>articulos/articulos.php">Articulos</a></li>
                              <li><a href="<?php echo $maindir;?>pizzas/pizzas.php">Pizzas</a></li>
                              <li><a href="<?php echo $maindir;?>ventasproductos/ventasproductos.php">Ventas Productos</a></li>
                              <li><a href="<?php echo $maindir;?>ingredientes/ingredientes.php">Ingredientes</a></li>
                              <li><a href="<?php echo $maindir;?>recetasestrella/recetaestrella.php">Recetas Estrella</a></li>
                              <li><a href="<?php echo $maindir;?>clasearticulos/clasearticulos.php">Clases de articulos</a></li>
                          </ul>
                      </li>
                      <li><a href="#" class="drop">Mantenimiento2</a>
                          <ul>
                              <li><a href="<?php echo $maindir;?>productoestrella/productoestrella.php">Productos Estrella</a></li>
                              <li><a href="<?php echo $maindir;?>recetaspizza/recetaspizza.php">Recetas de las pizzas</a></li>
                              <li><a href="<?php echo $maindir;?>pizzasbase/pizzasbase.php">Ingredientes base de las pizzas</a></li>
                              <li><a href="<?php echo $maindir;?>Clientes/cliente.php">Clientes</a></li>
                              <li><a href="<?php echo $maindir;?>ObsequiosClientes/obsequioscliente.php">Obsequios Clientes</a></li>
                              <li><a href="<?php echo $maindir;?>Pedidos/pedidos.php">Pedidos</a></li>
                              <li><a href="<?php echo $maindir;?>Regalos/regalos.php">Regalos</a></li>
                              <li><a href="<?php echo $maindir;?>TiposPedidos/tipospedidos.php">Tipos Pedidos</a></li>
                              <li><a href="<?php echo $maindir;?>recetasventas/recetasventas.php">Recetas Venta</a></li>
                          </ul>
                      </li>
                    </ul>
                      
                  </nav>
            </div>
        <div class="wrapper row3">
        <div id="container">