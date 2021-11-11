CREATE DATABASE  IF NOT EXISTS `comidasadomicilio` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `comidasadomicilio`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS abastecer;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE abastecer (
  scooter varchar(6) NOT NULL,
  fecha_abastecer date NOT NULL,
  costo_abastecer decimal(3,0) NOT NULL,
  PRIMARY KEY (scooter,fecha_abastecer),
  CONSTRAINT fk_Abastecer_Scooters FOREIGN KEY (scooter) REFERENCES scooter (scooter)
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS articulos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE articulos (
  articulo varchar(10) NOT NULL,
  tamano char(1) NOT NULL,
  precio_articulo decimal(4,0) NOT NULL,
  PRIMARY KEY (articulo,tamano)
);
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO articulos (articulo, tamano, precio_articulo) VALUES ('Chismol','P',15),('Frijolitos','G',45);
DROP TABLE IF EXISTS clasearticulos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE clasearticulos (
  articulo varchar(10) NOT NULL,
  tipoArticulo char(1) NOT NULL,
  PRIMARY KEY (articulo)
);
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO clasearticulos (articulo, tipoArticulo) VALUES ('Frijolitos','B');
DROP TABLE IF EXISTS cliente;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE cliente (
  cliente decimal(5,0) NOT NULL,
  nombre_cliente varchar(20) NOT NULL,
  apellidos_clientes varchar(40) NOT NULL,
  direccion_cliente varchar(30) DEFAULT NULL,
  telfono_cliente decimal(9,0) DEFAULT NULL,
  consumo_pizza decimal(3,0) DEFAULT NULL,
  consumo_bocadillos decimal(3,0) DEFAULT NULL,
  consumo_complementos decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (cliente)
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS ingredientes;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE ingredientes (
  ingrediente varchar(4) NOT NULL,
  nombre_ingrediente varchar(10) NOT NULL,
  PRIMARY KEY (ingrediente),
  UNIQUE KEY unique__ingrediente (nombre_ingrediente)
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS obsequiosc;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE obsequiosc (
  regalo decimal(4,0) NOT NULL,
  motivo char(1) NOT NULL,
  cliente decimal(5,0) NOT NULL,
  fecha_obsequio date NOT NULL,
  PRIMARY KEY (regalo,motivo,cliente,fecha_obsequio),
  KEY fk_Obsequi_Cliente (cliente),
  CONSTRAINT fk_Obsequios_Regalos FOREIGN KEY (regalo, motivo) REFERENCES regalos (regalo, motivo) ON DELETE CASCADE,
  CONSTRAINT fk_Obsequi_Cliente FOREIGN KEY (cliente) REFERENCES `cliente` (cliente) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS obsequiosp;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE obsequiosp (
  fecha_Pedido date NOT NULL,
  pedido decimal(3,0) NOT NULL,
  regalo decimal(4,0) NOT NULL,
  motivo char(1) NOT NULL,
  PRIMARY KEY (fecha_Pedido,pedido),
  KEY fk_ObsequiosP_Regalos (regalo,motivo),
  CONSTRAINT fk_ObsequiosP_Regalos FOREIGN KEY (regalo, motivo) REFERENCES regalos (regalo, motivo) ON DELETE CASCADE,
  CONSTRAINT fk_OpsequiP_Pedidos FOREIGN KEY (fecha_Pedido, pedido) REFERENCES pedidos (fecha_pedidos, pedido) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS pedidos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE pedidos (
  fecha_pedidos date NOT NULL,
  pedido decimal(3,0) NOT NULL,
  clase_pedido varchar(10) NOT NULL,
  total_pedido decimal(4,0) NOT NULL,
  cliente decimal(5,0) DEFAULT NULL,
  dni_repartidor varchar(9) DEFAULT NULL,
  valor_receta decimal(4,0) NOT NULL,
  incremento decimal(3,0) NOT NULL,
  PRIMARY KEY (fecha_pedidos,pedido),
  KEY fk_Pedido_Cliente (cliente),
  KEY fk_Pedidos_Repartidor (dni_repartidor),
  KEY fk_Pedido_TipoPedido (clase_pedido),
  CONSTRAINT fk_Pedidos_Repartidor FOREIGN KEY (dni_repartidor) REFERENCES repartidores (dni_repartidor),
  CONSTRAINT fk_Pedido_Cliente FOREIGN KEY (cliente) REFERENCES `cliente` (cliente) ON DELETE CASCADE,
  CONSTRAINT fk_Pedido_TipoPedido FOREIGN KEY (clase_pedido) REFERENCES tipospedidos (clase_pedidos) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS pizzas;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE pizzas (
  articulo varchar(10) NOT NULL,
  tamano char(1) NOT NULL,
  precio_ingrediente decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (articulo,tamano),
  CONSTRAINT fk_pizza_articulo FOREIGN KEY (articulo, tamano) REFERENCES articulos (articulo, tamano) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO pizzas (articulo, tamano, precio_ingrediente) VALUES ('Chismol','P',7);
DROP TABLE IF EXISTS pizzasbase;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE pizzasbase (
  articulo varchar(10) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (articulo,ingrediente),
  KEY fk_Pizzabase_Ingredientes (ingrediente),
  CONSTRAINT fk_Pizzabase_ClaseArticulo FOREIGN KEY (articulo) REFERENCES clasearticulos (articulo) ON DELETE CASCADE,
  CONSTRAINT fk_Pizzabase_Ingredientes FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS productosestrella;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE productosestrella (
  nombre_comercial varchar(15) NOT NULL,
  articulo varchar(10) NOT NULL,
  PRIMARY KEY (nombre_comercial),
  KEY fk_ProductoEstrella_claseArticulo (articulo),
  CONSTRAINT fk_ProductoEstrella_claseArticulo FOREIGN KEY (articulo) REFERENCES clasearticulos (articulo) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS recetaestrella;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE recetaestrella (
  nombre_comercial varchar(15) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (nombre_comercial),
  KEY fk_RecetaEstralla_Ingredientes (ingrediente),
  CONSTRAINT fk_RecetaEstralla_Ingredientes FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE,
  CONSTRAINT fk_RecetaEstrella_ProductoEstrella FOREIGN KEY (nombre_comercial) REFERENCES productosestrella (nombre_comercial)
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS recetasbocadillos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE recetasbocadillos (
  articulo varchar(10) NOT NULL,
  tamano char(1) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  precio_ingrediente decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (articulo,tamano,ingrediente),
  KEY fk_recetaBocadillo_ingrediente (ingrediente),
  CONSTRAINT fk_recetaBocadillo_articulos FOREIGN KEY (articulo, tamano) REFERENCES articulos (articulo, tamano) ON DELETE CASCADE,
  CONSTRAINT fk_recetaBocadillo_ingrediente FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS recetaspizzas;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE recetaspizzas (
  articulo varchar(10) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (articulo,ingrediente),
  KEY fk_receta_pizza (ingrediente),
  CONSTRAINT fk_RecetaPizzas_ClaseArticulos FOREIGN KEY (articulo) REFERENCES clasearticulos (articulo) ON DELETE CASCADE,
  CONSTRAINT fk_receta_pizza FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS recetasventa;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE recetasventa (
  fecha_pedido date NOT NULL,
  pedido decimal(3,0) NOT NULL,
  venta decimal(3,0) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (fecha_pedido,pedido,venta,ingrediente),
  KEY fe_RecetaVenta_Ingredientes (ingrediente),
  CONSTRAINT fe_RecetaVenta_Ingredientes FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente),
  CONSTRAINT fk_RecetaVentas_VentasProductos FOREIGN KEY (fecha_pedido, pedido, venta) REFERENCES ventasproductos (fecha_pedidos, pedido, venta) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS regalos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE regalos (
  regalo decimal(4,0) NOT NULL,
  motivo char(1) NOT NULL,
  limite decimal(2,0) NOT NULL,
  PRIMARY KEY (regalo,motivo)
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS repartidores;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE repartidores (
  dni_repartidor varchar(9) NOT NULL,
  nombre_completo_repartidor varchar(40) NOT NULL,
  scooter varchar(6) NOT NULL,
  PRIMARY KEY (dni_repartidor),
  KEY fk_repartidor_scooter (scooter),
  CONSTRAINT fk_repartidor_scooter FOREIGN KEY (scooter) REFERENCES scooter (scooter) ON DELETE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS scooter;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE scooter (
  scooter varchar(6) NOT NULL,
  ano_scooters decimal(4,0) DEFAULT NULL,
  PRIMARY KEY (scooter)
);
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO scooter (scooter, ano_scooters) VALUES ('Sco006',1999);
DROP TABLE IF EXISTS tipospedidos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE tipospedidos (
  clase_pedidos varchar(10) NOT NULL,
  incremento decimal(3,0) DEFAULT NULL,
  minimo decimal(4,0) NOT NULL,
  PRIMARY KEY (clase_pedidos)
);
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS ventasproductos;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE ventasproductos (
  fecha_pedidos date NOT NULL,
  pedido decimal(3,0) NOT NULL,
  venta decimal(3,0) NOT NULL,
  articulo varchar(10) NOT NULL,
  tamano char(1) DEFAULT NULL,
  unidades decimal(2,0) DEFAULT NULL,
  valor_venta decimal(4,0) DEFAULT NULL,
  PRIMARY KEY (fecha_pedidos,pedido,venta),
  KEY fk_ventas_Articulos (articulo,tamano),
  CONSTRAINT fe_VentasPedidos_Pedido FOREIGN KEY (fecha_pedidos, pedido) REFERENCES pedidos (fecha_pedidos, pedido) ON DELETE CASCADE,
  CONSTRAINT fk_ventas_Articulos FOREIGN KEY (articulo, tamano) REFERENCES articulos (articulo, tamano)
);
/*!40101 SET character_set_client = @saved_cs_client */;

/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_clasearticulo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_clasearticulo( articulo1 VARCHAR(10),
                                             articulo2 VARCHAR(10),
                                             _tipoarticulo VARCHAR(1))
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
	END;

	START TRANSACTION;
		UPDATE clasearticulos
			SET articulo = articulo2, tipoarticulo = _tipoarticulo
			WHERE articulo = articulo1;
	COMMIT;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_cliente */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_cliente(IN `id` DECIMAL(5,0), IN `nombre` VARCHAR(20), IN `apellido` VARCHAR(40), IN `direccion` VARCHAR(30), IN `telefono` DECIMAL(9,0), IN `pizza` DECIMAL(3,0), IN `bocadillo` DECIMAL(3,0), IN `complemento` DECIMAL(3,0))
update cliente set nombre_cliente=nombre, apellidos_clientes=apellido, direccion_cliente=direccion, telfono_cliente=telefono, consumo_pizza=pizza, consumo_bocadillos=bocadillo, consumo_complementos=complemento
where cliente=id ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_cliente_obesquio */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_cliente_obesquio(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(1), IN `cliente` DECIMAL(5,0), IN `fecha` DATE)
    NO SQL
update obsequioc set motivo = motivo, cliente=cliente, fecha=fecha
where regalo=regalo ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_ingrediente */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_ingrediente(ingrediente1 VARCHAR(4),
	ingrediente2 VARCHAR(4),_nombre VARCHAR(10))
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
	END;

	START TRANSACTION;
		UPDATE ingredientes
			SET ingrediente = ingrediente2,nombre_ingrediente = _nombre
			WHERE ingrediente = ingrediente1;
	COMMIT;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_pedido */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_pedido(IN `clase` VARCHAR(20), IN `incremento` DECIMAL(5,0), IN `min` DECIMAL(4,0))
    NO SQL
update tipospedidos set clase_pedidos=clase, incremento=incremento, minimo=min where clase_pedidos=clase ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_pedido1 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_pedido1(IN `fecha` DATE, IN `pedido` DECIMAL(3,0), IN `clase` VARCHAR(20), IN `total` DECIMAL(4,0), IN `cliente` DECIMAL(5,0), IN `dni` VARCHAR(9), IN `valor` DECIMAL(4,0), IN `incremento` DECIMAL(3,0))
    NO SQL
update pedidos set fecha_pedidos=fecha, pedido=pedido, clase_pedido=clase,total_pedido=total, cliente=cliente, dni_repatidor=dni, valor_receta=valor, incremento=incremento
where fecha_pedidos=fecha ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_pizzasbase */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_pizzasbase( articulo1 VARCHAR(10),
                                             articulo2 VARCHAR(10),
                                             ingrediente1 VARCHAR(4),
                                             ingrediente2 VARCHAR(4))
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
	END;

	START TRANSACTION;
		UPDATE pizzasbase
			SET articulo = articulo2, ingrediente = ingrediente2
			WHERE articulo = articulo1 AND ingrediente = ingrediente1;
	COMMIT;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_productoestrella */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_productoestrella( nombre1 VARCHAR(15),
                                             nombre2 VARCHAR(15),
                                             _articulo VARCHAR(10))
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
	END;

	START TRANSACTION;
		UPDATE productosestrella
			SET nombre_comercial = nombre2, articulo = _articulo
			WHERE nombre_comercial = nombre1;
	COMMIT;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_recetaspizza */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_recetaspizza( articulo1 VARCHAR(10),
                                             articulo2 VARCHAR(10),
                                             ingrediente1 VARCHAR(4),
                                             ingrediente2 VARCHAR(4))
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
	END;

	START TRANSACTION;
		UPDATE recetaspizzas
			SET articulo = articulo2, ingrediente = ingrediente2
			WHERE articulo = articulo1 AND ingrediente = ingrediente1;
	COMMIT;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_actualiza_regalo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_actualiza_regalo(IN `regalo1` DECIMAL(4,0), IN `motivo` CHAR(2), IN `limite` DECIMAL(2,0))
    NO SQL
update regalos set motivo=motivo, limite=limite
where regalo=regalo1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_consulta001 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_consulta001()
begin
	SELECT pizzas.articulo,pizzas.tamano, precio_articulo+(2*precio_ingrediente)
		FROM articulos,pizzas
		WHERE articulos.articulo=pizzas.articulo
			And articulos.tamano=pizzas.tamano;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_consulta002 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_consulta002()
begin
	SELECT articulo, tamano, SUM(valor_venta)”INGRESOS”
		FROM ventasproductos
		WHERE articulo IN (SELECT articulo FROM clasearticulos WHERE articulo like
			'P')
		Group by articulo,tamano
		Order by articulo,tamano;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_consulta004 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_consulta004()
begin
	SELECT scooter AS SCOOTER,dni_repartidor As "DNI",nombre_completo_repartidor As "NOMBRE"
		FROM Repartidores
		WHERE dni_repartidor in (SELECT dni_repartidor
									FROM pedidos
									WHERE pedido=111 and fecha_pedidos='1999-06-08');
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_consulta005 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_consulta005()
BEGIN
  DELETE FROM regalos WHERE NOT EXISTS( SELECT * FROM obsequiosc WHERE regalos.regalo = obsequiosc.regalo ) AND NOT EXISTS ( SELECT * FROM obsequiosp WHERE regalos.regalo = obsequiosp.regalo = obsequiosp.regalo);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_consulta006 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_consulta006()
begin
	SELECT COUNT(*) As "Ventas"
		FROM ventasproductos
		WHERE articulo NOT IN
			(SELECT articulo FROM clasearticulos
				WHERE tipoarticulo='B') AND fecha_pedidos BETWEEN
				'2000-02-01'AND '2000-02-28';
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_abastecer */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_abastecer(sco VARCHAR(6),fch VARCHAR(10))
begin
	SET foreign_key_checks=0;
	DELETE FROM abastecer WHERE scooter LIKE sco AND fecha_abastecer = fch;
	SET foreign_key_checks=1;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_articulos */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_articulos(art VARCHAR(10),tam VARCHAR(1))
begin
	SET foreign_key_checks=0;
	DELETE FROM articulos WHERE articulo LIKE art AND UPPER(tamano) = UPPER(tam);
	SET foreign_key_checks=1;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_clasearticulo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_clasearticulo( _articulo VARCHAR(10) )
BEGIN
	DELETE FROM clasearticulos
		WHERE articulo = _articulo;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_cliente */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_cliente(IN `clienteid` DECIMAL(5,0))
delete from cliente where cliente = clienteid ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_cliente_obsequio */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_cliente_obsequio(IN `regalo1` DECIMAL(4,0))
    NO SQL
delete from obsequiosc where regalo=regalo1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_ingrediente */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_ingrediente(_ingrediente VARCHAR(4))
BEGIN
	DELETE FROM ingredientes
		WHERE ingrediente=_ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_pedido */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_pedido(IN `clase` VARCHAR(20))
    NO SQL
delete from tipospedidos where clase_pedidos=clase ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_pedido1 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_pedido1(IN `fecha1` DATE)
    NO SQL
delete from pedidos where fecha=fecha1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_pizza */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_pizza(art VARCHAR(10),tam VARCHAR(1))
begin
	SET foreign_key_checks=0;
	DELETE FROM pizzas WHERE articulo LIKE art AND UPPER(tamano) = UPPER(tam);
	SET foreign_key_checks=1;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_pizzasbase */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_pizzasbase( _articulo VARCHAR(10),_ingrediente VARCHAR(4) )
BEGIN
	DELETE FROM pizzasbase
		WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_productoestrella */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_productoestrella( nombre VARCHAR(15) )
BEGIN
	DELETE FROM productosestrella
		WHERE nombre_comercial = nombre;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_recetaestrella */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_recetaestrella(_nombre_comercial VARCHAR(14))
BEGIN
	DELETE FROM recetaestrella
		WHERE nombre_comercial = _nombre_comercial;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_recetaspedidos */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_recetaspedidos( _fecha DATE,_pedido DECIMAL(3,0),_venta DECIMAL(3,0), _ingrediente VARCHAR(4) )
BEGIN
	DELETE FROM recetaspedido
		WHERE fecha_pedido = _fecha AND pedido = _pedido AND venta = _venta AND ingrediente = _ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_recetaspizza */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_recetaspizza( _articulo VARCHAR(10),_ingrediente VARCHAR(4) )
BEGIN
	DELETE FROM recetaspizzas
		WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_regalo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_regalo(IN `regalo1` DECIMAL(4,0))
    NO SQL
delete from regalos where regalo=regalo1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_scooter */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_scooter(sco VARCHAR(6))
begin

	DELETE FROM scooter WHERE scooter LIKE sco;

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_elimina_ventasproductos */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_elimina_ventasproductos(fch VARCHAR(10),ped DECIMAL(3,0),vnt DECIMAL(3,0))
begin
	DELETE
		FROM ventasproductos 
		WHERE fecha_pedidos=fch AND pedido=ped AND venta=vnt;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_abastecer */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_abastecer(sco VARCHAR(6),fch VARCHAR(10))
begin
	IF fch IS NULL OR fch=' ' OR fch='' OR fch='0000-00-00 00:00:00' then
		SELECT ab.scooter AS SCOOTER,ab.fecha_abastecer AS 'FECHA',ab.costo_abastecer AS 'COSTO' 
			FROM abastecer As ab 
			WHERE scooter LIKE CONCAT("%",sco,"%");
	ELSE
		SELECT ab.scooter AS SCOOTER,ab.fecha_abastecer AS 'FECHA',ab.costo_abastecer AS 'COSTO' 
			FROM abastecer As ab 
			WHERE ab.scooter LIKE CONCAT("%",sco,"%") AND ab.fecha_abastecer = fch;
	END IF;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_articulos */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_articulos(art VARCHAR(10),tam VARCHAR(1))
begin
	SELECT ar.articulo AS ARTICULO, ar.tamano AS TAMANIO,ar.precio_articulo AS PRECIO
		FROM articulos As ar
		WHERE (ar.articulo LIKE CONCAT("%",art,"%")) AND (upper(ar.tamano) LIKE CONCAT("%",upper(tam),"%"));
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_clasearticulo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_clasearticulo()
BEGIN
	
	SELECT articulo AS "ARTICULO", tipoarticulo AS "TIPO DE ARTICULO"
		FROM clasearticulos;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_clasearticulo_esp */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_clasearticulo_esp( _articulo VARCHAR(10) )
BEGIN
	
	SELECT articulo AS "ARTICULO", tipoarticulo AS "TIPO DE ARTICULO"
		FROM clasearticulos WHERE articulo = _articulo;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_clientes */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_clientes()
SELECT cl.cliente As ID, cl.nombre_cliente As "NOMBRE",
			cl.apellidos_clientes As "APELLIDOS",
			cl.direccion_cliente As "DIRECCION",
			cl.telfono_cliente As "TELEFONO",
            cl.consumo_pizza As "PIZZA",
            cl.consumo_bocadillos As "BOCADILLOS",
            cl.consumo_complementos As "COMPLEMENTOS"
		FROM cliente As cl ORDER BY cl.cliente ASC ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_clientes_obsequio */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_clientes_obsequio()
    NO SQL
SELECT ob.regalo As "REGALO", ob.motivo As "MOTIVO",
			ob.cliente As "CLIENTE",
			ob.fecha_obsequio As "FECHA"
		FROM obsequiosc As ob ORDER BY ob.regalo ASC ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_ingredientes */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_ingredientes()
BEGIN
	
	SELECT ingrediente AS "INGREDIENTE", nombre_ingrediente AS "NOMBRE DEL INGREDIENTE"
		FROM ingredientes;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_ingrediente_esp */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_ingrediente_esp(_ingrediente VARCHAR(4))
BEGIN
	
	SELECT ingrediente AS "INGREDIENTE", nombre_ingrediente AS "NOMBRE DEL INGREDIENTE"
		FROM ingredientes 
		WHERE ingrediente = _ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_pedido1 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_pedido1()
    NO SQL
SELECT pd.fecha_pedidos As "FECHA", pd.pedido As "PEDIDO",
			pd.clase_pedido As "CLASE",
			pd.total_pedido As "TOTAL",
			pd.cliente As "CLIENTE",
            pd.dni_repartidor As "DNI",
            pd.valor_receta As "VALOR",
            pd.incremento As "INCREMENTO"
		FROM pedidos As pd ORDER BY pd.fecha_pedidos ASC ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_pizzas */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_pizzas(art VARCHAR(10),tam VARCHAR(1))
begin
	SELECT pi.articulo AS ARTICULO, pi.tamano AS TAMANIO,pi.precio_ingrediente AS 'PRECIO-ING'
		FROM pizzas As pi
		WHERE (pi.articulo LIKE CONCAT("%",art,"%")) AND (upper(pi.tamano) LIKE CONCAT("%",upper(tam),"%"));
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_pizzasbase */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_pizzasbase()
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM pizzasbase;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_pizzasbase_esp */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_pizzasbase_esp( _articulo VARCHAR(10), _ingrediente VARCHAR(4))
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM pizzasbase WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_productoestrella */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_productoestrella()
BEGIN
	
	SELECT nombre_comercial AS "NOMBRE COMERCIAL", articulo AS "ARTICULO"
		FROM productosestrella;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_productoestrella_esp */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_productoestrella_esp( nombre VARCHAR(15) )
BEGIN
	
	SELECT nombre_comercial AS "NOMBRE COMERCIAL", articulo AS "ARTICULO"
		FROM productosestrella WHERE nombre_comercial = nombre;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_recetaestrella */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_recetaestrella()
BEGIN
	
	SELECT nombre_comercial AS "NOMBRE COMERCIAL", ingrediente AS "INGREDIENTE"
		FROM recetaestrella;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_recetaspizza */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_recetaspizza()
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM recetaspizzas;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_recetaspizza_esp */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_recetaspizza_esp( _articulo VARCHAR(10), _ingrediente VARCHAR(4))
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM recetaspizzas WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_recetasventas */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_recetasventas()
BEGIN
	
	SELECT fecha_pedido AS "FECHA",pedido AS "PEDIDO",venta AS "VENTA", ingrediente AS "INGREDIENTE"
		FROM recetasventa;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_recetasventas_esp */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_recetasventas_esp( _fecha DATE,_pedido DECIMAL(3,0),_venta DECIMAL(3,0), _ingrediente VARCHAR(4))
BEGIN
	
	SELECT fecha_pedido AS "FECHA",pedido AS "PEDIDO",venta AS "VENTA", ingrediente AS "INGREDIENTE"
		FROM recetasventa WHERE fecha_pedido = _fecha AND pedido = _pedido AND venta = _venta AND ingrediente = _ingrediente;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_regalo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_regalo()
    NO SQL
SELECT re.regalo as "REGALO", re.motivo as "MOTIVO", re.limite as "LIMITE" FROM regalos as re ORDER BY re.regalo ASC ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_scooters */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_scooters(sco VARCHAR(6))
begin

	SELECT sc.scooter AS SCOOTER,sc.ano_scooters AS 'ANIO' FROM scooter As sc WHERE scooter LIKE CONCAT("%",sco,"%");

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_tipopedido */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_tipopedido()
    NO SQL
select tp.clase_pedidos as "CLASE", tp.incremento as "INCREMENTO", tp.minimo as "MINIMO"
from tipospedidos as tp order by tp.clase_pedidos ASC ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_get_ventasproductos */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_get_ventasproductos()
begin
	SELECT vp.fecha_pedidos AS FECHA,vp.pedido AS PEDIDO, vp.venta AS VENTA,
			vp.articulo AS ARTICULO,vp.tamano As TAMANIO,vp.unidades AS UNIDADES,
			vp.valor_venta AS VALOR
		FROM ventasproductos As vp;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nueva_pizza */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nueva_pizza(art VARCHAR(10),tam VARCHAR(1),prc DECIMAL(3,0))
begin

	INSERT INTO pizzas (articulo,tamano,precio_ingrediente)
		VALUES(art,tam,prc);

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nueva_recetaestrella */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nueva_recetaestrella( nombre_comercial VARCHAR(14),
		ingrediente VARCHAR(4))
BEGIN
	INSERT INTO recetaestrella
		VALUES ( nombre_comercial, ingrediente);
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nueva_ventasproductos */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nueva_ventasproductos(fch VARCHAR(10),ped DECIMAL(3,0),vnt DECIMAL(3,0),
				art VARCHAR(10),tam VARCHAR(1),und DECIMAL(2,0),vlr DECIMAL(4,0))
begin
		INSERT INTO ventasproductos (fecha_pedidos,pedido,venta,
				articulo,tamano,unidades,valor_venta)
			VALUES(fch,ped,vnt,art,tam,und,vlr);
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_abastecer */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_abastecer(sco VARCHAR(6),fch DATE,cst decimal(3,0))
begin

	INSERT INTO abastecer (scooter,fecha_abastecer,costo_abastecer)
		VALUES(sco,fch,cst);

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_articulo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_articulo(art VARCHAR(10),tam VARCHAR(1),prc DECIMAL(4,0))
begin

	INSERT INTO articulos (articulo,tamano,precio_articulo)
		VALUES(art,tam,prc);

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_clasearticulo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_clasearticulo(articulo VARCHAR(10), tipoarticulo VARCHAR(1))
BEGIN
	INSERT INTO clasearticulos
		VALUES (articulo,tipoarticulo);
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_cliente */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_cliente(IN `id` DECIMAL(5,0), IN `nombre` VARCHAR(20), IN `apellido` VARCHAR(40), IN `direccion` VARCHAR(30), IN `telefono` DECIMAL(9,0), IN `pizza` DECIMAL(3,0), IN `bocadillo` DECIMAL(3,0), IN `complemento` DECIMAL(3,0))
    NO SQL
insert into cliente values (id,nombre,apellido,direccion,telefono,pizza,bocadillo, complemento) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_cliente_obsequio */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_cliente_obsequio(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(1), IN `cliente` DECIMAL(5,0), IN `fecha` DATE)
    NO SQL
insert into obsequiosc values (regalo,motivo,cliente,fecha) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_ingrediente */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_ingrediente(ingrediente VARCHAR(4),nombre VARCHAR(10))
BEGIN
	INSERT INTO ingredientes
		VALUES (ingrediente,nombre);
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_pedido1 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_pedido1(IN `fecha` DATE, IN `pedido` DECIMAL(3,0), IN `clase` VARCHAR(20), IN `total` DECIMAL(4,0), IN `cliente` DECIMAL(5,0), IN `dni` VARCHAR(9), IN `valor` DECIMAL(4,0), IN `incremento` DECIMAL(3,0))
    NO SQL
insert into pedidos values (fecha,pedido,clase,total,cliente,dni,valor,incremento) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_pizzasbase */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_pizzasbase(articulo VARCHAR(10), ingrediente VARCHAR(4))
BEGIN
	INSERT INTO pizzasbase
		VALUES (articulo,ingrediente);
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_productoestrella */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_productoestrella( nombre VARCHAR(15),articulo VARCHAR (10) )
BEGIN 
INSERT INTO productosestrella VALUES ( nombre, articulo); 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_recetaspizza */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_recetaspizza(articulo VARCHAR(10), ingrediente VARCHAR(4))
BEGIN
	INSERT INTO recetaspizzas
		VALUES (articulo,ingrediente);
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_recetasventas */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_recetasventas(fecha DATE,
                                          pedido DECIMAL(3,0),
                                          venta DECIMAL(3,0),
                                          ingrediente VARCHAR(4))
BEGIN
	INSERT INTO recetasventa
		VALUES (fecha,pedido,venta,ingrediente);
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_regalo */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_regalo(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(2), IN `limite` DECIMAL(2,0))
    NO SQL
insert into regalos
values(regalo, motivo,limite) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_scooter */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_scooter(sco VARCHAR(6),anio DECIMAL(4,0))
begin

	INSERT INTO scooter (scooter,ano_scooters)
		VALUES(sco,anio);

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS sp_nuevo_tipopedido */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=eavila@localhost PROCEDURE sp_nuevo_tipopedido(IN `clase` VARCHAR(20), IN `incremen` DECIMAL(3,0), IN `min` DECIMAL(4,0))
    NO SQL
insert into tipospedidos values(clase,incremen,min) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

