$( document ).ready(function() {
var curfile = window.location.href ;
var curdir = curfile.substring(0, curfile.lastIndexOf('/'));
// alert(window.location.origin+'\n'+window.location.hostname+'\n'+curfile+'\n'+curdir);

init_tree(curdir);
var map = init_map('#map');

$('#tree').children('div').eq(0).children('button').click(function(){
	var label = $('#tree').children('div').eq(0).children('label').html();
	$('#form').html('<h2>'+label+'</h2>');
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
				var hup = $(this).parent().parent().parent().children('span').text();
				$('#tree').children('div').eq(0).children('label').html(hup+'<br />'+$(this).text() + ' ('+this.id+')');
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
