<?php namespace App\Controllers;

use App\Models\SchemeModel;
use App\Models\TimeSchemeModel;
use App\Models\TimeSchemeRowModel;
use App\Models\TimeSchemeColumnModel;

class Schedule extends BaseController
{
	protected $schemeModel;
	protected $timeSchemeModel;
	protected $timeSchemeRowModel;
	protected $timeSchemeColumnModel;
	
	public function __construct()
	{
		$this->schemeModel = new SchemeModel();
		$this->timeSchemeModel = new TimeSchemeModel();
		$this->timeSchemeRowModel = new TimeSchemeRowModel();
		$this->timeSchemeColumnModel = new TimeSchemeColumnModel();
	}
	
	public function index()
	{
		$data['schemes'] = $this->schemeModel->getAll();
		
		return view('pages/schedule/default', $data);
	}
	
	public function create()
	{
		if ($this->request->getMethod() == 'post') {
			
			$timeSchemeIds = [];
			
			$data = [
				'name' => $_POST['scheme_name'],
				'dateFrom' => $_POST['from_date'],
				'dateTo' => $_POST['to_date']
			];
			
			$this->schemeModel->save($data);
			$schemeId = $this->schemeModel->insertID();
			
			foreach ($_POST['time_scheme_num'] as $num) {
				$data = [
					'schemeId' => $schemeId,
					'name' => $_POST["name_col_$num"],
					'timeFrom' => $_POST["time_from_col_$num"],
					'timeTo' => $_POST["time_to_col_$num"]
				];
				
				$this->timeSchemeModel->save($data);
				$timeSchemeIds[$num] = $this->timeSchemeModel->insertID();
			}
			
			foreach ($_POST['rows'] as $row) {
				$data = [
					'schemeId' => $schemeId,
					'date' => $_POST["date$row"],
					'note' => $_POST["note$row"]
				];
				
				$this->timeSchemeRowModel->save($data);
				$timeSchemeRowId = $this->timeSchemeRowModel->insertID();
				
				foreach ($_POST['time_scheme_num'] as $num) {
					$data = [
						'rowId' => $timeSchemeRowId,
						'timeSchemeId' => $timeSchemeIds[$num],
						'timeFrom' => $_POST["time_from{$row}_{$num}"],
						'timeTo' => $_POST["time_to{$row}_{$num}"]
					];
					
					$this->timeSchemeColumnModel->save($data);
				}
			}
			
			die('Saved succesfully');
		}
		
		return view('pages/schedule/create');
	}

