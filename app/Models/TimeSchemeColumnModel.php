<?php namespace App\Models;

use CodeIgniter\Model;

class TimeSchemeColumnModel extends Model
{
	protected $table = 'time_scheme_column';
	
	protected $allowedFields = ['rowId', 'timeSchemeId', 'timeFrom', 'timeTo'];

	public function getTimeSchemeRows(int $rowId, int $timeSchemeId)
	{
		return $this->where('rowId', $rowId)
			->where('timeSchemeId', $timeSchemeId)
			->first();
	}
}
