SELECT * FROM almacen;

INSERT INTO `caja` VALUES (4,'abierta',19000.00,'0000-00-00','03:49:46',NULL,'2019-12-10 08:49:46','2019-12-10 08:49:46',NULL,1);


INSERT INTO `cotizacion` VALUES (1,750.00,100.00,'FINAL',NULL,'2019-12-13 09:54:47','2019-12-13 22:39:20',2,1,1,1),(3,450.00,100.00,'FINAL',NULL,'2019-12-13 21:12:42','2019-12-17 08:37:53',2,1,7,1),(4,300.00,100.00,'PRESTAMO',NULL,'2019-12-13 21:15:15','2019-12-13 21:15:15',2,1,8,1),(5,450.00,100.00,'PRESTAMO',NULL,'2019-12-13 21:15:47','2019-12-13 21:15:47',2,1,9,1),(6,450.00,100.00,'PRESTAMO',NULL,'2019-12-13 21:19:03','2019-12-13 21:19:03',2,1,10,1),(7,1500.00,100.00,'PRESTAMO',NULL,'2019-12-13 21:23:05','2019-12-13 21:23:05',2,1,11,1),(8,750.00,100.00,'PRESTAMO',NULL,'2019-12-13 21:27:16','2019-12-13 21:27:16',2,1,12,1),(9,450.00,100.00,'PRESTAMO',NULL,'2019-12-13 21:28:49','2019-12-13 21:28:49',2,1,13,1),(10,450.00,100.00,'PRESTAMO',NULL,'2019-12-13 21:31:21','2019-12-13 21:31:21',2,1,14,1);

INSERT INTO `desembolso` VALUES (1,1,'DESEMBOLSADO',750.00,'2019-12-13 23:37:12','2019-12-13 23:37:12',1,1),(2,2,'DESEMBOLSADO',750.00,'2019-12-13 23:37:39','2019-12-13 23:37:39',1,1);



INSERT INTO `garantia` VALUES (1,'Lap','Todo Bien','ACTIVO','2019-12-13 09:54:46','2019-12-13 09:54:46',1),(7,'asasas','asasas','ACTIVO','2019-12-13 21:12:41','2019-12-13 21:12:41',1),(8,'aaaa','aaa','ACTIVO','2019-12-13 21:15:14','2019-12-13 21:15:14',3),(9,'bbbb','bbbb','ACTIVO','2019-12-13 21:15:47','2019-12-13 21:15:47',3),(10,'cccc','cccc','ACTIVO','2019-12-13 21:19:02','2019-12-13 21:19:02',4),(11,'dddd','dddd','ACTIVO','2019-12-13 21:23:05','2019-12-13 21:23:05',1),(12,'eeee','eeee','ACTIVO','2019-12-13 21:27:16','2019-12-13 21:27:16',1),(13,'fff','fff','ACTIVO','2019-12-13 21:28:49','2019-12-13 21:28:49',1),(14,'ggg','ggg','ACTIVO','2019-12-13 21:31:21','2019-12-13 21:31:21',1);
INSERT INTO `garantia_casillero` VALUES (1,NULL,'OCUPADO','2019-12-13 09:54:46','2019-12-13 09:54:46',1,1),(7,NULL,'OCUPADO','2019-12-13 21:12:41','2019-12-13 21:12:41',7,1),(8,NULL,'OCUPADO','2019-12-13 21:15:15','2019-12-13 21:15:15',8,2),(9,NULL,'OCUPADO','2019-12-13 21:15:47','2019-12-13 21:15:47',9,3),(10,NULL,'OCUPADO','2019-12-13 21:19:03','2019-12-13 21:19:03',10,5),(11,NULL,'OCUPADO','2019-12-13 21:23:05','2019-12-13 21:23:05',11,6),(12,NULL,'OCUPADO','2019-12-13 21:27:16','2019-12-13 21:27:16',12,7),(13,NULL,'OCUPADO','2019-12-13 21:28:49','2019-12-13 21:28:49',13,8),(14,NULL,'OCUPADO','2019-12-13 21:31:21','2019-12-13 21:31:21',14,9);




INSERT INTO `pago` VALUES (2,42.18,200.00,157.83,0,'000','2019-12-20 09:39:04','2019-12-20 09:39:04',1,1,1,4),(3,475.81,500.00,24.19,0,'000','2019-12-20 09:40:01','2019-12-20 09:40:01',1,1,1,4);


INSERT INTO `prestamo` VALUES (1,-24.19,'2019-12-13','2020-01-12',-29.03,'SIN MACRO',150.00,'ACTIVO DESEMBOLSADO','2019-12-13 22:39:20','2019-12-20 09:40:01',1,1,3,1,4),(2,450.00,'2019-12-17','2020-01-16',540.00,'SIN MACRO',90.00,'ACTIVO','2019-12-17 08:37:53','2019-12-17 08:37:53',1,3,1,1,4);

