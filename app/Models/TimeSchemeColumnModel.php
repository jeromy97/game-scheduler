<?php namespace App\Models;

use CodeIgniter\Model;

class TimeSchemeColumnModel extends Model
{
	protected $table = 'time_scheme_column';
	protected $tableR = 'time_scheme_row';
	
	protected $allowedFields = ['rowId', 'timeSchemeId', 'timeFrom', 'timeTo'];

	public function getTimeSchemeRows(int $rowId, int $timeSchemeId)
	{
		return $this->where('rowId', $rowId)
			->where('timeSchemeId', $timeSchemeId)
			->first();
	}
	
	public function removeFromScheme(array $ids, int $schemeId)
	{
		$i = '';
		foreach ($ids as $id) {
			$i .= "$id, ";
		}
		$i = trim($i, ', ');

		$this->query(
			"DELETE
				$this->table
			FROM
				$this->table
			INNER JOIN
				$this->tableR
			ON
				$this->tableR.id = $this->table.rowId
			WHERE
				$this->table.id NOT IN ($i)
			AND
				$this->tableR.schemeId = " . $this->escape($schemeId) . ""
		);
	}
}
