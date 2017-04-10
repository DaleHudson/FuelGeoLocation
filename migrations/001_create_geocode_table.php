<?php

namespace Fuel\Migrations;

class Create_Geocode_Table
{
	protected $table_name = "geocode";

	public function up()
	{
		try
		{
			\DB::start_transaction();

			\DBUtil::create_table($this->table_name, array(
				'id' => array('type' => 'int', 'auto_increment' => true, 'unsigned' => true),
				'search_term' => array('constraint' => 255, 'type' => 'varchar'),
				'longitude' => array('type' => 'Decimal(9,6)'),
				'latitude' => array('type' => 'Decimal(9,6)'),
				'search_result' => array('type' => 'text'),
				'created_at' => array('constraint' => 11, 'type' => 'int'),
				'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			), array('id'), true, 'InnoDB', 'utf8_unicode_ci');

			\DB::commit_transaction();
		}
		catch (\Exception $e)
		{
			\DB::rollback_transaction();
			\Cli::error(sprintf('Up Migration Failed - %s - %s', $e->getMessage(), __FILE__));
			return false;
		}

		\Cli::write(sprintf('Migrated Up Successfully %s', __FILE__), 'green');
	}

	public function down()
	{
		try
		{
			\DB::start_transaction();

			\DBUtil::drop_table($this->table_name);

			\DB::commit_transaction();
		}
		catch (\Exception $e)
		{
			\DB::rollback_transaction();
			\Cli::error(sprintf('Down Migration Failed - %s - %s', $e->getMessage(), __FILE__));
			return false;
		}

		\Cli::write(sprintf('Migrated Down Successfully %s', __FILE__), 'green');
	}
}