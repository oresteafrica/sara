SELECT areas.id AS id, areas.name AS name, CAST(hierarchy_areas_areas.id_up AS UNSIGNED) AS id_up, CONCAT("a_",areas.id) AS sid FROM areas, hierarchy_areas_areas WHERE areas.id = hierarchy_areas_areas.id AND hierarchy_areas_areas.id_up < 13 UNION SELECT (@cnt := @cnt + 1) AS id, units.name AS name, CAST(hierarchy_units_areas.id_area AS UNSIGNED) AS id_up, CONCAT("u_",units.id) AS sid FROM units, hierarchy_units_areas CROSS JOIN (SELECT @cnt := 10000) AS dummy WHERE units.id = hierarchy_units_areas.id_unit ORDER BY id, id_up


SELECT areas.id AS id, areas.name AS name, CAST(hierarchy_areas_areas.id_up AS UNSIGNED) AS id_up, CONCAT("a_",areas.id) AS sid, 3 as v FROM areas, hierarchy_areas_areas WHERE areas.id = hierarchy_areas_areas.id AND hierarchy_areas_areas.id_up < 13 UNION SELECT (@cnt := @cnt + 1) AS id, units.name AS name, CAST(hierarchy_units_areas.id_area AS UNSIGNED) AS id_up, CONCAT("u_",units.id) AS sid, units.valid as v FROM units, hierarchy_units_areas CROSS JOIN (SELECT @cnt := 10000) AS dummy WHERE units.id = hierarchy_units_areas.id_unit ORDER BY id, id_up







SELECT 
	areas.id AS id, 
	areas.name AS name, 
	CAST(hierarchy_areas_areas.id_up AS UNSIGNED) AS id_up, 
	CONCAT("a_",areas.id) AS sid,
	3 as v 
		FROM areas, hierarchy_areas_areas 
			WHERE areas.id = hierarchy_areas_areas.id AND hierarchy_areas_areas.id_up < 13 
UNION SELECT 
	(@cnt := @cnt + 1) AS id, 
	units.name AS name, 
	CAST(hierarchy_units_areas.id_area AS UNSIGNED) AS id_up, 
	CONCAT("u_",units.id) AS sid,
	units.valid as v 
		FROM units, hierarchy_units_areas CROSS JOIN (SELECT @cnt := 10000) AS dummy 
			WHERE units.id = hierarchy_units_areas.id_unit 
			ORDER BY id, id_up

SELECT hierarchy_areas_areas.id_up 
	FROM hierarchy_areas_areas, hierarchy_units_areas 
	WHERE hierarchy_areas_areas.id = hierarchy_units_areas.id_area


SELECT hierarchy_areas_areas.id_up, count(hierarchy_areas_areas.id_up) 
	FROM hierarchy_areas_areas, hierarchy_units_areas 
	WHERE hierarchy_areas_areas.id = hierarchy_units_areas.id_area 
	GROUP BY hierarchy_areas_areas.id_up


"2","160"
"3","114"
"4","213"
"5","129"
"6","229"
"7","104"
"8","232"
"9","132"
"10","126"
"11","39"
"12","112"

SELECT DISTINCT areas.id, areas.name 
	FROM areas, hierarchy_areas_areas 
	WHERE areas.id = hierarchy_areas_areas.id_up AND areas.id < 13 AND areas.id > 1

"2","Niassa"
"3","Cabo Delgado"
"4","Nampula"
"5","Tete"
"6","Zambezia"
"7","Manica"
"8","Sofala"
"9","Gaza"
"10","Inhambane"
"11","Maputo cidade"
"12","Maputo"

SELECT (SELECT areas.name FROM areas WHERE areas.id = hierarchy_areas_areas.id_up) AS name, hierarchy_areas_areas.id_up, count(hierarchy_areas_areas.id_up) AS count 
	FROM hierarchy_areas_areas, hierarchy_units_areas 
	WHERE hierarchy_areas_areas.id = hierarchy_units_areas.id_area 
	GROUP BY hierarchy_areas_areas.id_up

"Niassa","2","160"
"Cabo Delgado","3","114"
"Nampula","4","213"
"Tete","5","129"
"Zambezia","6","229"
"Manica","7","104"
"Sofala","8","232"
"Gaza","9","132"
"Inhambane","10","126"
"Maputo cidade","11","39"
"Maputo","12","112"

SELECT (SELECT areas.name FROM areas WHERE areas.id = hierarchy_areas_areas.id_up) AS name, count(hierarchy_areas_areas.id_up) AS count 
	FROM hierarchy_areas_areas, hierarchy_units_areas 
	WHERE hierarchy_areas_areas.id = hierarchy_units_areas.id_area 
	GROUP BY hierarchy_areas_areas.id_up

"Niassa","160"
"Cabo Delgado","114"
"Nampula","213"
"Tete","129"
"Zambezia","229"
"Manica","104"
"Sofala","232"
"Gaza","132"
"Inhambane","126"
"Maputo cidade","39"
"Maputo","112"







