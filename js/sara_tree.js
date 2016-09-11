$( document ).ready(function() {

$('#divtree').jstree();

$('#divtree').on("activate_node.jstree", function (e, data) {
	var dta = data.node.text;
	var txt = dta.substring(0,dta.indexOf('<'));
	var idt = dta.match(/\d{1,4}/gi);

	// alert(txt + '\n' + idt);  // funziona
	
});


$('#bu_ou_csv_dhis2').click(function() {
	$('#frame_download').attr('src', 'download_ou_csv_dhis2.php?type=csv');
});
$('#bu_ou_xml_dhis2').click(function() {
	$('#frame_download').attr('src', 'download_ou_csv_dhis2.php?type=xml');
});
$('#bu_ou_dxf_dhis2').click(function() {
	$('#frame_download').attr('src', 'download_ou_csv_dhis2.php?type=dxf');
});




});

