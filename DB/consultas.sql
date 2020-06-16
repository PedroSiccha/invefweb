SELECT * FROM model_has_permissions;
SELECT * FROM model_has_roles;
-- role_id / model_type / model_id
-- 2 / App\User / 1
-- 1 / App\User / 2
SELECT * FROM role_has_permissions;
-- permission_id / role_id
-- 1 / 1
-- 2 / 1
-- 3 / 1
-- 4 / 1
-- 5 / 1
-- 2 / 2
-- 5 / 2

SELECT * FROM permissions;
-- id / name / guard_name
-- 1 / cartera / web
-- 2 / cliente / web
-- 3 / perfilCliente / web
-- 4 / desembolso / web
-- 5 / pago / web

SELECT * FROM roles;
-- id / name / guard_name
-- 1 / Admin / web
-- 2 / Editor / web
SELECT * FROM users;
-- id / name
-- 1 / editor
-- 2 / admin

-- Editor: 2, 5users

select `roles`.*, `model_has_roles`.`model_id` as `pivot_model_id`, `model_has_roles`.`role_id` as `pivot_role_id`, `model_has_roles`.`model_type` as `pivot_model_type` from `roles` inner join `model_has_roles` on `roles`.`id` = `model_has_roles`.`role_id` where `model_has_roles`.`model_id` = 1 and `model_has_roles`.`model_type` = "App\User";


SELECT * FROM cliente;
SELECT * FROM departamento;
SELECT * FROM provincia;

SELECT * FROM provincia WHERE departamento_id ="1";
SELECT * FROM distrito;

SELECT p.id, p.monto, p.fecinicio, p.fecfin, p.total, g.nombre AS garantia, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, cl.correo, dr.direccion, cl.fecnac, cl.edad, cl.genero, cl.foto, cl.facebook, cl.ingmax, cl.ingmin, cl.gasmax, cl.gasmin, o.nombre AS ocupacion, r.recomendacion AS recomendacion , cl.whatsapp 
FROM cliente cl 
INNER JOIN ocupacion o ON cl.ocupacion_id = o.id 
INNER JOIN recomendacion r ON cl.recomendacion_id = r.id 
INNER JOIN direccion dr ON cl.direccion_id = dr.id 
LEFT JOIN cotizacion c ON c.cliente_id = cl.id 
LEFT JOIN garantia g ON c.garantia_id = g.id 
LEFT JOIN prestamo p ON p.cotizacion_id = c.id;


SELECT c.id as cliente_id, c.nombre, c.apellido, c.dni, c.correo, dr.direccion, c.fecnac, c.edad, c.genero, c.foto, c.facebook, c.ingmax, c.ingmin, c.gasmax, c.gasmin, c.created_at, o.nombre AS ocupacion, r.recomendacion AS recomendacion, c.evaluacion AS evaluacion, c.telefono, c.whatsapp, c.referencia 
FROM cliente c, ocupacion o, recomendacion r, direccion dr
WHERE c.ocupacion_id = o.id AND c.recomendacion_id = r.id AND c.direccion_id = dr.id AND c.id = "1";

SELECT * FROM tipogarantia;

SELECT * FROM tipogarantia WHERE detalle != "tj";

SELECT * FROM caja;
SELECT MAX(id) AS id FROM caja;

SELECT id FROM caja WHERE estado = "ABIERTA" AND id = "3";
SELECT * FROM empleado;
SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion,
	   tdi.nombre AS tipoDocumento,
       d.direccion,
       di.distrito,
       p.provincia,
       de.departamento,
       t.turno, t.detalle AS detalleTurno,
       pl.fecinicio AS inicioPlanilla, pl.fecfin AS finPlanilla, pl.monto AS montoPlanilla
FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia p, departamento de, turno t, planilla pl
WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = pl.id;


SELECT * FROM prestamo;

SELECT p.id AS prestamo_id, p.monto AS montoPrestamo, p.fecinicio, p.fecfin, p.total, p.caja_id
FROM empleado e, prestamo p
WHERE p.empleado_id = e.id;
SELECT * FROM cotizacion;
SELECT c.id AS cotizacion_id, c.max, c.min, c.estado, c.precio,  
	   cl.nombre, cl.apellido,
       g.nombre AS garantia, g.detalle AS detalleGarantia, 
       tp.nombre AS tipoPrestamo
