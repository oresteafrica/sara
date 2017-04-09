$(document).ready(function() {
var curfile = window.location.href ;
var curdir = curfile.substring(0, curfile.lastIndexOf('/'));
// alert(window.location.origin+'\n'+window.location.hostname+'\n'+curfile+'\n'+curdir);

var debug = false;

if (debug) {
	debug_tree(curdir);
} else {
	init_tree(curdir);
	init_map('#map');
}

$('#pdc_login').dialog({ autoOpen: false, modal: true });
$('#edit_field').dialog({ autoOpen: false, modal: true });

destroy_session();
user_session();

//----------------------------------------------------------------------------------------------------------------------
$('#titbut').children('div').click(function(){
	ix = $(this).index();
	alert(ix);
});
//----------------------------------------------------------------------------------------------------------------------
$('#tabinfo').children('tbody').eq(0).children('tr').eq(2).children('td').eq(1).dblclick(function(){
    alert('Quer apagar '+$(this).text()+' ?');
    document.getSelection().removeAllRanges();
});
//----------------------------------------------------------------------------------------------------------------------
$(document).on('dblclick', '.edit_element', function() {
	var mz_id = this.id.substring(13);
    $.ajax({
		url: curdir + '/php/check_session.php',
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			if ( a == 1 ) {
				sara_edit_field(mz_id);
			} else {
				$('#pdc_login input').eq(0).val('');
				$('#pdc_login input').eq(1).val('');
				$('#pdc_login input').eq(2).val('');
				$('#pdc_login img').attr('src',curdir + '/php/png_code.php?'+ (Math.random() * (90) + 10) );
				$('#pdc_login').dialog('open');
			}
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
    document.getSelection().removeAllRanges();
});
//----------------------------------------------------------------------------------------------------------------------
$(document).on('click', '.bu_sara_edit', function() {
	var id_bu = this.id;
	var key = id_bu.substr(13,5);
	var val = $(this).siblings('.sara_edit_field_chosen_value').eq(0).val();
    var row = $('#tabinfo').children('tbody').eq(0).children('tr');
    var unit_name = $(row).eq(2).children('td').eq(1).text();
    var unit_code = $(row).eq(2).children('td').eq(2).text();
    var unit_id_array = unit_code.split('_');
    var unit_id = unit_id_array[1];

//	alert(id_bu+'\n'+key+'\n'+val+'\n'+unit_id); // debug

	switch (key) {
		case 'mz001':
			skey = 'Código da unidade';
			if(val.length > 16) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz003':
			skey = 'Nome da unidade';
			if(val.length > 255) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz004':
			skey = 'Nome curto da unidade';
			if(val.length > 10) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz005':
			skey = 'Localização da unidade';
			if(val.length > 255) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz006':
			alert('não autorizado'); return false;
			skey = 'Província';
			if(val < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz007':
			skey = 'Distrito';
			if(val.length > 50) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz008':
			skey = 'Posto Administrativo';
			if(val.length > 255) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz009':
			skey = 'Localidade';
			if(val.length > 255) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz010':
			skey = 'Endereço fisico';
			if(val.length > 255) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz011':
			alert('trabalho em curso'); return false;
			skey = 'Informação de contacto';
			if(val.length > 255) { alert(skey+' longo \n('+val+')'); return false; }
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz012':
			skey = 'Tipo de unidade';
			if(val < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz013':
			skey = 'Autoridade gestora';
			if(val < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz014':
			skey = 'Ministério de tutela';
			if(val < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz015':
			skey = 'Estado operacional';
			if(val < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz016':
			alert('trabalho em curso'); return false;
			skey = 'Data de construção';
			if(! valid(val)) { alert('Falta '+skey); return false; }
			break;
		case 'mz017':
			alert('trabalho em curso'); return false;
			skey = 'Data de ínicio';
			if(! valid(val)) { alert('Falta '+skey); return false; }
			break;
		case 'mz018':
			alert('trabalho em curso'); return false;
			skey = 'Data última requalificação';
			if(! valid(val)) { alert('Falta '+skey); return false; }
			break;
		case 'mz019':
			alert('trabalho em curso'); return false;
			skey = 'Data do último estado operacional';
			if(! valid(val)) { alert('Falta '+skey); return false; }
			break;
		case 'mz020':
			alert('trabalho em curso'); return false;
			skey = 'Data alteração de dados da Unidade de Saúde';
			if(! valid(val)) { alert('Falta '+skey); return false; }
			break;
		case 'mz022':
			alert('trabalho em curso'); return false;
			skey = 'Consultas externas apenas';
			if(val > 1 || val < 0) { alert('Falta '+skey); return false; }
			break;
		case 'mz023': 
			alert('trabalho em curso'); return false;
			skey = 'Tipos de serviços prestados';
			if(val < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz023_c':
			alert('trabalho em curso'); return false;
			skey = 'Tipos de serviços prestados';
			if(val.length < 1) { alert('Falta '+skey); return false; }
			break;
		case 'mz025':
			skey = 'Altitude';
			if( isNaN(val) ) { alert('Falta '+skey+' (pode ser 0)'); return false; }
			break;
		case 'mz026':
			skey = 'Latitude';
			if( isNaN(val) ) { alert('Falta '+skey); return false; }
			break;
		case 'mz027':
			skey = 'Longitude';
			if( isNaN(val) ) { alert('Falta '+skey); return false; }
			break;
	}

    $.ajax({
		url: curdir + '/php/sara_db_insert.php',
        data: { key: key, val: val, unit_id: unit_id },
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#edit_field').dialog('close');
		    init_form_elements(curdir,'#form_elements',unit_id);
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});



});
//----------------------------------------------------------------------------------------------------------------------
$('#pdc_login button').click(function(){
	var no = $('#pdc_login input').eq(0).val();
	var se = $('#pdc_login input').eq(1).val();
	var ca = $('#pdc_login input').eq(2).val();
	var wo = Math.random().toString(36).substring(2, 10);
	var ws = wo.substring(0,3)+se+wo.substring(3,10);
    $.ajax({
		url: curdir + '/php/pdc_login.php',
        data: { no: no, ws: ws, ca: ca },
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#pdc_login').dialog('close');
			if ( a == 1 ) {
				alert('Pode proceder com a editação');
			} else {
				$('#hr').html('');
				alert('O usuário não é autorizado');
			}
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
});
//----------------------------------------------------------------------------------------------------------------------
$('#bulocal').click(function(){
    var row = $('#tabinfo').children('tbody').eq(0).children('tr');
    var unit_name = $(row).eq(2).children('td').eq(1).text();
    var unit_code = $(row).eq(2).children('td').eq(2).text();
    var unit_id_array = unit_code.split('_');
    var unit_id = unit_id_array[1];
    var prov_name = $(row).eq(0).children('td').eq(1).text();
    var dist_name = $(row).eq(1).children('td').eq(1).text();
    var map = init_map('#map');
    localise_unit_on_map(curdir,map,unit_name,unit_id);
    init_form_elements(curdir,'#form_elements',unit_id);
    $(this).attr('disabled','true');
    $('#titbut').show();
});
//----------------------------------------------------------------------------------------------------------------------
function sara_edit_field(mz_id) {

	if ( mz_id == 'mz011' ) {
		alert('Trabalho em curso'); return;
	}

    var row = $('#tabinfo').children('tbody').eq(0).children('tr');
    var unit_name = $(row).eq(2).children('td').eq(1).text();
    var unit_code = $(row).eq(2).children('td').eq(2).text();
    var unit_id_array = unit_code.split('_');
    var unit_id = unit_id_array[1];
    $.ajax({
		url: curdir + '/php/sara_edit_field.php',
        data: { fn: mz_id, id: unit_id},
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#edit_field').html(a);
			$('#edit_field').dialog('open');
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
function user_session() {
    $.ajax({
		url: curdir + '/php/user_session.php',
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#hr').html(a);
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
function destroy_session() {
    $.ajax({
		url: curdir + '/php/destroy_session.php',
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#hr').html('');
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
function init_form_elements(curdir,div,unit_id) {
    	$.ajax({
		url: curdir + '/php/form_elements.php',
        data: { n: unit_id },
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
            $('#form_elements').html(a);
        },
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
function localise_unit_on_map(curdir,map,unit_name,unit_id) {
    $.ajax({
		url: curdir + '/php/sara_coord.php',
        data: { n: unit_id },
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
            var latlon = a.split(';');
            mark(map, latlon[0], latlon[1], unit_name);
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
function mark(map, lat, lon, title) {
	var myLatLng = new google.maps.LatLng(lat, lon);
	var marker = new google.maps.Marker({
		position: myLatLng,
		title: title
	});
	marker.setMap(map);
    latlngbounds = new google.maps.LatLngBounds();
    latlngbounds.extend(myLatLng);
    map.setCenter(latlngbounds.getCenter());
    map.fitBounds(latlngbounds);
    if (map.getZoom() > 10) map.setZoom(10);
}
//----------------------------------------------------------------------------------------------------------------------
function init_map(div) {
	var map = new google.maps.Map($(div)[0], {
		zoom: 6,
		center: new google.maps.LatLng(-19,36),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	return map;
}
//----------------------------------------------------------------------------------------------------------------------
function init_tree(url) {
	$.ajax({
		url: url+ '/php/sara_tree.php',
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#tree').children('div').eq(1).html(a);
			$('li').on("click", function (e) {
				e.stopPropagation();
				$(this).children('ul').toggle('slow');
			});
			$('span').click(function(){
                var lugar = {};
				var huup_t = $(this).parent().parent().parent().parent().parent().children('span').text();
				var huup_i = $(this).parent().parent().parent().parent().parent().children('span').attr('id');
				var hup_t = $(this).parent().parent().parent().children('span').text();
				var hup_i = $(this).parent().parent().parent().children('span').attr('id');
                var h_t = $(this).text();
                var h_i = this.id;
                if (huup_t == '' && hup_t == '' ) {
                    lugar.provname = h_t;
                    lugar.provid = h_i;
                    lugar.distname = '';
                    lugar.distid = '';
                    lugar.unitname = '';
                    lugar.unitid = '';
                    $('#bulocal').attr('disabled','true');
                }
                if (huup_t == '' && hup_t != '' ) {
                    lugar.provname = hup_t;
                    lugar.provid = hup_i;
                    lugar.distname = h_t;
                    lugar.distid = h_i;
                    lugar.unitname = '';
                    lugar.unitid = '';
                    $('#bulocal').attr('disabled','true');
                }
                if (huup_t != '' && hup_t != '' ) {
                    lugar.provname = huup_t;
                    lugar.provid = huup_i;
                    lugar.distname = hup_t;
                    lugar.distid = hup_i;
                    lugar.unitname = h_t;
                    lugar.unitid = h_i;
                    $('#bulocal').removeAttr('disabled');
                }
                var row = $('#tabinfo').children('tbody').eq(0).children('tr');
				$(row).eq(0).children('td').eq(1).text(lugar.provname);
				$(row).eq(0).children('td').eq(2).text(lugar.provid);
				$(row).eq(1).children('td').eq(1).text(lugar.distname);
				$(row).eq(1).children('td').eq(2).text(lugar.distid);
				$(row).eq(2).children('td').eq(1).text(lugar.unitname);
				$(row).eq(2).children('td').eq(2).text(lugar.unitid);
			});
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
function debug_tree(url) {
	$.ajax({
		url: url+ '/php/debug_tree.php',
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#map').html(a);
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
/*
Google Map API key
AIzaSyCIeZTMfIeXUkueMevGm5dizgIcmCFkKRo

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIeZTMfIeXUkueMevGm5dizgIcmCFkKRo&callback=initMap"
    async defer></script>

Cookies

https://github.com/carhartl/jquery-cookie#readme
Create session cookie:
$.cookie('name', 'value');
Create expiring cookie, 7 days from then:
$.cookie('name', 'value', { expires: 7 });
Create expiring cookie, valid across entire site:
$.cookie('name', 'value', { expires: 7, path: '/' });
Read cookie:
$.cookie('name'); // => "value"
$.cookie('nothing'); // => undefined
Read all available cookies:
$.cookie(); // => { "name": "value" }
Delete cookie:
// Returns true when cookie was successfully deleted, otherwise false
$.removeCookie('name'); // => true
    
*/
//----------------------------------------------------------------------------------------------------------------------

}); // $
