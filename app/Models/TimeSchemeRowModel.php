<?php namespace App\Models;

use CodeIgniter\Model;

class TimeSchemeRowModel extends Model
{
	protected $table = 'time_scheme_row';
	
	protected $allowedFields = ['schemeId', 'date', 'note'];
	
	public function getTimeSchemeRows($schemeId)
	{
		return $this->where('schemeId', $schemeId)
			->findAll();
	}
}
