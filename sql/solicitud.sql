drop table if exists persona;

CREATE TABLE `persona` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombres` VARCHAR(100) NOT NULL,
  `apellido_materno` VARCHAR(100) DEFAULT NULL,
  `apellido_paterno` VARCHAR(100) DEFAULT NULL,
  `fecha_nacimiento` DATE DEFAULT NULL,
  `genero` VARCHAR(1) DEFAULT NULL,
  `tipo` SMALLINT(6) DEFAULT NULL,
  `curp` VARCHAR(50) DEFAULT NULL,
  `rfc` VARCHAR(50) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `telefono` VARCHAR(15) DEFAULT NULL,
  `cargo` VARCHAR(200) DEFAULT NULL,
  `empresa` VARCHAR(200) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `created_by` SMALLINT UNSIGNED DEFAULT NULL,
  `updated_by` SMALLINT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES `user`(`id`) ON DELETE
  SET
    NULL,
    FOREIGN KEY (`updated_by`) REFERENCES `user`(`id`) ON DELETE
  SET
    NULL
);
-- Consulta completa de persona con dirección
DROP VIEW IF EXISTS view_solicitante;
CREATE VIEW view_solicitante AS
SELECT 
    p.id,
    p.nombres,
    p.apellido_paterno,
    p.apellido_materno,
    CONCAT_WS(' ', p.nombres, p.apellido_paterno, p.apellido_materno) as nombre_completo,
   
    p.email,
    p.telefono,
    p.cargo,
    p.empresa,
    p.created_at as fecha_creacion,
    -- Datos de dirección
    ed.direccion,
    ed.num_ext,
    ed.num_int,
    -- Estado y municipio
    estado.singular as estado,
    municipio.singular as municipio,
    -- Código postal y colonia de la tabla relacionada
    ecp.codigo_postal as codigo_postal,
    ecp.colonia as colonia_cp
FROM persona as p
LEFT JOIN esys_direccion as ed ON (ed.cuenta_id = p.id AND ed.cuenta = 4 AND ed.tipo = 1)
LEFT JOIN esys_lista_desplegable as estado ON (estado.id_2 = ed.estado_id AND estado.label = 'crm_estado')
LEFT JOIN esys_lista_desplegable as municipio ON (municipio.id_2 = ed.municipio_id AND municipio.param1 = ed.estado_id AND municipio.label = 'crm_municipio')
LEFT JOIN esys_direccion_codigo_postal as ecp ON ecp.id = ed.codigo_postal_id;


