<?php namespace App\Models;

use CodeIgniter\Model;

class TimeSchemeModel extends Model
{
	protected $table = 'time_scheme';
	
	protected $allowedFields = ['schemeId', 'name', 'timeFrom', 'timeTo'];
}