	public function edit()
	{
		$schemeId = $this->request->uri->getSegment(3);
		$scheme = $this->schemeModel->getScheme($schemeId);
		if ($scheme == null) {
			die('Error: This scheme does not exist.');
		}
		
		if ($this->request->getMethod() == 'post') {

			// Update scheme
			
			$data = [
				'id' => $schemeId,
				'name' => $_POST['scheme_name'],
				'dateFrom' => $_POST['from_date'],
				'dateTo' => $_POST['to_date']
			];
			
			$this->schemeModel->save($data);

			// Update time schemes
			
			$timeSchemeIds = [];
			$timeSchemeRowIds = [];
			$timeSchemeColumnIds = [];

			foreach ($_POST['time_scheme_num'] as $num) {
				$data = [
					'name' => $_POST["name_col_$num"],
					'timeFrom' => $_POST["time_from_col_$num"],
					'timeTo' => $_POST["time_to_col_$num"]
				];
				if (isset($_POST["time_scheme_id_$num"])) $data['id'] = $_POST["time_scheme_id_$num"];
				
				$this->timeSchemeModel->save($data);
				$timeSchemeIds[$num] = isset($_POST["time_scheme_id_$num"]) ? $_POST["time_scheme_id_$num"] : $this->timeSchemeModel->insertID();
			}

			// Update time scheme rows

			foreach ($_POST['rows'] as $row) {
				$data = [
					'date' => $_POST['date' . $row],
					'note' => $_POST['note' . $row]
				];
				if (isset($_POST["time_scheme_row_id_$row"])) $data['id'] = $_POST["time_scheme_row_id_$row"];
				
				$this->timeSchemeRowModel->save($data);
				$timeSchemeRowId = isset($_POST["time_scheme_row_id_$row"]) ? $_POST["time_scheme_row_id_$row"] : $this->timeSchemeRowModel->insertID();
				$timeSchemeRowIds[] = $timeSchemeRowId;
				
				foreach ($_POST['time_scheme_num'] as $num) {
					$data = [
						'rowId' => $timeSchemeRowId,
						'timeSchemeId' => $timeSchemeIds[$num],
						'timeFrom' => $_POST["time_from{$row}_{$num}"],
						'timeTo' => $_POST["time_to{$row}_{$num}"]
					];
					if (isset($_POST["time_scheme_column_id_{$row}_{$num}"])) $data['id'] = $_POST["time_scheme_column_id_{$row}_{$num}"];
					
					$this->timeSchemeColumnModel->save($data);
					$timeSchemeColumnIds[] = isset($_POST["time_scheme_column_id_{$row}_{$num}"]) ? $_POST["time_scheme_column_id_{$row}_{$num}"] : $this->timeSchemeColumnModel->insertID();
				}
			}

			// Remove not posted entities
			$this->timeSchemeModel->removeFromScheme($timeSchemeIds, $schemeId);
			$this->timeSchemeRowModel->removeFromScheme($timeSchemeRowIds, $schemeId);
			$this->timeSchemeColumnModel->removeFromScheme($timeSchemeColumnIds, $schemeId);
		}

		$timeSchemes = $this->timeSchemeModel->getTimeSchemes($schemeId);
		$timeSchemeRows = $this->timeSchemeRowModel->getTimeSchemeRows($schemeId);

		foreach ($timeSchemeRows as $timeSchemeRowKey => $timeSchemeRow) {
			foreach ($timeSchemes as $timeScheme) {
				$timeSchemeRows[$timeSchemeRowKey]['timeSchemeColumns'][$timeScheme['id']] = $this->timeSchemeColumnModel->getTimeSchemeRows($timeSchemeRow['id'], $timeScheme['id']);
			}
		}

		$data['scheme'] = $scheme;
		$data['timeSchemes'] = $timeSchemes;
		$data['timeSchemeRows'] = $timeSchemeRows;

		return view('pages/schedule/edit', $data);
	}
	
	public function export()
	{
		$schemeId = $this->request->uri->getSegment(3);
		$exportMethod = $this->request->uri->getSegment(4);
		
		$scheme = $this->schemeModel->getScheme($schemeId);
		
		if ($scheme == null) {
			die('Error: This scheme does not exist.');
		}
		
		if ($exportMethod === '') {
			$exportMethod = 'html';
		}
		
		switch ($exportMethod) {
			case 'html':
				$timeSchemes = $this->timeSchemeModel->getTimeSchemes($schemeId);
				$timeSchemeRows = $this->timeSchemeRowModel->getTimeSchemeRows($schemeId);
				$timeSchemeColumns = [];

				// Format column values
				setlocale(LC_TIME, ['nl_NL', 'nld_nld']);
				foreach ($timeSchemeRows as $row) {
					foreach ($timeSchemes as $timeScheme) {
						$column = $this->timeSchemeColumnModel->getTimeSchemeColumn($row['id'], $timeScheme['id']);
						$column['timeFrom'] = $column['timeFrom'] !== '00:00:00' ? date('H:i', strtotime($column['timeFrom'])) : '';
						$column['timeTo'] = $column['timeTo'] !== '00:00:00' ? date('H:i', strtotime($column['timeTo'])) : '';
						$timeSchemeColumns[$row['id']][$timeScheme['id']] = $column;
					}
				}

				$data['timeSchemes'] = $timeSchemes;
				$data['timeSchemeRows'] = $timeSchemeRows;
				$data['timeSchemeColumns'] = $timeSchemeColumns;

				$export = view('exports/schedule/html', $data);
				
				unset($data);
				
				$data['export'] = $export;
				$data['scheme'] = $scheme;
				
				return view('pages/schedule/export', $data);
				
				break;
			
			default:
				die('Error: The desired export method does not exist.');
				break;
		}
	}
}
