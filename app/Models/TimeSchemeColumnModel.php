<?php namespace App\Models;

use CodeIgniter\Model;

class TimeSchemeColumnModel extends Model
{
	protected $table = 'time_scheme_column';
	
	protected $allowedFields = ['rowId', 'timeSchemeId', 'timeFrom', 'timeTo'];
}
