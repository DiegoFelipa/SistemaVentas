/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.27-MariaDB : Database - sistemasventas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sistemasventas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sistemasventas`;

/*Table structure for table `inventario` */

DROP TABLE IF EXISTS `inventario`;

CREATE TABLE `inventario` (
  `idinventario` int(11) NOT NULL AUTO_INCREMENT,
  `nombreproducto` varchar(50) NOT NULL,
  `precio` varchar(50) NOT NULL,
  `precioigv` varchar(50) NOT NULL,
  `codigobarra` varchar(70) NOT NULL,
  `stock` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idinventario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `inventario` */

insert  into `inventario`(`idinventario`,`nombreproducto`,`precio`,`precioigv`,`codigobarra`,`stock`,`tipo`,`fecharegistro`,`estado`) values 
(1,'Tasas','12','15','arfecas-123','10','P','2023-11-30 12:14:39','0'),
(2,'Silla','100','120','arfecas-1234','40','P','2023-11-30 12:14:51','1'),
(3,'Platos','84','86','arfecas-12345','5','S','2023-11-30 12:15:58','1');

/*Table structure for table `ventas` */

DROP TABLE IF EXISTS `ventas`;

CREATE TABLE `ventas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `nombreproducto` varchar(100) NOT NULL,
  `cantidad` varchar(50) NOT NULL,
  `totalpagar` varchar(50) NOT NULL,
  `tipopago` varchar(20) NOT NULL,
  `tipocomprobante` varchar(20) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ventas` */

/* Procedure structure for procedure `spu_inventario_actualizar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_inventario_actualizar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_inventario_actualizar`(
				IN _idinventario	INT,
				IN _nombreproducto	VARCHAR(50),
				IN _precio		VARCHAR(50),
				IN _precioigv		VARCHAR(50),
				IN _codigobarra		VARCHAR(50),
				IN _stock		VARCHAR(50),
				IN _tipo		VARCHAR(50)
			)
BEGIN
				UPDATE inventario SET
					nombreproducto	= _nombreproducto,	
					precio		= _precio,		
					precioigv	= _precioigv,		
					codigobarra	= _codigobarra,		
					stock		= _stock,		
					tipo		= _tipo
				WHERE idinventario = _idinventario;
			END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_inventario_eliminar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_inventario_eliminar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_inventario_eliminar`(
				IN _idinventario INT
			)
BEGIN
				UPDATE inventario
					SET estado = '0'
				WHERE idinventario = _idinventario;
			END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_inventario_listar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_inventario_listar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_inventario_listar`()
BEGIN
				SELECT
				  idinventario,
				  nombreproducto,
				  precio,
				  precioigv,
				  codigobarra,
				  stock,
				  tipo,
				  CASE
				    WHEN estado = '1' THEN 'Activo'
				    ELSE 'Inactivo'
				  END AS estado
				FROM
				  inventario;
		END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_inventario_obtener` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_inventario_obtener` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_inventario_obtener`(
				IN _idinventario INT
			)
BEGIN
				SELECT idinventario, nombreproducto,precio,precioigv,codigobarra,stock,tipo
				FROM inventario
				WHERE estado = '1' AND idinventario = _idinventario;
			END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_inventario_registrar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_inventario_registrar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_inventario_registrar`(
				IN _nombreproducto	VARCHAR(50),
				IN _precio		VARCHAR(50),
				IN _precioigv		VARCHAR(50),
				IN _codigobarra		VARCHAR(50),
				IN _stock		VARCHAR(50),
				IN _tipo		VARCHAR(50)
			)
BEGIN
				INSERT INTO inventario(nombreproducto,precio,precioigv,codigobarra,stock,tipo)
					VALUES (_nombreproducto,_precio,_precioigv,_codigobarra,_stock,_tipo);
			END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
