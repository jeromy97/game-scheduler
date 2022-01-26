<?php namespace App\Models;

use CodeIgniter\Model;

class TimeSchemeRowModel extends Model
{
	protected $table = 'time_scheme_row';
	
	protected $allowedFields = ['schemeId', 'date', 'note'];
	
	public function getTimeSchemeRows($schemeId)
	{
		return $this->where('schemeId', $schemeId)
			->orderBy('id', 'ASC')
			->findAll();
	}
	
	public function removeFromScheme(array $ids, int $schemeId)
	{
		$this->whereNotIn('id', $ids)
			->where('schemeId', $schemeId)
			->delete();
	}
}
