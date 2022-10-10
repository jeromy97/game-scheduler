<?php namespace App\Database\Migrations;

class AddDbRelations extends \CodeIgniter\Database\Migration {
	
	protected $forge;
	protected $db;
	
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->forge = \Config\Database::forge();
	}
	
	public function up()
	{
		$this->db->query("ALTER TABLE `scheme` ENGINE=InnoDB;");
		$this->db->query("ALTER TABLE `time_scheme` ENGINE=InnoDB;");
		$this->db->query("ALTER TABLE `time_scheme_column` ENGINE=InnoDB;");
		$this->db->query("ALTER TABLE `time_scheme_row` ENGINE=InnoDB;");
	}

	public function down()
	{
		$this->db->query("ALTER TABLE `scheme` ENGINE=MyISAM;");
		$this->db->query("ALTER TABLE `time_scheme` ENGINE=MyISAM;");
		$this->db->query("ALTER TABLE `time_scheme_column` ENGINE=MyISAM;");
		$this->db->query("ALTER TABLE `time_scheme_row` ENGINE=MyISAM;");
	}
}
