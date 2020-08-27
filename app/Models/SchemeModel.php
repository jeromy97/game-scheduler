<?php namespace App\Models;

use CodeIgniter\Model;

class SchemeModel extends Model
{
	protected $table = 'scheme';
	
	protected $allowedFields = ['name', 'dateFrom', 'dateTo'];
	
	public function getAll()
	{
		return $this->orderBy('createdAt', 'desc')
			->findAll();
	}
}
