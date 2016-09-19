$( document ).ready(function() {
var curfile = window.location.href ;
var curdir = curfile.substring(0, curfile.lastIndexOf('/'));
// alert(window.location.origin+'\n'+window.location.hostname+'\n'+curfile+'\n'+curdir);

init_tree(curdir);
var map = init_map('#map');

$('#bulocal').click(function(){

});




//----------------------------------------------------------------------------------------------------------------------
function mark(map, lat, lng, title) {
	var myLatlng = new google.maps.LatLng(lat, lng);
	var marker = new google.maps.Marker({
		position: myLatLng,
		title: title
	});
	marker.setMap(map);
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
                    $('#bulocal').removeAttr('disabled');
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
/*
Google Map API key
AIzaSyCIeZTMfIeXUkueMevGm5dizgIcmCFkKRo

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIeZTMfIeXUkueMevGm5dizgIcmCFkKRo&callback=initMap"
    async defer></script>

*/
//----------------------------------------------------------------------------------------------------------------------

}); // $
