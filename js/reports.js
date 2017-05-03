$( document ).ready(function() {
//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
$('span').click(function(){
	if ( this.id == '' ) { return false; }
	var iniobj = '<object type="text/html" data="';
	var endobj = '" style="width:100%;height:100%;min-height:400px;"></object>';
	var resdiv = $('#results');
	var id = this.id;
	switch (id) {
		case 'sara_report_form_list':
			resdiv.html( iniobj + 'php/sara_list_entries_from_field.php' + endobj );
			break;
		case 'sara_report_form_excel':
			resdiv.html( iniobj + 'php/reports_table_excel.php' + endobj );
			break;
		case 'sara_report_guia':
			window.open('http://saramoz.org/wp/?page_id=273');
			break;
		default :
			resdiv.html( iniobj + 'php/sara_stats.php?m=' + id + endobj );
			break;
	}

});
//----------------------------------------------------------------------------------------------------------------------
function in_ajax(url,data,div) {
    	$.ajax({
		url: url,
        data: data,
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
            $(div).html(a);
        },
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
});