SELECT * FROM prestamo;


SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar 
FROM prestamo p, cotizacion c, cliente cl, garantia g
WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24;

SELECT * FROM empleado;

SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.estado, e.valoracion FROM empleado e;

SELECT * FROM reuniones;
SELECT * FROM asistentes;
SELECT * FROM encargado;

SELECT * FROM sede;

SELECT * FROM pago;
SELECT * FROM recibe;
SELECT * FROM desembolso;
SELECT * FROM caja;
SELECT * FROM ingreso;
SELECT m.* FROM movimiento m, caja c WHERE m.caja_id = c.id AND m.tipo = "INGRESO" AND c.estado = "ABIERTA";
SELECT * FROM movimiento;
SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "1";
                                 
SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "1";
                                 
SELECT e.nombre, e.apellido, e.id, u.name AS area FROM empleado e, users u WHERE e.users_id = u.id AND u.id = "1";

SELECT * FROM users;

SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND fecfin >= CURDATE() AND fecinicio <= DATE_SUB(CURDATE(), INTERVAL 25 DAY);
SELECT * FROM prestamo;
SELECT * FROM prestamo WHERE fecfin >= CURDATE() AND fecinicio <= DATE_SUB(CURDATE(), INTERVAL 25 DAY);


SELECT curdate();






SELECT * FROM cotizacion;
SELECT * FROM garantia;
SELECT * FROM casillero;
SELECT * FROM garantia_casillero;
SELECT * FROM garantia_casillero gc, garantia g, casillero c
WHERE gc.garantia_id = g.id AND gc.casillero_id = c.id;

SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado AS estadoPrestamo, CONCAT(cl.nombre, " ", cl.apellido) AS cliente, cl.dni, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS almacen 
FROM prestamo p, cotizacion c, casillero ca, mora m, cliente cl, stand s, almacen a, garantia_casillero gc, garantia g 
WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND gc.casillero_id = ca.id AND gc.garantia_id = g.id AND c.garantia_id = g.id AND p.mora_id = m.id AND ca.Stand_id = s.id AND s.Almacen_id = a.id AND p.id = 13;

SELECT monto, fecinicio, fecfin, total, estado, cotizacion_id, casillero_id, interes_id, mora_id, macro, intpagar, morapagar
                               FROM prestamo WHERE id = "13";
SELECT * FROM tipocredito_interes;
                               
SELECT p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.cotizacion_id, ca.id AS casillero_id, i.id AS interes_id, p.mora_id, p.macro, p.intpagar 
FROM prestamo p, cotizacion c, garantia g, garantia_casillero gc, casillero ca, tipocredito_interes ti, interes i
WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND gc.casillero_id = ca.id AND gc.garantia_id = g.id AND p.tipocredito_interes_id = ti.id AND ti.interes_id = i.id AND p.id = "13";

SELECT * FROM prestamo;

SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado AS estadoPrestamo, CONCAT(cl.nombre, " ", cl.apellido) AS cliente, cl.dni, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS almacen 
                                 FROM prestamo p, cotizacion c, casillero ca, mora m, cliente cl, stand s, almacen a, garantia_casillero gc, garantia g 
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND gc.casillero_id = ca.id AND gc.garantia_id = g.id AND c.garantia_id = g.id AND p.mora_id = m.id AND ca.Stand_id = s.id AND s.Almacen_id = a.id AND p.id = "13";
                                 
                                 SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                        FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                        WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%");
                        
                        SELECT p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.cotizacion_id, ca.id AS casillero_id, i.id AS interes_id, p.mora_id, p.macro, p.intpagar 
                               FROM prestamo p, cotizacion c, garantia g, garantia_casillero gc, casillero ca, tipocredito_interes ti, interes i
                               WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND gc.casillero_id = ca.id AND gc.garantia_id = g.id AND p.tipocredito_interes_id = ti.id AND ti.interes_id = i.id AND p.id = "13";
                               
                               SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%");
                                 
                                 SELECT monto, fecinicio, fecfin, total, estado, cotizacion_id, casillero_id, interes_id, mora_id, macro, intpagar, morapagar
                               FROM prestamo WHERE id = "13";
                               
                               SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%");
                                 
SELECT * FROM prestamo;

SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id;
                                      
SELECT * FROM empleado;

-- Caja Salida
SELECT m.id AS prestamo_id, m.concepto, m.created_at, m.importe FROM movimiento m;

SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "ABIERTA";

SELECT * FROM caja WHERE ESTADO = "CERRADA";

SELECT * FROM movimiento WHERE caja_id = "6";

-- Por dias
SELECT * FROM movimiento WHERE caja_id = "6";

