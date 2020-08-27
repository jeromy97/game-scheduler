<?php

function getTimeSchemeColumn($rowId, $timeSchemeId)
{
	$db = \Config\Database::connect();
	
	$result = $db->table('time_scheme_column')
		->where(['rowId' => $rowId, 'timeSchemeId' => $timeSchemeId])
		->get()
		->getRowArray();
	
	return $result;
}
