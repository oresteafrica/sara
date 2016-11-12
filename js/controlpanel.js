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
    alert('Quer editar ?\n'+this.id);
    document.getSelection().removeAllRanges();
});
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
$('#bulocal').click(function(){
    var row = $('#tabinfo').children('tbody').eq(0).children('tr');
    var unit_name = $(row).eq(2).children('td').eq(1).text();
    var unit_code = $(row).eq(2).children('td').eq(2).text();
    var unit_id_array = unit_code.split('_');
    var unit_id = unit_id_array[1];
    var prov_name = $(row).eq(0).children('td').eq(1).text();
    var dist_name = $(row).eq(1).children('td').eq(1).text();
    var tit_form = $('#form').children('div').eq(0);    
    //alert('prov_name = '+prov_name+'\n'+'dist_name = '+dist_name+'\n'+'unit_name = '+unit_name);
    $(tit_form).children('div').eq(1).text(prov_name);
    $(tit_form).children('div').eq(3).text(dist_name);
    $(tit_form).children('div').eq(5).text(unit_name);
    $('#divunitid').text(unit_id);
    var map = init_map('#map');
    localise_unit_on_map(curdir,map,unit_name,unit_id);
    init_form_elements(curdir,'#form_elements',unit_id);
    $(this).attr('disabled','true');
    $('#titbut').show();
});
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