-- Por mes
 SELECT *, 'ENERO' AS mes FROM caja WHERE created_at BETWEEN '2020-01-01' AND '2020-01-31';
 SELECT *, 'FEBRERO' AS mes FROM caja WHERE created_at BETWEEN '2020-02-01' AND '2020-02-29';
 SELECT *, 'MARZO' AS mes FROM caja WHERE created_at BETWEEN '2020-03-01' AND '2020-03-31';
 SELECT *, 'ABRIL' AS mes FROM caja WHERE created_at BETWEEN '2020-04-01' AND '2020-04-30';
 SELECT *, 'MAYO' AS mes FROM caja WHERE created_at BETWEEN '2020-05-01' AND '2020-05-31';
 SELECT *, 'JUNIO' AS mes FROM caja WHERE created_at BETWEEN '2020-06-01' AND '2020-06-30';
 SELECT *, 'JULIO' AS mes FROM caja WHERE created_at BETWEEN '2020-07-01' AND '2020-07-31';
 SELECT *, 'AGOSTO' AS mes FROM caja WHERE created_at BETWEEN '2020-08-01' AND '2020-08-31';
 SELECT *, 'SEPTIEMBRE' AS mes FROM caja WHERE created_at BETWEEN '2020-09-01' AND '2020-09-30';
 SELECT *, 'OCTUBRE' AS mes FROM caja WHERE created_at BETWEEN '2020-10-01' AND '2020-10-31';
 SELECT *, 'NOVIEMBRE' AS mes FROM caja WHERE created_at BETWEEN '2020-11-01' AND '2020-11-30';
 SELECT *, 'DICIEMBRE' AS mes FROM caja WHERE created_at BETWEEN '2020-12-01' AND '2020-12-31';
 
 SELECT * FROM caja WHERE ESTADO = "CERRADA" AND created_at BETWEEN '2020-02-01' AND '2020-02-29';
 
 SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
                                  FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                  WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "CERRADA";
 SELECT * FROM caja;
 
 SELECT * FROM movimiento;
 
 
 SELECT SUM(monto) FROM caja WHERE created_at BETWEEN '2020-02-01' AND '2020-02-29';
 
 SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar
                                FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO"
                                ORDER BY p.fecfin ASC;
 SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total
                                         FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                         WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION";
 SELECT * FROM desembolso;
 SELECT * FROM prestamo;
 SELECT d.id AS desembolso, g.id AS garantia_id, g.nombre AS garantia 
 FROM prestamo p, desembolso d, cotizacion c, garantia g
 WHERE d.prestamo_id = P.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.id = "10";
 
 
 
 SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total
                                            FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                            WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION";
 
 SELECT count(*) AS cantidad, horario FROM asistencia GROUP BY Horario;
 
 SELECT d.id AS desembolso, g.id AS garantia_id, g.nombre AS garantia 
                                FROM prestamo p, desembolso d, cotizacion c, garantia g
                                WHERE d.prestamo_id = P.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.id = "21";
                                
SELECT * FROM prestamo WHERE estado = "VENDIDO";
 
 SELECT * FROM asistencia WHERE fecha between '2019-01-01' AND '2019-12-31';
 
 SELECT p.id AS prestamo_id, p.monto, p.intpagar*2 AS interes, mo.mora*15 AS mora, (p.monto + p.intpagar*2 + mo.mora*15) AS total, g.id AS garantia_id, g.nombre AS garantia, m.importe, (m.importe + mo.mora*15 + p.intpagar*2 - p.monto) AS balance, (m.importe - mo.mora*15 - p.intpagar*2 - p.monto) AS balanceAux
 FROM prestamo p, cotizacion c, garantia g, movimiento m, mora mo
 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = mo.id AND m.codprestamo = p.id AND p.estado = "VENDIDO" GROUP BY p.id;
 
 
 
 
 -- Reporte de personas que faltaron en un dia; Dia inicio, dia fin, porcentaje
 
 SELECT * FROM permiso;
 
SELECT "TOTAL" AS NOMBRE, COUNT(*) AS CANTIDAD, (COUNT(*)/COUNT(*))*100 AS Porcentaje FROM asistencia WHERE fecha between '2018-03-01' AND '2018-03-30' UNION
SELECT "FALTA" AS NOMBRE, COUNT(*) AS CANTIDAD, (COUNT(*)/COUNT(*))*100 AS Porcentaje FROM asistencia WHERE Falta = "TRUE" AND fecha between '2018-03-01' AND '2018-03-30' UNION
SELECT "TARDE" AS NOMBRE, COUNT(*) AS CANTIDAD, (COUNT(*)/COUNT(*))*100 AS Porcentaje FROM asistencia WHERE tarde > '00:00:00' AND fecha between '2018-03-01' AND '2018-03-30';
 
 
CREATE VIEW 
PorcentajeActividades AS 
SELECT COUNT(*) AS TOTAL FROM asistencia WHERE fecha between '2018-03-01' AND '2018-03-30';