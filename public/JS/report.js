function download_table_as_csv(table_id, separator = ',') {
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            // Clean innertext to remove multiple spaces and jumpline (break csv)
            var data = cols[j].innerText;
            //var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var universalBOM = "\uFEFF";
	var filename = table_id +'_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=UTF-8,' + encodeURIComponent(universalBOM+csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function download_table_as_excel(table_id)
{
    //getting values of current time for generating the file name
    var postfix = table_id + '_' + new Date().toLocaleDateString();
    
	//var postfix = day + "." + month + "." + year;
    //creating a temporary HTML link element (they support setting file names)
    var a = document.createElement('a');
    //getting data from our div that contains the HTML table
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById(table_id);
    var table_html = table_div.outerHTML.replace(/ /g, '%20');
    a.href = data_type + ', ' + table_html;
    //setting the file name
    a.download = postfix + '.xls';
    //triggering the function
    a.click();
    //just in case, prevent default behaviour
    //e.preventDefault();
    return false;
}

function download_table_as_pdf(table_id) {
	var pdf = new jsPDF('l', 'pt', 'a4');
	source = $('#'+table_id)[0];
	
	specialElementHandlers = {
		// element with id of "bypass" - jQuery style selector
		'#bypassme': function (element, renderer) {
			// true = "handled elsewhere, bypass text extraction"
			return true
		}
	};
	margins = {
		top: 10,
		bottom: 1,
		left: 10,
		width: 522
	};
	//<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	pdf.setDisplayMode("100%", "continuous");
	
	pdf.fromHTML(
		source, // HTML string or DOM elem ref.
		margins.left, // x coord
		margins.top,
		{ // y coord
			'width': margins.width, // max width of content on PDF
			'elementHandlers': specialElementHandlers
		},

		function (dispose) {
			// dispose: object with X, Y of the last line add to the PDF 
			//          this allow the insertion of new lines after html
			pdf.output('dataurlnewwindow');
			//pdf.save('Test.pdf');
		}, margins
	);
	
}


function print_rep(index)
{
	var div = document.getElementById(index);
	// Create a window object.
	var win = window.open('', '', 'height=700,width=700,dir=rtl'); // Open the window. Its a popup window.
	win.document.write(div.outerHTML);     // Write contents in the new window.
	win.document.close();
	win.print();  
}