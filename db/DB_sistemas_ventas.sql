-- 1) Crear la BD:
	CREATE DATABASE SistemasVentas;
	USE SistemasVentas;
-- 2) Tabla N°1:
	-- tb inventario:
		CREATE TABLE inventario(
			idinventario 	INT AUTO_INCREMENT PRIMARY KEY,
			nombreproducto	VARCHAR(50) NOT NULL,
			precio		VARCHAR(50) NOT NULL,
			precioigv	VARCHAR(50) NOT NULL,
			codigobarra	VARCHAR(70) NOT NULL,
			stock		VARCHAR(50) NOT NULL,
			tipo		VARCHAR(50) NOT NULL,
			fecharegistro	DATETIME NOT NULL DEFAULT NOW(),
			estado		CHAR(1) NOT NULL DEFAULT '1'
		)ENGINE=INNODB;
		
	-- tb ventas
		CREATE TABLE ventas(
			idventa		INT AUTO_INCREMENT PRIMARY KEY,
			nombreproducto	VARCHAR(100) NOT NULL,
			cantidad	VARCHAR(50) NOT NULL,
			totalpagar	VARCHAR(50) NOT NULL,
			tipopago	VARCHAR(20) NOT NULL,
			tipocomprobante	VARCHAR(20) NOT NULL,
			cliente		VARCHAR(50) NOT NULL,
			fecharegistro	DATETIME NOT NULL DEFAULT NOW()	
		)ENGINE =INNODB;
		
-- 3) Insertamos datos a las tablas
	-- tb inventario:
		INSERT INTO inventario(nombreproducto,precio,precioigv,codigobarra,stock,tipo)VALUES
				('Tasas','12','15','arfecas-123','10','P');
				SELECT * FROM inventario;
-- 4) Creamos los Procedimientos Almacenados
	-- MÓDULO DE INVENTARIO:
		-- SPU Listar Inventario/P&S
		DELIMITER $$
			CREATE PROCEDURE spu_inventario_listar()
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
		END $$
		-- SPU Registrar Inventario/P&S
			DELIMITER $$
			CREATE PROCEDURE spu_inventario_registrar
			(
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
			END $$
			
			CALL spu_inventario_registrar('Silla','100','120','arfecas-1234','40','P');
		-- SPU Eliminar Inventario/P&S
			DELIMITER $$
			CREATE PROCEDURE spu_inventario_eliminar
			(
				IN _idinventario INT
			)
			BEGIN
				UPDATE inventario
					SET estado = '0'
				WHERE idinventario = _idinventario;
			END $$
		-- SPU Obtener Inventario/P&S
			DELIMITER $$
			CREATE PROCEDURE spu_inventario_obtener
			(
				IN _idinventario INT
			)
			BEGIN
				SELECT idinventario, nombreproducto,precio,precioigv,codigobarra,stock,tipo
				FROM inventario
				WHERE estado = '1' AND idinventario = _idinventario;
			END $$
		-- SPU Actualizar Inventario/P&S
			DELIMITER $$
			CREATE PROCEDURE spu_inventario_actualizar
			(
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
			END $$