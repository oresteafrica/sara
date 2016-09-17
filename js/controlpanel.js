$( document ).ready(function() {
var curfile = window.location.href ;
var curdir = curfile.substring(0, curfile.lastIndexOf('/'));
var divmap = $('#map')[0] ;
// alert(window.location.origin+'\n'+window.location.hostname+'\n'+curfile+'\n'+curdir);

init_tree(curdir);


var map = new google.maps.Map(divmap, {
zoom: 6,
center: new google.maps.LatLng(-19,36),
mapTypeId: google.maps.MapTypeId.ROADMAP
});



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
				$('#tree').children('div').eq(0).children('label').html($(this).text() + ' ('+this.id+')');
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
