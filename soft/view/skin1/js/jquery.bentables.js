importJavaScript('view/skin1/js/jquery.dataTables.js');
var oTable;
var giRedraw = false;
var asInitVals = new Array();
var aColumns = new Array();

$(document).ready(function() {	

	$("thead th").each( function (i) {
		switch(this.className){
			case 'center':
				aColumns[i] = { "sClass": "center" };
				break;
			case 'right':
				aColumns[i] = { "sClass": "right" };
				break;
			case 'sort_disabled':
				aColumns[i] = { "bSortable": false };
				break;
			case 'sort_disabled center':
				aColumns[i] = { "bSortable": false, "sClass": "center" };
				break;
			case 'sort_disabled right':
				aColumns[i] = { "bSortable": false, "sClass": "right" };
				break;
			default:
				aColumns[i] = 'null';
				break;			
		}
	} );
	
	oTable = $('#tblBen').dataTable( {
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": sAjaxSource,
		"aoColumns": aColumns
	} );
	
	$("#tblBen").css({width:"100%"});
	
	$("#tblBen tbody").click(function(event) {
		$(oTable.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		$(event.target.parentNode).addClass('row_selected');
	});
	
	$("tfoot input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable.fnFilter( this.value, $("tfoot input").index(this) );
	} );
	
	/*
	 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
	 * the footer
	 */
	$("tfoot input").each( function (i) {
		asInitVals[i] = this.value;
	} );
	
	$("tfoot input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );
	
	$("tfoot input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("tfoot input").index(this)];
		}
	} );
	
	//Sort nhan dang kieu du lieu
	jQuery.fn.dataTableExt.aTypes.push(
		function ( sData )
		{
			var sValidChars = "0123456789-,";
			var Char;
			var bDecimal = false;
			
			/* Check the numeric part */
			for ( i=0 ; i<sData.length ; i++ )
			{
				Char = sData.charAt(i);
				if (sValidChars.indexOf(Char) == -1)
				{
					return null;
				}
				
				/* Only allowed one decimal place... */
				if ( Char == "," )
				{
					if ( bDecimal )
					{
						return null;
					}
					bDecimal = true;
				}
			}
			
			return 'numeric-comma';
		}
	);
	
	jQuery.fn.dataTableExt.oSort['numeric-comma-asc']  = function(a,b) {
		var x = (a == "-") ? 0 : a.replace( /,/, "." );
		var y = (b == "-") ? 0 : b.replace( /,/, "." );
		x = parseFloat( x );
		y = parseFloat( y );
		return ((x < y) ? -1 : ((x > y) ?  1 : 0));
	};
	
	jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a,b) {
		var x = (a == "-") ? 0 : a.replace( /,/, "." );
		var y = (b == "-") ? 0 : b.replace( /,/, "." );
		x = parseFloat( x );
		y = parseFloat( y );
		return ((x < y) ?  1 : ((x > y) ? -1 : 0));
	};
	

} );