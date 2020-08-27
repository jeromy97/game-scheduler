<?php namespace App\Models;

use CodeIgniter\Model;

class TimeSchemeModel extends Model
{
	protected $table = 'time_scheme';
	
	protected $allowedFields = ['schemeId', 'name', 'timeFrom', 'timeTo'];
	
	public function getTimeSchemes($schemeId)
	{
		return $this->where('schemeId', $schemeId)
			->findAll();
	}
}
