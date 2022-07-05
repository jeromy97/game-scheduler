<?php
define('TITLE', 'Create scheme');
include APPPATH . 'Views/header.php';
?>

<form method="post">
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="scheme_name">Scheme name:</label>
			<input type="text" class="form-control" id="scheme_name" name="scheme_name" list="schemeNames">
			<datalist id="schemeNames">
				<?php foreach($schemeNames as $schemeName): ?>
					<option value="<?= esc($schemeName['name']) ?>"></option>
				<?php endforeach; ?>
			</datalist>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="from_date">From: <small>*</small></label>
			<input type="date" class="form-control" id="from_date" name="from_date" value="<?= date('Y-m-d', strtotime('now')) ?>" required>
		</div>
		<div class="form-group col-md-6">
			<label for="to_date">To: <small>*</small></label>
			<input type="date" class="form-control" id="to_date" name="to_date" value="<?= date('Y-m-d', strtotime('now + 1 year')) ?>" required>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped" id="timeColumnTable">
			<thead>
				<tr>
					<th>#</th>
					<th>Timescheme name <small>*</small></th>
					<th>From <small>*</small></th>
					<th>To <small>*</small></th>
					<th class="text-right">Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr id="timeSchemeRow1">
					<td>1</td>
					<td>
						<div class="form-group">
							<input type="text" name="name_col_1" id="name_col_1" class="form-control" list="colum_names" required>
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="time" name="time_from_col_1" id="time_from_col_1" class="form-control" required>
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="time" name="time_to_col_1" id="time_to_col_1" class="form-control" required>
						</div>
					</td>
					<td class="text-right">
						<button type="button" class="btn btn-danger" onclick="deleteTimeSchemeRow(1)">
							<i class="fas fa-times"></i>
						</button>
						<input type="hidden" name="time_scheme_num[]" value="1">
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">
						<button type="button" class="btn btn-success" onclick="addTimeColumnRow()">
							<i class="fas fa-plus"></i>
						</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="mb-3">
		<button type="button" class="btn btn-primary" onclick="generateScheme()">Load</button>
		<?php // TODO: Manage this in database. ?>
		<datalist id="colum_names">
			<option value="Pupils">
			<option value="Youth">
			<option value="Seniors">
		</datalist>
	</div>
	
	<div id="scheme"></div>

</form>

