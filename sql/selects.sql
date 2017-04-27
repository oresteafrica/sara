SELECT op_id, in_date, MZ006, MZ007, MZ003 FROM from_field_1

SELECT op_id, in_date, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007, MZ003 FROM from_field_1

SELECT op_id as Usuário, in_date as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, MZ003 as 'Nome da US' FROM from_field_1

SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, in_date as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, MZ003 as 'Nome da US' FROM from_field_1

SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, in_date as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, MZ003 as "Nome da US" FROM from_field_1 ORDER BY in_date

------------------------------------------------------------------------------------------------------------------------
SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, MZ003 as "Nome da US" FROM from_field_1 ORDER BY in_date
------------------------------------------------------------------------------------------------------------------------


SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, MZ001 as "Código da unidade", MZ003 as "Nome da unidade", MZ004 as "Nome curto da unidade", MZ005 as "Localização da unidade", ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, Mz008 as "Posto Administrativo", Mz009 as "Localidade", Mz010 as "Endereço físico", Mz011 as "Informação de contacto", (SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade", (SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora", (SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela"
FROM from_field_1 WHERE id = 1

SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, MZ001 as "Código da unidade", MZ003 as "Nome da unidade", MZ004 as "Nome curto da unidade", MZ005 as "Localização da unidade", ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, Mz008 as "Posto Administrativo", Mz009 as "Localidade", Mz010 as "Endereço físico", Mz011 as "Informação de contacto", (SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade", (SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora", (SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela", (SELECT name FROM unit_state WHERE unit_state.id = from_field_1.MZ015 ) as "Estado operacional", DATE_FORMAT(MZ016, "%d/%m/%Y") as "Data de construção", DATE_FORMAT(MZ017, "%d/%m/%Y") as "Data de início de funcionamento", DATE_FORMAT(MZ018, "%d/%m/%Y") as "Data da última requalificação", DATE_FORMAT(MZ019, "%d/%m/%Y") as "Data do último estado operacional", DATE_FORMAT(MZ020, "%d/%m/%Y") as "Data de alteração de dados da Unidade de Saúde"
FROM from_field_1 WHERE id = 1

SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, MZ001 as "Código da unidade", MZ003 as "Nome da unidade", MZ004 as "Nome curto da unidade", MZ005 as "Localização da unidade", ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, Mz008 as "Posto Administrativo", Mz009 as "Localidade", Mz010 as "Endereço físico", Mz011 as "Informação de contacto", (SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade", (SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora", (SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela", (SELECT name FROM unit_state WHERE unit_state.id = from_field_1.MZ015 ) as "Estado operacional", DATE_FORMAT(MZ016, "%d/%m/%Y") as "Data de construção", DATE_FORMAT(MZ017, "%d/%m/%Y") as "Data de início de funcionamento", DATE_FORMAT(MZ018, "%d/%m/%Y") as "Data da última requalificação", DATE_FORMAT(MZ019, "%d/%m/%Y") as "Data do último estado operacional", DATE_FORMAT(MZ020, "%d/%m/%Y") as "Data de alteração de dados da Unidade de Saúde", if(MZ022, "Sim", "Não") as "Consultas externas apenas (sem internamento)", (SELECT name FROM unit_service WHERE unit_service.id = from_field_1.MZ023 ) as "Tipos de serviços prestados", MZ025 as "	Altitude (metros)", MZ026 as "Latitude (sistema WGS84)", MZ027 as "Longitude (sistema WGS84)"
FROM from_field_1 WHERE id = 1



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

SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província FROM from_field_1 ORDER BY Usuário

SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, COUNT(op_id) as Num FROM from_field_1 GROUP BY op_id

Usuário					Num 	
Oreste Parlatano		15
Stefano Marmorato		5
Marcelino Jaime Mugai	10
Martins Miranda Junior	5
Nathan					3
Vânia da Mira Afonso	1
Zainabe Dadá			5
paulo					3
Frenque Sérgio Sitóe	1
jose chauque			1

SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, COUNT(op_id) as Num FROM from_field_1 GROUP BY op_id ORDER BY Usuário

SELECT (SELECT areas.name FROM areas WHERE areas.id = from_field_1.mz006) AS Províncias, COUNT(mz006) as Num FROM from_field_1 GROUP BY mz006 ORDER BY mz006

Províncias		Num 	
Niassa			6
Cabo Delgado	7
Nampula			2
Tete			1
Zambezia		4
Sofala			1
Gaza			4
Inhambane		2
Maputo cidade	16
Maputo			6

//--------------------------------------------

SELECT
(SELECT areas.id FROM areas WHERE areas.id = hierarchy_units_areas.id_area) AS id_area, 
(SELECT areas.name FROM areas WHERE areas.id = hierarchy_units_areas.id_area) AS distrito,
(SELECT  hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id = id_area) AS up,
(SELECT areas.name FROM areas WHERE areas.id = up) AS província
FROM hierarchy_units_areas 
WHERE hierarchy_units_areas.id_unit = 1

id_area	distrito 	up 	província 	
16 		Lichinga 	2 	Niassa

//--------------------------------------------

SELECT
(SELECT areas.name FROM areas WHERE areas.id = hierarchy_units_areas.id_area) AS distrito,
(SELECT  hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (SELECT areas.id FROM areas WHERE areas.id = hierarchy_units_areas.id_area)) AS up,
(SELECT areas.name FROM areas WHERE areas.id = up) AS província
FROM hierarchy_units_areas 
WHERE hierarchy_units_areas.id_unit = 1

distrito 	up 	província 	
Lichinga 	2 	Niassa

//--------------------------------------------

SELECT
(SELECT areas.name FROM areas WHERE areas.id = hierarchy_units_areas.id_area) AS distrito,
(SELECT areas.name FROM areas WHERE areas.id IN (SELECT  hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (SELECT areas.id FROM areas WHERE areas.id = hierarchy_units_areas.id_area))) AS província
FROM hierarchy_units_areas 
WHERE hierarchy_units_areas.id_unit = 1

distrito 	província 	
Lichinga 	Niassa

//--------------------------------------------

SELECT
(SELECT areas.name FROM areas WHERE areas.id IN (SELECT  hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (SELECT areas.id FROM areas WHERE areas.id = hierarchy_units_areas.id_area))) AS província
FROM hierarchy_units_areas 
WHERE hierarchy_units_areas.id_unit = 1

província 	
Niassa

//--------------------------------------------

SELECT
(SELECT areas.id FROM areas WHERE areas.id IN (SELECT  hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (SELECT areas.id FROM areas WHERE areas.id = hierarchy_units_areas.id_area))) AS província
FROM hierarchy_units_areas 
WHERE hierarchy_units_areas.id_unit = 1

província 	
2

//--------------------------------------------

SELECT hierarchy_units_areas.id_area FROM hierarchy_units_areas WHERE hierarchy_units_areas.id_unit = 1

id_area: 16

//--------------------------------------------

SELECT hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (
SELECT hierarchy_units_areas.id_area FROM hierarchy_units_areas WHERE hierarchy_units_areas.id_unit = 1
)

id_up: 2

//--------------------------------------------

SELECT hierarchy_areas_areas.id
FROM hierarchy_areas_areas
WHERE hierarchy_areas_areas.id_up IN (
SELECT hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (
SELECT hierarchy_units_areas.id_area FROM hierarchy_units_areas WHERE hierarchy_units_areas.id_unit = 1
)
)

id: 13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28

//--------------------------------------------

SELECT areas.id, areas.name FROM areas WHERE areas.id IN (
SELECT hierarchy_areas_areas.id
FROM hierarchy_areas_areas
WHERE hierarchy_areas_areas.id_up IN (
SELECT hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (
SELECT hierarchy_units_areas.id_area FROM hierarchy_units_areas WHERE hierarchy_units_areas.id_unit = 1
)
)
)

id	name
13 	Chimbonila
14 	Cuamba
15 	Lago
16 	Lichinga
17 	Majune
18 	Mandimba
19 	Marrupa
20 	Maúa
21 	Mavago
22 	Mecanhelas
23 	Mecula
24 	Metarica
25 	Muembe
26 	N'gaúma
27 	Nipepe
28 	Sanga

//--------------------------------------------


SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, MZ001 as "Código da unidade", MZ003 as "Nome da unidade", MZ004 as "Nome curto da unidade", MZ005 as "Localização da unidade", ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, Mz008 as "Posto Administrativo", Mz009 as "Localidade", Mz010 as "Endereço físico", Mz011 as "Informação de contacto", (SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade", (SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora", (SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela", (SELECT name FROM unit_state WHERE unit_state.id = from_field_1.MZ015 ) as "Estado operacional", DATE_FORMAT(MZ016, "%d/%m/%Y") as "Data de construção", DATE_FORMAT(MZ017, "%d/%m/%Y") as "Data de início de funcionamento", DATE_FORMAT(MZ018, "%d/%m/%Y") as "Data da última requalificação", DATE_FORMAT(MZ019, "%d/%m/%Y") as "Data do último estado operacional", DATE_FORMAT(MZ020, "%d/%m/%Y") as "Data de alteração de dados da Unidade de Saúde", if(MZ022, "Sim", "Não") as "Consultas externas apenas (sem internamento)", MZ023_c as "Tipos de serviços prestados", MZ025 as "Altitude (metros)", MZ026 as "Latitude (sistema WGS84)", MZ027 as "Longitude (sistema WGS84)", ' . $s_fields . ' FROM from_field_1 WHERE id = 1

id 	Usuário 	Data 	Código da unidade 	Nome da unidade 	Nome curto da unidade 	Localização da unidade 	Província 	Distrito 	Posto Administrativo 	Localidade 	Endereço físico 	Informação de contacto 	Tipo de unidade 	Autoridade gestora 	Ministério de Tutela 	Estado operacional 	Data de construção 	Data de início de funcionamento 	Data da última requalificação 	Data do último estado operacional 	Data de alteração de dados da Unidade de Saúde 	Consultas externas apenas (sem internamento) 	Tipos de serviços prestados 	Altitude (metros) 	Latitude (sistema WGS84) 	Longitude (sistema WGS84) 	. $s_fields . 	
1 	Oreste Parlatano 	25/01/2017 	Aaaaaaaaass 	Bbbbbbbbbh 	abc 	Fyuhfdety 	Maputo cidade 	Ffffffff 	Hhhhhhh 	Jjjjjjjj 	Asdfghhjj 	Cguhgdwethh 	Centro de Saúde Urbano B 	Privado-Lucrativo 	NULL	Fechada 	24/01/2017 	19/08/2011 	19/08/2011 	02/05/2006 	13/03/2007 	Sim 	1,3,5,10,11,12 	100 	-25.9529 	32.6058

//--------------------------------------------

SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, MZ003 as "Nome da US" FROM from_field_1 ORDER BY in_date

id	 	Usuário 			Data 		Província 		Distrito 	Nome da US 	
1	 	Oreste Parlatano 	25/01/2017 	Maputo cidade 	Ffffffff 	Bbbbbbbbbh
2 		Oreste Parlatano 	25/01/2017 	Maputo cidade 	Ffffffff 	Bbbbbbbbbh
3 		Oreste Parlatano 	01/02/2017 	Gaza 	Falso 	Fictícia
...

//--------------------------------------------

SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ007_n ) as Distrito, ( SELECT name FROM units WHERE units.id = from_field_1.MZ003_n ) as "Nome da US" FROM from_field_1 ORDER BY in_date

id	 	Usuário 			Data 		Província 		Distrito 	Nome da US
...
58 		Oreste Parlatano 	18/04/2017 	Zambezia 		Lugela 		Munhamade

//--------------------------------------------

SELECT
	id,
	(SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário,
	DATE_FORMAT(in_date, "%d/%m/%Y") as Data,
	( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província,
	CASE WHEN from_field_1.MZ007_n = 0
		THEN
			MZ007
		ELSE
			( SELECT name FROM areas WHERE areas.id = from_field_1.MZ007_n )
	END as Distrito,
	CASE WHEN from_field_1.MZ003_n = 0
		THEN
			MZ003
		ELSE
			( SELECT name FROM units WHERE units.id = from_field_1.MZ003_n )
	END as "Nome da US"
	FROM from_field_1
	ORDER BY in_date


id	 	Usuário 				Data 		Província 		Distrito 	Nome da US
...
55 		Vânia da Mira Afonso 	17/03/2017 	Maputo 			Kamuub 		Centro de saude Xipamanine
56 		Frenque Sérgio Sitóe 	17/03/2017 	Niassa 			Tt 			Tt
57 		Oreste Parlatano 		24/03/2017 	Niassa 			hgvhg 		prova mz200 01
58 		Oreste Parlatano 		18/04/2017 	Zambezia 		Lugela 		Munhamade

//--------------------------------------------

SELECT
	id,
	(SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário,
	DATE_FORMAT(in_date, "%d/%m/%Y") as Data,
	MZ001 as "Código da unidade",
	CASE WHEN from_field_1.MZ003_n = 0
		THEN
			MZ003
		ELSE
			( SELECT name FROM units WHERE units.id = from_field_1.MZ003_n )
	END as "Nome da US",
	MZ004 as "Nome curto da unidade",
	MZ005 as "Localização da unidade",
	( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província,
	CASE WHEN from_field_1.MZ007_n = 0
		THEN
			MZ007
		ELSE
			( SELECT name FROM areas WHERE areas.id = from_field_1.MZ007_n )
	END as Distrito,
	Mz008 as "Posto Administrativo",
	Mz009 as "Localidade",
	Mz010 as "Endereço físico",
	Mz011 as "Informação de contacto",
	(SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade",
	(SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora",
	(SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela",
	(SELECT name FROM unit_state WHERE unit_state.id = from_field_1.MZ015 ) as "Estado operacional",
	DATE_FORMAT(MZ016, "%d/%m/%Y") as "Data de construção",
	DATE_FORMAT(MZ017, "%d/%m/%Y") as "Data de início de funcionamento",
	DATE_FORMAT(MZ018, "%d/%m/%Y") as "Data da última requalificação",
	DATE_FORMAT(MZ019, "%d/%m/%Y") as "Data do último estado operacional",
	DATE_FORMAT(MZ020, "%d/%m/%Y") as "Data de alteração de dados da Unidade de Saúde",
	if(MZ022, "Sim", "Não") as "Consultas externas apenas (sem internamento)",
	MZ023_c as "Tipos de serviços prestados",
	MZ025 as "Altitude (metros)",
	MZ026 as "Latitude (sistema WGS84)",
	MZ027 as "Longitude (sistema WGS84)"
FROM from_field_1
WHERE id = 

1 	Oreste Parlatano 	25/01/2017 	Aaaaaaaaass 	Bbbbbbbbbh 	abc 	Fyuhfdety 	Maputo cidade 	Ffffffff 	Hhhhhhh 	Jjjjjjjj 	Asdfghhjj 	Cguhgdwethh 	Centro de Saúde Urbano B 	Privado-Lucrativo 	NULL	Fechada 	24/01/2017 	19/08/2011 	19/08/2011 	02/05/2006 	13/03/2007 	Sim 	1,3,5,10,11,12 	100 	-25.9529 	32.6058

58 	Oreste Parlatano 	18/04/2017 	ygvygv 	Munhamade 	hg h 	gfcgfc 	Zambezia 	Lugela 	hf hf 	yfvyfv 	yfcyfc 	yfvyfv 	Hospital Geral 	Privado-Lucrativo 	NULL	Não existe 	18/04/2017 	18/04/2011 	18/04/2017 	18/04/2017 	18/04/2017 	Não 	1,5,8,9,16,20,27,31,33 	0 	0 	0

//--------------------------------------------

SELECT
(SELECT areas.id FROM areas WHERE areas.id = hierarchy_areas_areas.id) AS ids,
(SELECT areas.name FROM areas WHERE areas.id = hierarchy_areas_areas.id) AS distrito
FROM hierarchy_areas_areas 
WHERE hierarchy_areas_areas.id_up = 2

ids distrito 	
13 	Chimbonila
14 	Cuamba
15 	Lago
16 	Lichinga
17 	Majune
18 	Mandimba
19 	Marrupa
20 	Maúa
21 	Mavago
22 	Mecanhelas
23 	Mecula
24 	Metarica
25 	Muembe
26 	N'gaúma
27 	Nipepe
28 	Sanga

//--------------------------------------------

SELECT areas.id, areas.name FROM areas WHERE areas.id IN (
SELECT hierarchy_areas_areas.id
FROM hierarchy_areas_areas
WHERE hierarchy_areas_areas.id_up IN (
SELECT hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id_up = 2
)
)

id	name
13 	Chimbonila
14 	Cuamba
15 	Lago
16 	Lichinga
17 	Majune
18 	Mandimba
19 	Marrupa
20 	Maúa
21 	Mavago
22 	Mecanhelas
23 	Mecula
24 	Metarica
25 	Muembe
26 	N'gaúma
27 	Nipepe
28 	Sanga

//--------------------------------------------

SELECT
(SELECT areas.id FROM areas WHERE areas.id = from_field_1.mz007_n) AS id_dist, 
(SELECT areas.name FROM areas WHERE areas.id = from_field_1.mz007_n) AS dist, 
COUNT(mz007_n) as Num 
FROM from_field_1 
GROUP BY mz007_n

d_dist 	dist 	Num 	
NULL	NULL	57
100 	Lugela 	1

//--------------------------------------------

SELECT
(SELECT areas.id FROM areas WHERE areas.id = from_field_1.mz007_n) AS id_dist, 
(SELECT areas.name FROM areas WHERE areas.id = from_field_1.mz007_n) AS dist, 
COUNT(mz007_n) as Num 
FROM from_field_1 
WHERE mz006 = 2
GROUP BY mz007_n

id_dist dist 	Num 	
NULL	NULL	9

//--------------------------------------------

SELECT
(SELECT areas.name FROM areas WHERE areas.id = from_field_1.mz007_n) AS dist, 
COUNT(mz007_n) as Num 
FROM from_field_1 
WHERE mz006 = 2
GROUP BY mz007_n
ORDER BY mz007_n DESC

dist 	Num 	
NULL	9

//--------------------------------------------

SELECT
(SELECT unit_type.name FROM unit_type WHERE unit_type.id = from_field_1.mz012) AS Tipo, 
COUNT(mz012) as Num 
FROM from_field_1 
WHERE mz006 = 2
GROUP BY mz012
ORDER BY mz012 DESC

Tipo 						Num 	
Centro de Saúde Rural Ii 	2
Posto de Saúde 				7

//--------------------------------------------

SELECT (SELECT unit_type.name FROM unit_type WHERE unit_type.id = from_field_1.mz012) AS Tipologia, 
COUNT(mz012) as Num 
FROM from_field_1 
GROUP BY mz012 
ORDER BY mz012

















