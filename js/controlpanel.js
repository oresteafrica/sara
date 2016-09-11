$( document ).ready(function() {
var curfile = window.location.href ;
var curdir = curfile.substring(0, curfile.lastIndexOf('/'));
// alert(window.location.origin+'\n'+window.location.hostname+'\n'+curfile+'\n'+curdir);


init_tree(curdir);














//----------------------------------------------------------------------------------------------------------------------
function init_tree(url) {
			$('#tree').jstree();
			$('#tree').on("activate_node.jstree", function (e, data) {
				var dta = data.node.text;
				var txt = dta.substring(0,dta.indexOf('<'));
				var idt = dta.match(/\d{1,4}/gi);
				// alert(txt + '\n' + idt);  // funziona
			});
	$.ajax({
		url: url+ '/php/sara_tree.php',
		type: 'GET',
		dataType: 'html',
		beforeSend: function(a){  },
		success: function(a){
			$('#tree').html(a);
		},
		error: function(a,b,c){ alert('erro ajax\na = ' + a.responseText + '\nb = ' + b + '\nc = ' + c ); },
		complete: function(a,b){  }
	});
}
//----------------------------------------------------------------------------------------------------------------------
}); // $
