<?php
define('TITLE', 'Create scheme');
include APPPATH . 'Views/header.php';
?>

<form method="post">
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="scheme_name">Scheme name:</label>
			<input type="text" class="form-control" id="scheme_name" name="scheme_name">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="from_date">From: <small>*</small></label>
			<input type="date" class="form-control" id="from_date" name="from_date" value="<?= date('Y-m-d', strtotime('now')) ?>" required>
		</div>
		<div class="form-group col-md-6">
			<label for="to_date">To: <small>*</small></label>
			<input type="date" class="form-control" id="to_date" name="to_date" value="<?= date('Y-m-d', strtotime('now + 6 months')) ?>" required>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="name_col_1">Name timescheme 1:</label>
			<input type="text" name="name_col_1" id="name_col_1" class="form-control" value="Youth" list="colum_names">
		</div>
		<div class="form-group col-md-3">
			<label for="time_from_col_1">From:</label>
			<input type="time" name="time_from_col_1" id="time_from_col_1" class="form-control" value="17:00">
		</div>
		<div class="form-group col-md-3">
			<label for="time_to_col_1">To:</label>
			<input type="time" name="time_to_col_1" id="time_to_col_1" class="form-control" value="19:15">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="name_col_2">Name timescheme 2:</label>
			<input type="text" name="name_col_2" id="name_col_2" class="form-control" value="Seniors" list="colum_names">
		</div>
		<div class="form-group col-md-3">
			<label for="time_from_col_2">From:</label>
			<input type="time" name="time_from_col_2" id="time_from_col_2" class="form-control" value="19:15">
		</div>
		<div class="form-group col-md-3">
			<label for="time_to_col_2">to:</label>
			<input type="time" name="time_to_col_2" id="time_to_col_2" class="form-control" value="22:00">
		</div>
	</div>
	<div class="mb-3">
		<button type="button" class="btn btn-primary" onclick="generateScheme()">Load</button>
		<datalist id="colum_names">
			<option value="Youth">
			<option value="Seniors">
			<option value="Novos">
		</datalist>
	</div>
	
	<div id="scheme"></div>

</form>

<script type="text/javascript">
	
	var input_from_date;
	var input_to_date;
	var input_name_col_1;
	var input_time_from_col_1;
	var input_time_to_col_1;
	var input_name_col_2;
	var input_time_from_col_2;
	var input_time_to_col_2;
	var row = 1;
	
	function generateScheme() {
		input_from_date = $('#from_date').val();
		input_to_date = $('#to_date').val();
		input_name_col_1 = $('#name_col_1').val();
		input_time_from_col_1 = $('#time_from_col_1').val();
		input_time_to_col_1 = $('#time_to_col_1').val();
		input_name_col_2 = $('#name_col_2').val();
		input_time_from_col_2 = $('#time_from_col_2').val();
		input_time_to_col_2 = $('#time_to_col_2').val();
		
		if (!input_from_date || !input_to_date) {
			alert('Please enter a valid date range.');
		}
		else{
			var from_date = new Date(input_from_date);
			var to_date = new Date(input_to_date);
			
			var html_scheme = '<div class="table-responsive"><table class="table table-striped w-100"><thead><tr><th>#</th><th>Date <small>*</small></th><th>' + input_name_col_1 + '</th><th>' + input_name_col_2 + '</th><th>Note</th><th>Actions</th></tr></thead><tbody>';
			html_scheme += '</tbody></table></div>';
			html_scheme += '<div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div>';
			
			$('#scheme').html(html_scheme);
			
			row = 1;
			
			for ( i = from_date; i <= to_date; i.setDate(i.getDate() + 7) ) {
				addRow(row - 1, i);
			}
			
			location.href = '#scheme';
		}
	}
	
	function clearTime(rowNum, col) {
		$('input[name="time_from' + rowNum + '_' + col + '"]').val('');
		$('input[name="time_to' + rowNum + '_' + col + '"]').val('');
	}
	
	function deleteRow(rowNum) {
		$("#schemeRow" + rowNum).remove();
	}
	
	function addRow(rowNum, date = '') {
		
		var dateFormatted = '';
		
		if (date !== '') {
			dateFormatted = date.getFullYear().toString() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2);
		}
		
		html_scheme = '<tr id="schemeRow' + row + '">';
		html_scheme += '<td>' + row + '</td>';
		html_scheme += '<td><div class="form-group"><input class="form-control form-control-sm" type="date" name="date' + row + '" value="' + dateFormatted + '" required></div></td>';
		html_scheme += '<td><div class="form-row"><div class="col-auto"><input class="form-control form-control-sm" type="time" name="time_from' + row + '_1" value="' + input_time_from_col_1 + '" ></div><div class="col-auto"><input class="form-control form-control-sm" type="time" name="time_to' + row + '_1" value="' + input_time_to_col_1 + '" ></div><div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger" onclick="clearTime(' + row + ', 1)"><i class="fas fa-trash"></i></button></div></div></td>';
		html_scheme += '<td><div class="form-row"><div class="col-auto"><input class="form-control form-control-sm" type="time" name="time_from' + row + '_2" value="' + input_time_from_col_2 + '" ></div><div class="col-auto"><input class="form-control form-control-sm" type="time" name="time_to' + row + '_2" value="' + input_time_to_col_2 + '" ></div><div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger" onclick="clearTime(' + row + ', 2)"><i class="fas fa-trash"></i></button></div></div></td>';
		html_scheme += '<td><div class="form-group"><input class="form-control form-control-sm" name="note' + row + '"></div><input type="hidden" name="rows[]" value="' + row + '"></td>';
		html_scheme += '<td><div class="btn-group" role="group" aria-label="actions"><button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(' + row + ')"><i class="fas fa-times"></i></button><button type="button" class="btn btn-sm btn-success" onclick="addRow(' + row + ')"><i class="fas fa-plus"></i></button></div></td>';
		html_scheme += '</tr>';
		
		var table_rows = $("#scheme table tbody tr");
		
		if (table_rows.length == 0) {
			$("#scheme table tbody").append(html_scheme);
		}
		else{
			$("#scheme table tr#schemeRow" + rowNum).after(html_scheme);
		}
		
		row++;
	}
	
</script>

<?php include APPPATH . '/Views/footer.php'; ?>