FROM cotizacion c, cliente cl, garantia g, tipoprestamo tp
WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id;

SELECT * FROM caja;

SELECT p.id, p.monto, p.fecinicio, p.fecfin, p.total, g.nombre AS garantia, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, cl.correo, dr.direccion, cl.fecnac, cl.edad, cl.genero, cl.foto, cl.facebook, cl.ingmax, cl.ingmin, cl.gasmax, cl.gasmin, o.nombre AS ocupacion, r.recomendacion AS recomendacion , cl.whatsapp 
                                 FROM cliente cl 
                                 INNER JOIN ocupacion o ON cl.ocupacion_id = o.id 
                                 INNER JOIN recomendacion r ON cl.recomendacion_id = r.id 
                                 INNER JOIN direccion dr ON cl.direccion_id = dr.id 
                                 LEFT JOIN cotizacion c ON c.cliente_id = cl.id 
                                 LEFT JOIN garantia g ON c.garantia_id = g.id 
                                 LEFT JOIN prestamo p ON p.cotizacion_id = c.id;
                                 
SELECT * FROM cliente;

SELECT c.id as cliente_id, c.nombre, c.apellido, c.dni, c.correo, dr.direccion, c.fecnac, c.edad, c.genero, c.foto, c.facebook, c.ingmax, c.ingmin, c.gasmax, c.gasmin, c.created_at, o.nombre AS ocupacion, r.recomendacion AS recomendacion, c.evaluacion AS evaluacion, c.telefono, c.whatsapp, c.referencia 
                                FROM cliente c, ocupacion o, recomendacion r, direccion dr
                                WHERE c.ocupacion_id = o.id AND c.recomendacion_id = r.id AND c.direccion_id = dr.id AND c.id = "2";
                                
SELECT COUNT(c.id) AS cantCotizacion 
                                       FROM cotizacion c, cliente cl 
                                       WHERE cl.id = "2";
                                       
SELECT COUNT(c.id) AS cantCotizacion 
                                         FROM cotizacion c, cliente cl 
                                         WHERE c.estado = "0" AND cl.id = "2";

SELECT * FROM cotizacion;

SELECT COUNT(p.id) AS catPrestamo 
                                     FROM prestamo p, cotizacion c 
                                     WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$id.'";
                                     
SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.created_at, g.nombre 
                                 FROM prestamo p, cotizacion c, garantia g 
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND c.cliente_id = "2";
                                 
SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia
                                   FROM cotizacion c, tipoprestamo tp, garantia g
                                   WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "1" AND c.cliente_id = "2";
                                   
SELECT * FROM tipogarantia WHERE detalle != "tj";

SELECT * FROM tipogarantia;

SELECT * FROM tipoprestamo;



INSERT INTO `tipogarantia` VALUES (1,'Laptop',NULL,NULL,'1500','100','tp',NULL),(2,'Celular',NULL,NULL,'1000','100','tp',NULL),(3,'Televisor',NULL,NULL,'1200','100','tp',NULL),(4,'Equipo de Sonido',NULL,NULL,'1000','100','tp',NULL),(5,'Oro',NULL,NULL,'159.04','158.54','tj','24K'),(6,'Oro',NULL,NULL,'146.32','145.86','tj','22K'),(7,'Oro',NULL,NULL,'143.09','142.69','tj','21.6K'),(8,'Oro',NULL,NULL,'119.24','118.91','tj','18K'),(9,'Oro',NULL,NULL,'92.21','91.95','tj','14K'),(10,'Oro',NULL,NULL,'79.53','79.27','tj','12K'),(11,'Oro',NULL,NULL,'66.80','66.59','tj','10K'),(12,'Oro',NULL,NULL,'60.44','60.25','tj','9K'),(13,'Oro',NULL,NULL,'52.49','52.32','tj','8K'),(14,'Plata',NULL,NULL,'1.82',NULL,'tj','99,9K'),(15,'Plata',NULL,NULL,'1.74',NULL,'tj','95,8K'),(16,'Plata',NULL,NULL,'1.68',NULL,'tj','92,5K'),(17,'Plata',NULL,NULL,'1.64',NULL,'tj','90K'),(18,'Plata',NULL,NULL,'1.46',NULL,'tj','80K');

