DELIMITER $$

CREATE  PROCEDURE `sp_actualiza_cliente`(IN `id` DECIMAL(5,0), IN `nombre` VARCHAR(20), IN `apellido` VARCHAR(40), IN `direccion` VARCHAR(30), IN `telefono` DECIMAL(9,0), IN `pizza` DECIMAL(3,0), IN `bocadillo` DECIMAL(3,0), IN `complemento` DECIMAL(3,0))
update cliente set nombre_cliente=nombre, apellidos_clientes=apellido, direccion_cliente=direccion, telfono_cliente=telefono, consumo_pizza=pizza, consumo_bocadillos=bocadillo, consumo_complementos=complemento
where cliente=id$$

CREATE  PROCEDURE `sp_actualiza_cliente_obesquio`(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(1), IN `cliente` DECIMAL(5,0), IN `fecha` DATE)
    NO SQL
update obsequioc set motivo = motivo, cliente=cliente, fecha=fecha
where regalo=regalo$$

CREATE  PROCEDURE `sp_actualiza_pedido`(IN `clase` VARCHAR(20), IN `incremento` DECIMAL(5,0), IN `min` DECIMAL(4,0))
    NO SQL
update tipospedidos set clase_pedidos=clase, incremento=incremento, minimo=min where clase_pedidos=clase$$

CREATE  PROCEDURE `sp_actualiza_pedido1`(IN `fecha` DATE, IN `pedido` DECIMAL(3,0), IN `clase` VARCHAR(20), IN `total` DECIMAL(4,0), IN `cliente` DECIMAL(5,0), IN `dni` VARCHAR(9), IN `valor` DECIMAL(4,0), IN `incremento` DECIMAL(3,0))
    NO SQL
update pedidos set fecha_pedidos=fecha, pedido=pedido, clase_pedido=clase,total_pedido=total, cliente=cliente, dni_repatidor=dni, valor_receta=valor, incremento=incremento
where fecha_pedidos=fecha$$

CREATE  PROCEDURE `sp_actualiza_regalo`(IN `regalo1` DECIMAL(4,0), IN `motivo` CHAR(2), IN `limite` DECIMAL(2,0))
    NO SQL
update regalos set motivo=motivo, limite=limite
where regalo=regalo1$$

CREATE  PROCEDURE `sp_elimina_cliente`(IN `clienteid` DECIMAL(5,0))
delete from cliente where cliente = clienteid$$

CREATE  PROCEDURE `sp_elimina_cliente_obsequio`(IN `regalo1` DECIMAL(4,0))
    NO SQL
delete from obsequiosc where regalo=regalo1$$

CREATE  PROCEDURE `sp_elimina_pedido`(IN `clase` VARCHAR(20))
    NO SQL
delete from tipospedidos where clase_pedidos=clase$$

CREATE  PROCEDURE `sp_elimina_pedido1`(IN `fecha1` DATE)
    NO SQL
delete from pedidos where fecha=fecha1$$

CREATE  PROCEDURE `sp_elimina_regalo`(IN `regalo1` DECIMAL(4,0))
    NO SQL
delete from regalos where regalo=regalo1$$

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

CREATE  PROCEDURE `sp_get_regalo`()
    NO SQL
SELECT re.regalo as "REGALO", re.motivo as "MOTIVO", re.limite as "LIMITE" FROM regalos as re ORDER BY re.regalo ASC$$

CREATE  PROCEDURE `sp_get_tipopedido`()
    NO SQL
select tp.clase_pedidos as "CLASE", tp.incremento as "INCREMENTO", tp.minimo as "MINIMO"
from tipospedidos as tp order by tp.clase_pedidos ASC$$

CREATE  PROCEDURE `sp_nuevo_cliente`(IN `id` DECIMAL(5,0), IN `nombre` VARCHAR(20), IN `apellido` VARCHAR(40), IN `direccion` VARCHAR(30), IN `telefono` DECIMAL(9,0), IN `pizza` DECIMAL(3,0), IN `bocadillo` DECIMAL(3,0), IN `complemento` DECIMAL(3,0))
    NO SQL
insert into cliente values (id,nombre,apellido,direccion,telefono,pizza,bocadillo, complemento)$$

CREATE  PROCEDURE `sp_nuevo_cliente_obsequio`(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(1), IN `cliente` DECIMAL(5,0), IN `fecha` DATE)
    NO SQL
insert into obsequiosc values (regalo,motivo,cliente,fecha)$$

CREATE  PROCEDURE `sp_nuevo_pedido1`(IN `fecha` DATE, IN `pedido` DECIMAL(3,0), IN `clase` VARCHAR(20), IN `total` DECIMAL(4,0), IN `cliente` DECIMAL(5,0), IN `dni` VARCHAR(9), IN `valor` DECIMAL(4,0), IN `incremento` DECIMAL(3,0))
    NO SQL
insert into pedidos values (fecha,pedido,clase,total,cliente,dni,valor,incremento)$$

CREATE  PROCEDURE `sp_nuevo_regalo`(IN `regalo` DECIMAL(4,0), IN `motivo` CHAR(2), IN `limite` DECIMAL(2,0))
    NO SQL
insert into regalos
values(regalo, motivo,limite)$$

CREATE  PROCEDURE `sp_nuevo_tipopedido`(IN `clase` VARCHAR(20), IN `incremen` DECIMAL(3,0), IN `min` DECIMAL(4,0))
    NO SQL
insert into tipospedidos values(clase,incremen,min)$$

DELIMITER ;