<script type="text/javascript">
	
	var input_from_date;
	var input_to_date;
	var rowNumTC = 2;
	var rowNumS = 1;
	var timeColumnRows;
	
	function addTimeColumnRow() {
		var html = '<tr id="timeSchemeRow' + rowNumTC + '">';
		html += '<td>' + rowNumTC + '</td>';
		html += '<td>';
		html += '<div class="form-group">';
		html += '<input type="text" name="name_col_' + rowNumTC + '" id="name_col_' + rowNumTC + '" class="form-control" list="colum_names" required>';
		html += '</div>';
		html += '</td>';
		html += '<td>';
		html += '<div class="form-group">';
		html += '<input type="time" name="time_from_col_' + rowNumTC + '" id="time_from_col_' + rowNumTC + '" class="form-control" required>';
		html += '</div>';
		html += '</td>';
		html += '<td>';
		html += '<div class="form-group">';
		html += '<input type="time" name="time_to_col_' + rowNumTC + '" id="time_to_col_' + rowNumTC + '" class="form-control" required>';
		html += '</div>';
		html += '</td>';
		html += '<td class="text-right">';
		html += '<button type="button" class="btn btn-danger" onclick="deleteTimeSchemeRow(' + rowNumTC + ')">';
		html += '<i class="fas fa-times"></i>';
		html += '</button>';
		html += '<input type="hidden" name="time_scheme_num[]" value="' + rowNumTC + '">';
		html += '</td>';
		html += '</tr>';
		
		$('#timeColumnTable tbody').append(html);
		
		rowNumTC++;
	}
	
	function generateScheme() {
		input_from_date = $('#from_date').val();
		input_to_date = $('#to_date').val();
		
		if (!input_from_date || !input_to_date) {
			alert('Please enter a valid date range.');
		}
		else{
			var from_date = new Date(input_from_date);
			var to_date = new Date(input_to_date);
			
			timeColumnRows = $('#timeColumnTable tbody tr');
			
			var html_scheme = '<div class="table-responsive">';
			html_scheme += '<table class="table table-striped w-100">';
			html_scheme += '<thead>';
			html_scheme += '<tr>';
			html_scheme += '<th>#</th>';
			html_scheme += '<th>Date <small>*</small></th>';
			timeColumnRows.each(function(index){
				var rowNum = $(this).find('input[name="time_scheme_num[]"]').val();
				var colName = $(this).find('input#name_col_' + rowNum).val();
				
				html_scheme += '<th>' + colName + '</th>';
			});
			html_scheme += '<th>Note</th>';
			html_scheme += '<th>Actions</th>';
			html_scheme += '</tr>';
			html_scheme += '</thead>';
			html_scheme += '<tbody>';
			html_scheme += '</tbody>';
			html_scheme += '</table>';
			html_scheme += '</div>';
			html_scheme += '<div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div>';
			
			$('#scheme').html(html_scheme);
			
			rowNumS = 1;
			
			for ( i = from_date; i <= to_date; i.setDate(i.getDate() + 7) ) {
				addSchemeRow(rowNumS - 1, i);
			}
			
			location.href = '#scheme';
		}
	}
	
	function clearTime(rowNum, col) {
		$('input[name="time_from' + rowNum + '_' + col + '"]').val('');
		$('input[name="time_to' + rowNum + '_' + col + '"]').val('');
	}
	
	function deleteSchemeRow(rowNum) {
		$("#schemeRow" + rowNum).remove();
	}
	
	function addSchemeRow(rowNum, date = '') {
		
		var dateFormatted = '';
		
		if (date !== '') {
			dateFormatted = date.getFullYear().toString() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2);
		}
		
		html_scheme = '<tr id="schemeRow' + rowNumS + '">';
		html_scheme += '<td>' + rowNumS + '</td>';
		html_scheme += '<td><div class="form-group"><input class="form-control form-control-sm" type="date" name="date' + rowNumS + '" value="' + dateFormatted + '" required></div></td>';
		timeColumnRows.each(function(index){
			var rowNumberColumnScheme = $(this).find('input[name="time_scheme_num[]"]').val();
			var colTimeFrom = $(this).find('input#time_from_col_' + rowNumberColumnScheme).val();
			var colTimeTo = $(this).find('input#time_to_col_' + rowNumberColumnScheme).val();
			
			html_scheme += '<td>';
			html_scheme += '<div class="input-group">';
			html_scheme += '<input class="form-control form-control-sm" type="time" name="time_from' + rowNumS + '_' + rowNumberColumnScheme + '" value="' + colTimeFrom + '" >';
			html_scheme += '<input class="form-control form-control-sm" type="time" name="time_to' + rowNumS + '_' + rowNumberColumnScheme + '" value="' + colTimeTo + '" >';
			html_scheme += '<div class="input-group-append">';
			html_scheme += '<button type="button" class="btn btn-sm btn-outline-danger" onclick="clearTime(' + rowNumS + ', ' + rowNumberColumnScheme + ')"><i class="fas fa-trash"></i></button>';
			html_scheme += '</div>';
			html_scheme += '</div>';
			html_scheme += '</td>';
		});
		html_scheme += '<td><div class="form-group"><input class="form-control form-control-sm" name="note' + rowNumS + '"></div><input type="hidden" name="rows[]" value="' + rowNumS + '"></td>';
		html_scheme += '<td><div class="btn-group" role="group" aria-label="actions"><button type="button" class="btn btn-sm btn-danger" onclick="deleteSchemeRow(' + rowNumS + ')"><i class="fas fa-times"></i></button><button type="button" class="btn btn-sm btn-success" onclick="addSchemeRow(' + rowNumS + ')"><i class="fas fa-plus"></i></button></div></td>';
		html_scheme += '</tr>';
		
		var table_rows = $("#scheme table tbody tr");
		
		if (table_rows.length == 0) {
			$("#scheme table tbody").append(html_scheme);
		}
		else{
			$("#scheme table tr#schemeRow" + rowNum).after(html_scheme);
		}
		
		rowNumS++;
	}
	
</script>

<?php include APPPATH . '/Views/footer.php'; ?>