INSERT INTO `tipoprestamo` VALUES (1,'Credito Prendario',NULL,NULL,NULL,NULL),(2,'Credito Joyas',NULL,NULL,NULL,NULL),(3,'Credito Universitario',NULL,NULL,NULL,NULL);

SELECT * FROM almacen;

SELECT a.id AS almacen_id, CONCAT(d.direccion," - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, COUNT(s.id) AS cantstand, COUNT(c.id) AS cantcasillero
FROM almacen a
LEFT JOIN stand s ON s.almacen_id = a.id
LEFT JOIN casillero c ON c.stand_id = s.id
INNER JOIN direccion d ON a.direccion_id = d.id
INNER JOIN distrito di ON d.distrito_id = di.id
INNER JOIN provincia p ON di.provincia_id = p.id
INNER JOIN departamento de ON p.departamento_id = de.id
GROUP BY a.id;

SELECT a.id AS almacen_id, a.direccion, count(s.id) AS cantstand, count(c.id) AS cantcasillero
                                FROM almacen a
                                LEFT JOIN stand s ON s.Almacen_id = a.id
                                LEFT JOIN casillero c ON c.Stand_id = s.id
                                group by a.id;
                                
SELECT * FROM cliente a;

SELECT * FROM stand s, almacen a WHERE s.almacen_id = a.id AND s.estado = "LIBRE";

SELECT * FROM stand;

SELECT * FROM casillero WHERE estado = "LIBRE" AND stand_id ="'.$id.'";

SELECT * FROM casillero WHERE estado = "libre" AND stand_id = "1";

SELECT * FROM cotizacion;
SELECT * FROM garantia_casillero;
SELECT * FROM casillero;

SELECT * FROM garantia_casillero;

SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                         FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                         WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "2";
                                         
SELECT * FROM casillero c, garantia_casillero gc WHERE gc.casillero_id = gc.id AND gc.estado = "LIBRE";

SELECT * FROM cotizacion;
INNER JOIN garantia_casillero gc ON gc.casillero_id = gc.id
right JOIN garantia g ON gc.garantia_id = g.id;

SELECT * FROM garantia_casillero gc
RIGHT JOIN casillero c ON gc.casillero_id = c.id
;
SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia
                                                           FROM cotizacion c, tipoprestamo tp, garantia g
                                                           WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PRESTAMO" AND c.cliente_id = "2";
                                                           
SELECT c.id, c.nombre, c.apellido, c.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, c.evaluacion 
FROM cliente c, cotizacion co, direccion d, distrito di, provincia p, departamento de 
WHERE co.cliente_id = c.id AND c.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id AND co.id = "10";

SELECT * FROM cotizacion;
SELECT ca.nombre AS casillero, s.nombre AS stand, a.nombre AS almacen FROM garantia_casillero gc
INNER JOIN garantia g ON gc.garantia_id = g.id
INNER JOIN cotizacion c ON c.garantia_id = g.id
INNER JOIN casillero ca ON gc.casillero_id = ca.id
INNER JOIN stand s ON ca.stand_id = s.id
INNER JOIN almacen a ON s.almacen_id = a.id
WHERE c.id = "1";
SELECT * FROM cotizacion;
SELECT * FROM tipoprestamo;
SELECT * FROm tipocredito_interes;

SELECT i.* FROM tipocredito_interes ti
INNER JOIN interes i ON ti.interes_id = i.id
INNER JOIN tipoprestamo t ON ti.tipocredito_id = t.id
INNER JOIN cotizacion c ON c.tipoprestamo_id = t.id
WHERE c.id = "1";

SELECT * FROM mora m WHERE m.max BETWEEN "100" AND "0";
SELECT * FROM mora WHERE max > 50 AND max < 100;

SELECT id FROM tipocredito_interes WHERE interes_id = "1";

SELECT * FROM caja;

SELECT * FROM prestamo;

SELECT MAX(id) AS id FROM caja WHERE estado = "abierta";

SELECT cl.nombre, cl.apellido, cl.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", pr.provincia, " - ", de.departamento) AS direccion, p.monto, p.fecfin, p.total, g.nombre AS garantia, g.detalle AS detgarantia, m.mora AS mora
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, direccion d, distrito di, provincia pr, departamento de
                                 WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.cotizacion_id = c.id AND cl.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND p.id = "1";
                                 
                                 SELECT p.id AS prestamo_id, g.id AS garantia_id, g.nombre AS garantia, g.detalle AS detgarantia, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS casillero
                                 FROM garantia g, cotizacion c, prestamo p, casillero ca, stand s, almacen a, garantia_casillero ga
                                 WHERE c.garantia_id = g.id AND p.cotizacion_id = c.id AND ga.garantia_id = g.id AND ga.casillero_id = ca.id AND ca.Stand_id = s.id AND s.Almacen_id = a.id;
                                 
SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.fecfin, p.total, p.monto, m.mora AS mora
                              FROM prestamo p, cotizacion c, cliente cl, mora m 
                              WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.mora_id = m.id AND p.macro = "SIN MACRO" AND p.estado = "ACTIVO";
                              
SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, cl.id AS cliente_id, p.fecinicio
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id;
                                 
SELECT * FROM desembolso;
SELECT * FROM prestamo;

SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at  FROM prestamo p, cotizacion c, cliente cl
WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id;

SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, ca.nombre, ca.estado  
                                  FROM prestamo p, cotizacion c, garantia g, casillero ca, garantia_casillero gc 
                                  WHERE gc.garantia_id = g.id AND gc.casillero_id = c.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id;
                                  
SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
FROM garantia_casillero gc
RIGHT JOIN casillero c ON gc.casillero_id = c.id
LEFT JOIN garantia g ON gc.garantia_id = g.id
LEFT JOIN cotizacion co ON co.garantia_id = g.id
LEFT JOIN prestamo p ON p.cotizacion_id = co.id
INNER JOIN stand s ON c.stand_id = s.id
INNER JOIN almacen a ON s.almacen_id = a.id;

SELECT * FROM casillero;
                                  
SELECT * FROM garantia_casillero;

SELECT a.id AS almacen_id, a.nombre, a.estado, CONCAT(d.direccion, " - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion 
FROM almacen a, direccion d, distrito di, provincia p, departamento de, stand s
WHERE a.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id;

SELECT * FROM empleado;
SELECT * FROM users;

SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, 
	   tdi.nombre AS tipoDocumento,
       d.direccion, di.distrito, pr.provincia, de.departamento,
       t.turno, t.detalle, t.horainicio, t.horafin,
       p.fecinicio, p.fecfin, p.monto,
       u.name, u.email
FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia pr, departamento de, turno t, planilla p, users u
WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = p.id AND e.users_id = u.id;

SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO";
                                 
SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO";
                                 
SELECT id, CONCAT("Pago al prestamo: ", prestamo_id) AS detalle, created_at, empleado_id FROM pago WHERE caja_id = "1";

SELECT * FROM prestamo;

SELECT id, CONCAT("Desembolso al préstamo: ", id) AS detalle, created_at, monto, empleado_id
FROM prestamo
WHERE caja_id = "4";

SELECT * FROM caja;

SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.created_at, g.nombre 
                                 FROM prestamo p, cotizacion c, garantia g 
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND c.cliente_id = "2";
                                 
SELECT * FROM casillero WHERE stand_id = "1";

SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                    FROM garantia_casillero gc
                                    RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                    LEFT JOIN garantia g ON gc.garantia_id = g.id
                                    LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                    LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                    INNER JOIN stand s ON c.stand_id = s.id
                                    INNER JOIN almacen a ON s.almacen_id = a.id
                                    WHERE stand_id = "1";
                                    
SELECT * FROM stand;
SELECT * FROM casillero;
