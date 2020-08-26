<?php namespace App\Database\Migrations;

class InitialMigration extends \CodeIgniter\Database\Migration {
	
	protected $forge;
	protected $db;
	
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->forge = \Config\Database::forge();
	}
	
	public function up()
	{
		$this->db->query("CREATE TABLE `scheme` (
			`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`name` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'latin1_swedish_ci',
			`dateFrom` DATE NOT NULL,
			`dateTo` DATE NOT NULL,
			PRIMARY KEY (`id`) USING BTREE
		)
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM
		;
		");
		
		$this->db->query("CREATE TABLE `time_scheme` (
			`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`schemeId` INT(10) UNSIGNED NOT NULL,
			`createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`name` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'latin1_swedish_ci',
			`timeFrom` TIME NOT NULL,
			`timeTo` TIME NOT NULL,
			PRIMARY KEY (`id`) USING BTREE
		)
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM
		;
		");
		
		$this->db->query("CREATE TABLE `time_scheme_column` (
			`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`rowId` INT(10) UNSIGNED NOT NULL,
			`timeSchemeId` INT(10) UNSIGNED NOT NULL,
			`createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`timeFrom` TIME NOT NULL,
			`timeTo` TIME NOT NULL,
			PRIMARY KEY (`id`) USING BTREE
		)
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM
		;
		");
		
		$this->db->query("CREATE TABLE `time_scheme_row` (
			`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`schemeId` INT(10) UNSIGNED NOT NULL,
			`createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`date` DATE NOT NULL,
			`note` VARCHAR(255) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
			PRIMARY KEY (`id`) USING BTREE
		)
		COLLATE='latin1_swedish_ci'
		ENGINE=MyISAM
		;
		");
	}

	public function down()
	{
		$this->forge->dropTable('scheme');
		$this->forge->dropTable('time_scheme');
		$this->forge->dropTable('time_scheme_row');
		$this->forge->dropTable('time_scheme_column');
	}
}
