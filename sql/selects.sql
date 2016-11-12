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
