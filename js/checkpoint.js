$( document ).ready(function() {
var curfile = window.location.href ;
var curdir = curfile.substring(0, curfile.lastIndexOf('/'));
var csv = curdir + '/kml/units_coord.csv';

table(csv);

/*

Bisogna trasformare i klm in array javascript
altrimenti si deve usare ajax con tutti i problemi dovuti 
alla comunicazione asincrona di conseguenza l'impossibilità
di creare variabili globali

*/

//----------------------------------------------------------------------------------------------------------------------
$('#units').on('click', 'td:first-child', function() {
	var uni = $(this).text();
	var lat = parseFloat($(this).siblings('td').eq(0).text());
	var lon = parseFloat($(this).siblings('td').eq(1).text());
	//alert(uni + ' ( lat = ' + lat + ', lon = ' + lon + ')');
	var isin = pnpoly (mozmoz, { y:lat, x:lon });
	
	if (isin) {
		var prov = [];
		prov[2]= 'Niassa';
		prov[3]= 'Cabo Delgado';
		prov[4]= 'Nampula';
		prov[5]= 'Tete';
		prov[6]= 'Zambezia';
		prov[7]= 'Manica';
		prov[8]= 'Sofala';
		prov[9]= 'Gaza';
		prov[10]= 'Inhambane';
		prov[11]= 'Maputo cidade';
		prov[12]= 'Maputo';
		for (var i = 2; i < 13; i++) {
			if (pnpoly (mozprov[i], { y:lat, x:lon })) break;
		}
				$('#output').html('<p>Unidade ' + uni + '<br />' +
									'lat,lon    = ' + lat + ',' + lon + '<br />' +
									'prov[' + i + '] = ' + prov[i] + '<br />' +
									'</p>');
		


		for (var j = 0; j < mozdist[i].length; j++) {
				if (pnpoly (mozdist[i][j].coord, { y:lat, x:lon })) break;
		}
		
		if ( j == mozdist[i].length ){ $('#output').append('<p>Distrito não encontrado</p>'); } else {
			$('#output').append('<p>' +
								'mozdist[' + i + '][' + j + '].name = ' + mozdist[i][j].name +
								'</p>');			
		}
		
		


									
													
	} else {
				$('#output').html('<p>Unidade ' + uni + '<br />' +
									'isin   = ' + isin + '<br />' +
									'lat,lon    = ' + lat + ',' + lon + '<br />' +
									'mozmoz[0][0] = ' + mozmoz[0][0] + '<br />' +
									'mozmoz[0][1] = ' + mozmoz[0][1] + '<br />' +
									'</p>');		
	}
	
	




	
});
//----------------------------------------------------------------------------------------------------------------------
function pnpoly (points, test) {
  var i, j, c = false;
  for( i = 0, j = points.length-1; i < points.length; j = i++ ) {
    if( ( ( points[i][1] > test.y ) != ( points[j][1] > test.y ) ) &&
      ( test.x < ( points[j][0] - points[i][0] ) * 
		( test.y - points[i][1] ) / ( points[j][1] - points[i][1] ) + points[i][0] ) ) {
      c = !c;
    }
  }
  return c;
}
//----------------------------------------------------------------------------------------------------------------------
function table(csv) {
	$.ajax({
		url: csv,
		type: 'GET',
		dataType: "text",
		beforeSend: function(a){  },
		success: function(a){
			var arr = $.csv.toArrays(a);
			var trs = '';
			for(var row in arr) {
				trs += '<tr>\r\n';
				for(var item in arr[row]) {
					trs += '<td>' + arr[row][item] + '</td>\r\n';
				}
				trs += '</tr>\r\n';
			}
			$('#units > tbody').html(trs);
		},
		error: function(a,b,c){ alert( 'erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ) },
		complete: function(a,b){}
	});
};
//----------------------------------------------------------------------------------------------------------------------

 
});


/*

		for (var j = 0; j < mozdist[i].length; j++) {
				if (pnpoly (mozdist[i][j].coord, { y:lat, x:lon })) break;
		}

		$('#output').append('<p>' +
							'mozdist[' + i + '][' + j + '].name = ' + mozdist[i][j].name +
							'</p>');


									'mozdist[2][1].coord = ' + mozdist[2][1].coord +



Unidade 670
isin = false
lat,lon = -17.5753,37.1589
mozmoz[0][0] = 32.98409757100006
mozmoz[0][1] = -25.969878853999944






	if (inmoz) {
		inproarr(curdir,lat,lon);
	}


			$('#output').append('<p>n.vertex moz = ' + nvert + '<br />lat = ' + lat + '<br />lon = ' + lon + '<br />isin = ' + isin + '</p>');



			$('#output').append('<p>n.vertex moz = ' + nvert + 
								'<br />lat = ' + lat + 
								'<br />lon = ' + lon + 
								'<br />test = ' + JSON.stringify(test, null, 4) + 
								'<br />test.y = ' + test.y + 
//								'<br />acoos = <span style="font-size:xx-small;">' + JSON.stringify(acoos, null, 4) + '</span>' +
								'<br />ocoos[0].y = ' + ocoos[0].y + 
								'<br />ocoos = <span style="font-size:xx-small;">' + JSON.stringify(ocoos, null, 4) + '</span>' +
								'</p>');


$('#output').append('</p>'+
'<br />points.length = ' + points.length +
'<br />points[0].y = ' + points[0].y +
'<br />points[0].x = ' + points[0].x +
'<br />test.y = ' + test.y +
'<br />test.x = ' + test.x +
'</p>');

function pnpoly (points, test) {
  var i, j, c = false;
  for( i = 0, j = points.length-1; i < points.length; j = i++ ) {
    if( ( ( points[i].y > test.y ) != ( points[j].y > test.y ) ) &&
      ( test.x < ( points[j].x - points[i].x ) * 
		( test.y - points[i].y ) / ( points[j].y - points[i].y ) + points[i].x ) ) {
      c = !c;
    }
  }
  return c;
}


				$('#output').append('<p>Unidade ' + uni + ' não está em Moçambique<br />' +
									'mozmoz.length = ' + mozmoz.length + '<br />' +
									'test.y = ' + test.y + '<br />' +
									'test.x = ' + test.x + '<br />' +
									'lat    = ' + lat + '<br />' +
									'lon    = ' + lon + '<br />' +
									'isin   = ' + isin + '<br />' +
									'</p>');

				$('#output').append('<p>Unidade ' +
									'isin   = ' + isin + '<br />' +
									'<span style="font-size:xx-small;">' + JSON.stringify(mozmoz, null, 4) + '</span><br />' +
									'</p>');


$('#output').html('<p>curfile = '+curfile+'</p><p>curdir = '+curdir+'</p><p>csv = '+csv+'</p>');


*/
