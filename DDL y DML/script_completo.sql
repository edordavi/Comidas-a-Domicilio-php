CREATE DATABASE comidasadomicilio;

USE comidasadomicilio;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS abastecer (
  scooter varchar(6) NOT NULL,
  fecha_abastecer date NOT NULL,
  costo_abastecer decimal(3,0) NOT NULL,
  PRIMARY KEY (scooter,fecha_abastecer)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS articulos (
  articulo varchar(10) NOT NULL,
  tamano char(1) NOT NULL,
  precio_articulo decimal(4,0) NOT NULL,
  PRIMARY KEY (articulo,tamano)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS clasearticulos (
  articulo varchar(10) NOT NULL,
  tipoArticulo char(1) NOT NULL,
  PRIMARY KEY (articulo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS cliente (
  cliente decimal(5,0) NOT NULL,
  nombre_cliente varchar(20) NOT NULL,
  apellidos_clientes varchar(40) NOT NULL,
  direccion_cliente varchar(30) DEFAULT NULL,
  telfono_cliente decimal(9,0) DEFAULT NULL,
  consumo_pizza decimal(3,0) DEFAULT NULL,
  consumo_bocadillos decimal(3,0) DEFAULT NULL,
  consumo_complementos decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (cliente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS ingredientes (
  ingrediente varchar(4) NOT NULL,
  nombre_ingrediente varchar(10) NOT NULL,
  PRIMARY KEY (ingrediente),
  UNIQUE KEY unique__ingrediente (nombre_ingrediente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS obsequiosc (
  regalo decimal(4,0) NOT NULL,
  motivo char(1) NOT NULL,
  cliente decimal(5,0) NOT NULL,
  fecha_obsequio date NOT NULL,
  PRIMARY KEY (regalo,motivo,cliente,fecha_obsequio),
  KEY fk_Obsequi_Cliente (cliente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS obsequiosp (
  fecha_Pedido date NOT NULL,
  pedido decimal(3,0) NOT NULL,
  regalo decimal(4,0) NOT NULL,
  motivo char(1) NOT NULL,
  PRIMARY KEY (fecha_Pedido,pedido),
  KEY fk_ObsequiosP_Regalos (regalo,motivo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS pedidos (
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
  KEY fk_Pedido_TipoPedido (clase_pedido)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS pizzas (
  articulo varchar(10) NOT NULL,
  tamano char(1) NOT NULL,
  precio_ingrediente decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (articulo,tamano)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS pizzasbase (
  articulo varchar(10) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (articulo,ingrediente),
  KEY fk_Pizzabase_Ingredientes (ingrediente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS productosestrella (
  nombre_comercial varchar(15) NOT NULL,
  articulo varchar(10) NOT NULL,
  PRIMARY KEY (nombre_comercial),
  KEY fk_ProductoEstrella_claseArticulo (articulo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS recetaestrella (
  nombre_comercial varchar(15) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (nombre_comercial),
  KEY fk_RecetaEstralla_Ingredientes (ingrediente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS recetasbocadillos (
  articulo varchar(10) NOT NULL,
  tamano char(1) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  precio_ingrediente decimal(3,0) DEFAULT NULL,
  PRIMARY KEY (articulo,tamano,ingrediente),
  KEY fk_recetaBocadillo_ingrediente (ingrediente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS recetaspizzas (
  articulo varchar(10) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (articulo,ingrediente),
  KEY fk_receta_pizza (ingrediente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS recetasventa (
  fecha_pedido date NOT NULL,
  pedido decimal(3,0) NOT NULL,
  venta decimal(3,0) NOT NULL,
  ingrediente varchar(4) NOT NULL,
  PRIMARY KEY (fecha_pedido,pedido,venta,ingrediente),
  KEY fe_RecetaVenta_Ingredientes (ingrediente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS regalos (
  regalo decimal(4,0) NOT NULL,
  motivo char(1) NOT NULL,
  limite decimal(2,0) NOT NULL,
  PRIMARY KEY (regalo,motivo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS repartidores (
  dni_repartidor varchar(9) NOT NULL,
  nombre_completo_repartidor varchar(40) NOT NULL,
  scooter varchar(6) NOT NULL,
  PRIMARY KEY (dni_repartidor),
  KEY fk_repartidor_scooter (scooter)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS scooter (
  scooter varchar(6) NOT NULL,
  ano_scooters decimal(4,0) DEFAULT NULL,
  PRIMARY KEY (scooter)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS tipospedidos (
  clase_pedidos varchar(10) NOT NULL,
  incremento decimal(3,0) DEFAULT NULL,
  minimo decimal(4,0) NOT NULL,
  PRIMARY KEY (clase_pedidos)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS ventasproductos (
  fecha_pedidos date NOT NULL,
  pedido decimal(3,0) NOT NULL,
  venta decimal(3,0) NOT NULL,
  articulo varchar(10) NOT NULL,
  tamano char(1) DEFAULT NULL,
  unidades decimal(2,0) DEFAULT NULL,
  valor_venta decimal(4,0) DEFAULT NULL,
  PRIMARY KEY (fecha_pedidos,pedido,venta),
  KEY fk_ventas_Articulos (articulo,tamano)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE abastecer
  ADD CONSTRAINT fk_Abastecer_Scooters FOREIGN KEY (scooter) REFERENCES scooter (scooter);

ALTER TABLE obsequiosc
  ADD CONSTRAINT fk_Obsequios_Regalos FOREIGN KEY (regalo, motivo) REFERENCES regalos (regalo, motivo) ON DELETE CASCADE,
  ADD CONSTRAINT fk_Obsequi_Cliente FOREIGN KEY (cliente) REFERENCES `cliente` (cliente) ON DELETE CASCADE;

ALTER TABLE obsequiosp
  ADD CONSTRAINT fk_ObsequiosP_Regalos FOREIGN KEY (regalo, motivo) REFERENCES regalos (regalo, motivo) ON DELETE CASCADE,
  ADD CONSTRAINT fk_OpsequiP_Pedidos FOREIGN KEY (fecha_Pedido, pedido) REFERENCES pedidos (fecha_pedidos, pedido) ON DELETE CASCADE;

ALTER TABLE pedidos
  ADD CONSTRAINT fk_Pedidos_Repartidor FOREIGN KEY (dni_repartidor) REFERENCES repartidores (dni_repartidor),
  ADD CONSTRAINT fk_Pedido_Cliente FOREIGN KEY (cliente) REFERENCES `cliente` (cliente) ON DELETE CASCADE,
  ADD CONSTRAINT fk_Pedido_TipoPedido FOREIGN KEY (clase_pedido) REFERENCES tipospedidos (clase_pedidos) ON DELETE CASCADE;

ALTER TABLE pizzas
  ADD CONSTRAINT fk_pizza_articulo FOREIGN KEY (articulo, tamano) REFERENCES articulos (articulo, tamano) ON DELETE CASCADE;

ALTER TABLE pizzasbase
  ADD CONSTRAINT fk_Pizzabase_ClaseArticulo FOREIGN KEY (articulo) REFERENCES clasearticulos (articulo) ON DELETE CASCADE,
  ADD CONSTRAINT fk_Pizzabase_Ingredientes FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE;

ALTER TABLE productosestrella
  ADD CONSTRAINT fk_ProductoEstrella_claseArticulo FOREIGN KEY (articulo) REFERENCES clasearticulos (articulo) ON DELETE CASCADE;

ALTER TABLE recetaestrella
  ADD CONSTRAINT fk_RecetaEstralla_Ingredientes FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE,
  ADD CONSTRAINT fk_RecetaEstrella_ProductoEstrella FOREIGN KEY (nombre_comercial) REFERENCES productosestrella (nombre_comercial);

ALTER TABLE recetasbocadillos
  ADD CONSTRAINT fk_recetaBocadillo_articulos FOREIGN KEY (articulo, tamano) REFERENCES articulos (articulo, tamano) ON DELETE CASCADE,
  ADD CONSTRAINT fk_recetaBocadillo_ingrediente FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE;

ALTER TABLE recetaspizzas
  ADD CONSTRAINT fk_RecetaPizzas_ClaseArticulos FOREIGN KEY (articulo) REFERENCES clasearticulos (articulo) ON DELETE CASCADE,
  ADD CONSTRAINT fk_receta_pizza FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente) ON DELETE CASCADE;

ALTER TABLE recetasventa
  ADD CONSTRAINT fe_RecetaVenta_Ingredientes FOREIGN KEY (ingrediente) REFERENCES ingredientes (ingrediente),
  ADD CONSTRAINT fk_RecetaVentas_VentasProductos FOREIGN KEY (fecha_pedido, pedido, venta) REFERENCES ventasproductos (fecha_pedidos, pedido, venta) ON DELETE CASCADE;

ALTER TABLE repartidores
  ADD CONSTRAINT fk_repartidor_scooter FOREIGN KEY (scooter) REFERENCES scooter (scooter) ON DELETE CASCADE;

ALTER TABLE ventasproductos
  ADD CONSTRAINT fe_VentasPedidos_Pedido FOREIGN KEY (fecha_pedidos, pedido) REFERENCES pedidos (fecha_pedidos, pedido) ON DELETE CASCADE,
  ADD CONSTRAINT fk_ventas_Articulos FOREIGN KEY (articulo, tamano) REFERENCES articulos (articulo, tamano);


DELIMITER $$
CREATE  PROCEDURE `sp_actualiza_clasearticulo`( articulo1 VARCHAR(10),
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
	
END$$

CREATE  PROCEDURE `sp_actualiza_cliente`(IN `id` DECIMAL(5,0), IN `nombre` VARCHAR(20), IN `apellido` VARCHAR(40), IN `direccion` VARCHAR(30), IN `telefono` DECIMAL(9,0), IN `pizza` DECIMAL(3,0), IN `bocadillo` DECIMAL(3,0), IN `complemento` DECIMAL(3,0))
update cliente set nombre_cliente=nombre, apellidos_clientes=apellido, direccion_cliente=direccion, telfono_cliente=telefono, consumo_pizza=pizza, consumo_bocadillos=bocadillo, consumo_complementos=complemento
where cliente=id$$

CREATE  PROCEDURE `sp_actualiza_cliente_obesquio`(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(1), IN `cliente` DECIMAL(5,0), IN `fecha` DATE)
    NO SQL
update obsequioc set motivo = motivo, cliente=cliente, fecha=fecha
where regalo=regalo$$

CREATE  PROCEDURE `sp_actualiza_ingrediente`(ingrediente1 VARCHAR(4),
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
	
END$$

CREATE  PROCEDURE `sp_actualiza_pedido`(IN `clase` VARCHAR(20), IN `incremento` DECIMAL(5,0), IN `min` DECIMAL(4,0))
    NO SQL
update tipospedidos set clase_pedidos=clase, incremento=incremento, minimo=min where clase_pedidos=clase$$

CREATE  PROCEDURE `sp_actualiza_pedido1`(IN `fecha` DATE, IN `pedido` DECIMAL(3,0), IN `clase` VARCHAR(20), IN `total` DECIMAL(4,0), IN `cliente` DECIMAL(5,0), IN `dni` VARCHAR(9), IN `valor` DECIMAL(4,0), IN `incremento` DECIMAL(3,0))
    NO SQL
update pedidos set fecha_pedidos=fecha, pedido=pedido, clase_pedido=clase,total_pedido=total, cliente=cliente, dni_repatidor=dni, valor_receta=valor, incremento=incremento
where fecha_pedidos=fecha$$

CREATE  PROCEDURE `sp_actualiza_pizzasbase`( articulo1 VARCHAR(10),
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
	
END$$

CREATE  PROCEDURE `sp_actualiza_productoestrella`( nombre1 VARCHAR(15),
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
	
END$$

CREATE  PROCEDURE `sp_actualiza_recetaspizza`( articulo1 VARCHAR(10),
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
	
END$$

CREATE  PROCEDURE `sp_actualiza_regalo`(IN `regalo1` DECIMAL(4,0), IN `motivo` CHAR(2), IN `limite` DECIMAL(2,0))
    NO SQL
update regalos set motivo=motivo, limite=limite
where regalo=regalo1$$

CREATE  PROCEDURE `sp_consulta001`()
begin
	SELECT pizzas.articulo,pizzas.tamano, precio_articulo+(2*precio_ingrediente)
		FROM articulos,pizzas
		WHERE articulos.articulo=pizzas.articulo
			And articulos.tamano=pizzas.tamano;
end$$

CREATE  PROCEDURE `sp_consulta002`()
begin
	SELECT articulo, tamano, SUM(valor_venta)”INGRESOS”
		FROM ventasproductos
		WHERE articulo IN (SELECT articulo FROM clasearticulos WHERE articulo like
			'P')
		Group by articulo,tamano
		Order by articulo,tamano;
end$$

CREATE  PROCEDURE `sp_consulta004`()
begin
	SELECT scooter AS SCOOTER,dni_repartidor As "DNI",nombre_completo_repartidor As "NOMBRE"
		FROM Repartidores
		WHERE dni_repartidor in (SELECT dni_repartidor
									FROM pedidos
									WHERE pedido=111 and fecha_pedidos='1999-06-08');
end$$

CREATE  PROCEDURE `sp_consulta005`()
BEGIN
  DELETE FROM regalos WHERE NOT EXISTS( SELECT * FROM obsequiosc WHERE regalos.regalo = obsequiosc.regalo ) AND NOT EXISTS ( SELECT * FROM obsequiosp WHERE regalos.regalo = obsequiosp.regalo = obsequiosp.regalo);
END$$

CREATE  PROCEDURE `sp_consulta006`()
begin
	SELECT COUNT(*) As "Ventas"
		FROM ventasproductos
		WHERE articulo NOT IN
			(SELECT articulo FROM clasearticulos
				WHERE tipoarticulo='B') AND fecha_pedidos BETWEEN
				'2000-02-01'AND '2000-02-28';
end$$

CREATE  PROCEDURE `sp_elimina_abastecer`(sco VARCHAR(6),fch VARCHAR(10))
begin
	SET foreign_key_checks=0;
	DELETE FROM abastecer WHERE scooter LIKE sco AND fecha_abastecer = fch;
	SET foreign_key_checks=1;
end$$

CREATE  PROCEDURE `sp_elimina_articulos`(art VARCHAR(10),tam VARCHAR(1))
begin
	SET foreign_key_checks=0;
	DELETE FROM articulos WHERE articulo LIKE art AND UPPER(tamano) = UPPER(tam);
	SET foreign_key_checks=1;
end$$

CREATE  PROCEDURE `sp_elimina_clasearticulo`( _articulo VARCHAR(10) )
BEGIN
	DELETE FROM clasearticulos
		WHERE articulo = _articulo;
	
END$$

CREATE  PROCEDURE `sp_elimina_cliente`(IN `clienteid` DECIMAL(5,0))
delete from cliente where cliente = clienteid$$

CREATE  PROCEDURE `sp_elimina_cliente_obsequio`(IN `regalo1` DECIMAL(4,0))
    NO SQL
delete from obsequiosc where regalo=regalo1$$

CREATE  PROCEDURE `sp_elimina_ingrediente`(_ingrediente VARCHAR(4))
BEGIN
	DELETE FROM ingredientes
		WHERE ingrediente=_ingrediente;
	
END$$

CREATE  PROCEDURE `sp_elimina_pedido`(IN `clase` VARCHAR(20))
    NO SQL
delete from tipospedidos where clase_pedidos=clase$$

CREATE  PROCEDURE `sp_elimina_pedido1`(IN `fecha1` DATE)
    NO SQL
delete from pedidos where fecha=fecha1$$

CREATE  PROCEDURE `sp_elimina_pizza`(art VARCHAR(10),tam VARCHAR(1))
begin
	SET foreign_key_checks=0;
	DELETE FROM pizzas WHERE articulo LIKE art AND UPPER(tamano) = UPPER(tam);
	SET foreign_key_checks=1;
end$$

CREATE  PROCEDURE `sp_elimina_pizzasbase`( _articulo VARCHAR(10),_ingrediente VARCHAR(4) )
BEGIN
	DELETE FROM pizzasbase
		WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END$$

CREATE  PROCEDURE `sp_elimina_productoestrella`( nombre VARCHAR(15) )
BEGIN
	DELETE FROM productosestrella
		WHERE nombre_comercial = nombre;
	
END$$

CREATE  PROCEDURE `sp_elimina_recetaestrella`(_nombre_comercial VARCHAR(14))
BEGIN
	DELETE FROM recetaestrella
		WHERE nombre_comercial = _nombre_comercial;
	
END$$

CREATE  PROCEDURE `sp_elimina_recetaspedidos`( _fecha DATE,_pedido DECIMAL(3,0),_venta DECIMAL(3,0), _ingrediente VARCHAR(4) )
BEGIN
	DELETE FROM recetaspedido
		WHERE fecha_pedido = _fecha AND pedido = _pedido AND venta = _venta AND ingrediente = _ingrediente;
	
END$$

CREATE  PROCEDURE `sp_elimina_recetaspizza`( _articulo VARCHAR(10),_ingrediente VARCHAR(4) )
BEGIN
	DELETE FROM recetaspizzas
		WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END$$

CREATE  PROCEDURE `sp_elimina_regalo`(IN `regalo1` DECIMAL(4,0))
    NO SQL
delete from regalos where regalo=regalo1$$

CREATE  PROCEDURE `sp_elimina_scooter`(sco VARCHAR(6))
begin

	DELETE FROM scooter WHERE scooter LIKE sco;

end$$

CREATE  PROCEDURE `sp_elimina_ventasproductos`(fch VARCHAR(10),ped DECIMAL(3,0),vnt DECIMAL(3,0))
begin
	DELETE
		FROM ventasproductos 
		WHERE fecha_pedidos=fch AND pedido=ped AND venta=vnt;
end$$

CREATE  PROCEDURE `sp_get_abastecer`(sco VARCHAR(6),fch VARCHAR(10))
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
end$$

CREATE  PROCEDURE `sp_get_articulos`(art VARCHAR(10),tam VARCHAR(1))
begin
	SELECT ar.articulo AS ARTICULO, ar.tamano AS TAMANIO,ar.precio_articulo AS PRECIO
		FROM articulos As ar
		WHERE (ar.articulo LIKE CONCAT("%",art,"%")) AND (upper(ar.tamano) LIKE CONCAT("%",upper(tam),"%"));
end$$

CREATE  PROCEDURE `sp_get_clasearticulo`()
BEGIN
	
	SELECT articulo AS "ARTICULO", tipoarticulo AS "TIPO DE ARTICULO"
		FROM clasearticulos;
	
END$$

CREATE  PROCEDURE `sp_get_clasearticulo_esp`( _articulo VARCHAR(10) )
BEGIN
	
	SELECT articulo AS "ARTICULO", tipoarticulo AS "TIPO DE ARTICULO"
		FROM clasearticulos WHERE articulo = _articulo;
	
END$$

CREATE  PROCEDURE `sp_get_clientes`()
SELECT cl.cliente As ID, cl.nombre_cliente As "NOMBRE",
			cl.apellidos_clientes As "APELLIDOS",
			cl.direccion_cliente As "DIRECCION",
			cl.telfono_cliente As "TELEFONO",
            cl.consumo_pizza As "PIZZA",
            cl.consumo_bocadillos As "BOCADILLOS",
            cl.consumo_complementos As "COMPLEMENTOS"
		FROM cliente As cl ORDER BY cl.cliente ASC$$

CREATE  PROCEDURE `sp_get_clientes_obsequio`()
    NO SQL
SELECT ob.regalo As "REGALO", ob.motivo As "MOTIVO",
			ob.cliente As "CLIENTE",
			ob.fecha_obsequio As "FECHA"
		FROM obsequiosc As ob ORDER BY ob.regalo ASC$$

CREATE  PROCEDURE `sp_get_ingredientes`()
BEGIN
	
	SELECT ingrediente AS "INGREDIENTE", nombre_ingrediente AS "NOMBRE DEL INGREDIENTE"
		FROM ingredientes;
	
END$$

CREATE  PROCEDURE `sp_get_ingrediente_esp`(_ingrediente VARCHAR(4))
BEGIN
	
	SELECT ingrediente AS "INGREDIENTE", nombre_ingrediente AS "NOMBRE DEL INGREDIENTE"
		FROM ingredientes 
		WHERE ingrediente = _ingrediente;
	
END$$

CREATE  PROCEDURE `sp_get_pedido1`()
    NO SQL
SELECT pd.fecha_pedidos As "FECHA", pd.pedido As "PEDIDO",
			pd.clase_pedido As "CLASE",
			pd.total_pedido As "TOTAL",
			pd.cliente As "CLIENTE",
            pd.dni_repartidor As "DNI",
            pd.valor_receta As "VALOR",
            pd.incremento As "INCREMENTO"
		FROM pedidos As pd ORDER BY pd.fecha_pedidos ASC$$

CREATE  PROCEDURE `sp_get_pizzas`(art VARCHAR(10),tam VARCHAR(1))
begin
	SELECT pi.articulo AS ARTICULO, pi.tamano AS TAMANIO,pi.precio_ingrediente AS 'PRECIO-ING'
		FROM pizzas As pi
		WHERE (pi.articulo LIKE CONCAT("%",art,"%")) AND (upper(pi.tamano) LIKE CONCAT("%",upper(tam),"%"));
end$$

CREATE  PROCEDURE `sp_get_pizzasbase`()
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM pizzasbase;
	
END$$

CREATE  PROCEDURE `sp_get_pizzasbase_esp`( _articulo VARCHAR(10), _ingrediente VARCHAR(4))
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM pizzasbase WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END$$

CREATE  PROCEDURE `sp_get_productoestrella`()
BEGIN
	
	SELECT nombre_comercial AS "NOMBRE COMERCIAL", articulo AS "ARTICULO"
		FROM productosestrella;
	
END$$

CREATE  PROCEDURE `sp_get_productoestrella_esp`( nombre VARCHAR(15) )
BEGIN
	
	SELECT nombre_comercial AS "NOMBRE COMERCIAL", articulo AS "ARTICULO"
		FROM productosestrella WHERE nombre_comercial = nombre;
	
END$$

CREATE  PROCEDURE `sp_get_recetaestrella`()
BEGIN
	
	SELECT nombre_comercial AS "NOMBRE COMERCIAL", ingrediente AS "INGREDIENTE"
		FROM recetaestrella;
	
END$$

CREATE  PROCEDURE `sp_get_recetaspizza`()
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM recetaspizzas;
	
END$$

CREATE  PROCEDURE `sp_get_recetaspizza_esp`( _articulo VARCHAR(10), _ingrediente VARCHAR(4))
BEGIN
	
	SELECT articulo AS "ARTICULO", ingrediente AS "INGREDIENTE"
		FROM recetaspizzas WHERE articulo = _articulo AND ingrediente = _ingrediente;
	
END$$

CREATE  PROCEDURE `sp_get_recetasventas`()
BEGIN
	
	SELECT fecha_pedido AS "FECHA",pedido AS "PEDIDO",venta AS "VENTA", ingrediente AS "INGREDIENTE"
		FROM recetasventa;
	
END$$

CREATE  PROCEDURE `sp_get_recetasventas_esp`( _fecha DATE,_pedido DECIMAL(3,0),_venta DECIMAL(3,0), _ingrediente VARCHAR(4))
BEGIN
	
	SELECT fecha_pedido AS "FECHA",pedido AS "PEDIDO",venta AS "VENTA", ingrediente AS "INGREDIENTE"
		FROM recetasventa WHERE fecha_pedido = _fecha AND pedido = _pedido AND venta = _venta AND ingrediente = _ingrediente;
	
END$$

CREATE  PROCEDURE `sp_get_regalo`()
    NO SQL
SELECT re.regalo as "REGALO", re.motivo as "MOTIVO", re.limite as "LIMITE" FROM regalos as re ORDER BY re.regalo ASC$$

CREATE  PROCEDURE `sp_get_scooters`(sco VARCHAR(6))
begin

	SELECT sc.scooter AS SCOOTER,sc.ano_scooters AS 'ANIO' FROM scooter As sc WHERE scooter LIKE CONCAT("%",sco,"%");

end$$

CREATE  PROCEDURE `sp_get_tipopedido`()
    NO SQL
select tp.clase_pedidos as "CLASE", tp.incremento as "INCREMENTO", tp.minimo as "MINIMO"
from tipospedidos as tp order by tp.clase_pedidos ASC$$

CREATE  PROCEDURE `sp_get_ventasproductos`()
begin
	SELECT vp.fecha_pedidos AS FECHA,vp.pedido AS PEDIDO, vp.venta AS VENTA,
			vp.articulo AS ARTICULO,vp.tamano As TAMANIO,vp.unidades AS UNIDADES,
			vp.valor_venta AS VALOR
		FROM ventasproductos As vp;
end$$

CREATE  PROCEDURE `sp_nueva_pizza`(art VARCHAR(10),tam VARCHAR(1),prc DECIMAL(3,0))
begin

	INSERT INTO pizzas (articulo,tamano,precio_ingrediente)
		VALUES(art,tam,prc);

end$$

CREATE  PROCEDURE `sp_nueva_recetaestrella`( nombre_comercial VARCHAR(14),
		ingrediente VARCHAR(4))
BEGIN
	INSERT INTO recetaestrella
		VALUES ( nombre_comercial, ingrediente);
	
END$$

CREATE  PROCEDURE `sp_nueva_ventasproductos`(fch VARCHAR(10),ped DECIMAL(3,0),vnt DECIMAL(3,0),
				art VARCHAR(10),tam VARCHAR(1),und DECIMAL(2,0),vlr DECIMAL(4,0))
begin
		INSERT INTO ventasproductos (fecha_pedidos,pedido,venta,
				articulo,tamano,unidades,valor_venta)
			VALUES(fch,ped,vnt,art,tam,und,vlr);
end$$

CREATE  PROCEDURE `sp_nuevo_abastecer`(sco VARCHAR(6),fch DATE,cst decimal(3,0))
begin

	INSERT INTO abastecer (scooter,fecha_abastecer,costo_abastecer)
		VALUES(sco,fch,cst);

end$$

CREATE  PROCEDURE `sp_nuevo_articulo`(art VARCHAR(10),tam VARCHAR(1),prc DECIMAL(4,0))
begin

	INSERT INTO articulos (articulo,tamano,precio_articulo)
		VALUES(art,tam,prc);

end$$

CREATE  PROCEDURE `sp_nuevo_clasearticulo`(articulo VARCHAR(10), tipoarticulo VARCHAR(1))
BEGIN
	INSERT INTO clasearticulos
		VALUES (articulo,tipoarticulo);
	
END$$

CREATE  PROCEDURE `sp_nuevo_cliente`(IN `id` DECIMAL(5,0), IN `nombre` VARCHAR(20), IN `apellido` VARCHAR(40), IN `direccion` VARCHAR(30), IN `telefono` DECIMAL(9,0), IN `pizza` DECIMAL(3,0), IN `bocadillo` DECIMAL(3,0), IN `complemento` DECIMAL(3,0))
    NO SQL
insert into cliente values (id,nombre,apellido,direccion,telefono,pizza,bocadillo, complemento)$$

CREATE  PROCEDURE `sp_nuevo_cliente_obsequio`(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(1), IN `cliente` DECIMAL(5,0), IN `fecha` DATE)
    NO SQL
insert into obsequiosc values (regalo,motivo,cliente,fecha)$$

CREATE  PROCEDURE `sp_nuevo_ingrediente`(ingrediente VARCHAR(4),nombre VARCHAR(10))
BEGIN
	INSERT INTO ingredientes
		VALUES (ingrediente,nombre);
	
END$$

CREATE  PROCEDURE `sp_nuevo_pedido1`(IN `fecha` DATE, IN `pedido` DECIMAL(3,0), IN `clase` VARCHAR(20), IN `total` DECIMAL(4,0), IN `cliente` DECIMAL(5,0), IN `dni` VARCHAR(9), IN `valor` DECIMAL(4,0), IN `incremento` DECIMAL(3,0))
    NO SQL
insert into pedidos values (fecha,pedido,clase,total,cliente,dni,valor,incremento)$$

CREATE  PROCEDURE `sp_nuevo_pizzasbase`(articulo VARCHAR(10), ingrediente VARCHAR(4))
BEGIN
	INSERT INTO pizzasbase
		VALUES (articulo,ingrediente);
	
END$$

CREATE  PROCEDURE `sp_nuevo_productoestrella`( nombre VARCHAR(15),articulo VARCHAR (10) )
BEGIN 
INSERT INTO productosestrella VALUES ( nombre, articulo); 
END$$

CREATE  PROCEDURE `sp_nuevo_recetaspizza`(articulo VARCHAR(10), ingrediente VARCHAR(4))
BEGIN
	INSERT INTO recetaspizzas
		VALUES (articulo,ingrediente);
	
END$$

CREATE  PROCEDURE `sp_nuevo_recetasventas`(fecha DATE,
                                          pedido DECIMAL(3,0),
                                          venta DECIMAL(3,0),
                                          ingrediente VARCHAR(4))
BEGIN
	INSERT INTO recetasventa
		VALUES (fecha,pedido,venta,ingrediente);
	
END$$

CREATE  PROCEDURE `sp_nuevo_regalo`(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(2), IN `limite` DECIMAL(2,0))
    NO SQL
insert into regalos
values(regalo, motivo,limite)$$

CREATE  PROCEDURE `sp_nuevo_scooter`(sco VARCHAR(6),anio DECIMAL(4,0))
begin

	INSERT INTO scooter (scooter,ano_scooters)
		VALUES(sco,anio);

end$$

CREATE  PROCEDURE `sp_nuevo_tipopedido`(IN `clase` VARCHAR(20), IN `incremen` DECIMAL(3,0), IN `min` DECIMAL(4,0))
    NO SQL
insert into tipospedidos values(clase,incremen,min)$$

DELIMITER ;

SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `abastecer` (`scooter`, `fecha_abastecer`, `costo_abastecer`) VALUES
('A1TEGU', '2014-05-15', '200'),
('A1TEGU', '2014-05-22', '360');


INSERT INTO `articulos` (`articulo`, `tamano`, `precio_articulo`) VALUES
('coca-cola', 'G', '40'),
('pepsi', 'G', '39'),
('pizza anch', 'G', '300'),
('pizza pep', 'G', '250'),
('pizza pina', 'G', '270');


INSERT INTO `clasearticulos` (`articulo`, `tipoArticulo`) VALUES
('coca-cola', 'C'),
('pepsi', 'C'),
('pizza anch', 'P'),
('pizza pep', 'P');


INSERT INTO `cliente` (`cliente`, `nombre_cliente`, `apellidos_clientes`, `direccion_cliente`, `telfono_cliente`, `consumo_pizza`, `consumo_bocadillos`, `consumo_complementos`) VALUES
('99999', 'oscar', 'paz', 'santa', '22334455', '0', '0', '2');


INSERT INTO `ingredientes` (`ingrediente`, `nombre_ingrediente`) VALUES
('A1', 'Anchoas'),
('A3', 'Hongos'),
('A5', 'Queso'),
('A2', 'Tocino');


INSERT INTO `obsequiosc` (`regalo`, `motivo`, `cliente`, `fecha_obsequio`) VALUES
('4000', 'P', '99999', '2014-04-17');


INSERT INTO `pedidos` (`fecha_pedidos`, `pedido`, `clase_pedido`, `total_pedido`, `cliente`, `dni_repartidor`, `valor_receta`, `incremento`) VALUES
('0000-00-00', '1', 'domicilio', '250', '99999', '080119898', '20', '10');


INSERT INTO `pizzas` (`articulo`, `tamano`, `precio_ingrediente`) VALUES
('pizza pep', 'G', '250'),
('pizza pina', 'G', '250');


INSERT INTO `pizzasbase` (`articulo`, `ingrediente`) VALUES
('pizza pep', 'A1'),
('pizza pep', 'A5');


INSERT INTO `productosestrella` (`nombre_comercial`, `articulo`) VALUES
('Cola negra', 'coca-cola'),
('Cola Black2', 'pepsi'),
('suprema ', 'pizza pep');


INSERT INTO `recetaestrella` (`nombre_comercial`, `ingrediente`) VALUES
('suprema ', 'A3');


INSERT INTO `recetaspizzas` (`articulo`, `ingrediente`) VALUES
('pizza pep', 'A1'),
('pizza pep', 'A5');


INSERT INTO `regalos` (`regalo`, `motivo`, `limite`) VALUES
('3000', 'P', '30'),
('4000', 'P', '20');


INSERT INTO `repartidores` (`dni_repartidor`, `nombre_completo_repartidor`, `scooter`) VALUES
('080119898', 'Edgar Fabricio Funez', 'A1TEGU');


INSERT INTO `scooter` (`scooter`, `ano_scooters`) VALUES
('A1TEGU', '1990'),
('A2COMA', '1992'),
('A3SIGU', '2000');


INSERT INTO `tipospedidos` (`clase_pedidos`, `incremento`, `minimo`) VALUES
('De encargo', '50', '30'),
('domicilio', '100', '80');


SET FOREIGN_KEY_CHECKS = 1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;