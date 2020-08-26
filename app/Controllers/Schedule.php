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
			
			foreach ($_POST['timeSchemeNum'] as $num) {
				$data = [
					'schemeId' => $schemeId,
					'name' => $_POST['name_col_' . $num],
					'timeFrom' => $_POST['time_from_col_' . $num],
					'timeTo' => $_POST['time_to_col_' . $num]
				];
				
				$this->timeSchemeModel->save($data);
				$timeSchemeIds[$num] = $this->timeSchemeModel->insertID();
			}
			
			foreach ($_POST['rows'] as $row) {
				$data = [
					'schemeId' => $schemeId,
					'date' => $_POST['date' . $row],
					'note' => $_POST['note' . $row]
				];
				
				$this->timeSchemeRowModel->save($data);
				$timeSchemeRowId = $this->timeSchemeRowModel->insertID();
				
				foreach ($_POST['timeSchemeNum'] as $num) {
					$data = [
						'rowId' => $timeSchemeRowId,
						'timeSchemeId' => $timeSchemeIds[$num],
						'timeFrom' => $_POST['time_from' . $row . '_' . $num],
						'timeTo' => $_POST['time_to' . $row . '_' . $num]
					];
					
					$this->timeSchemeColumnModel->save($data);
				}
			}
			
			die('Saved succesfully');
		}
		
		return view('pages/schedule_create');
	}
}
