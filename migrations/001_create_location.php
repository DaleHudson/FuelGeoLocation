<?php

namespace Fuel\Migrations;

class Create_Location
{
	protected $table_name = "location";

	public function up()
	{
		try
		{
			\DB::start_transaction();

			\DBUtil::create_table($this->table_name, array(
				'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
				'postcode' => array('constraint' => 255, 'type' => 'varchar'),
				'quality' => array('type' => 'int'),
				'eastings' => array('type' => 'int'),
				'northings' => array('type' => 'int'),
				'country' => array('constraint' => 255, 'type' => 'varchar'),
				'nhs_ha' => array('constraint' => 255, 'type' => 'varchar'),
				'longitude' => array('type' => 'Decimal(9,6)'),
				'latitude' => array('type' => 'Decimal(9,6)'),
				'parliamentary_constituency' => array('constraint' => 255, 'type' => 'varchar'),
				'european_electoral_region' => array('constraint' => 255, 'type' => 'varchar'),
				'primary_care_trust' => array('constraint' => 255, 'type' => 'varchar'),
				'region' => array('constraint' => 255, 'type' => 'varchar'),
				'lsoa' => array('constraint' => 255, 'type' => 'varchar'),
				'msoa' => array('constraint' => 255, 'type' => 'varchar'),
				'incode' => array('constraint' => 255, 'type' => 'varchar'),
				'outcode' => array('constraint' => 255, 'type' => 'varchar'),
				'admin_district' => array('constraint' => 255, 'type' => 'varchar'),
				'parish' => array('constraint' => 255, 'type' => 'varchar'),
				'admin_county' => array('constraint' => 255, 'type' => 'varchar'),
				'admin_ward' => array('constraint' => 255, 'type' => 'varchar'),
				'ccg' => array('constraint' => 255, 'type' => 'varchar'),
				'nuts' => array('constraint' => 255, 'type'=> 'varchar'),
				'code_admin_district' => array('constraint' => 255, 'type' => 'varchar'),
				'code_admin_county' => array('constraint' => 255, 'type' => 'varchar'),
				'code_admin_ward' => array('constraint' => 255, 'type' => 'varchar'),
				'code_parish' => array('constraint' => 255, 'type' => 'varchar'),
				'code_ccg' => array('constraint' => 255, 'type' => 'varchar'),
				'code_nuts' => array('constraint' => 255, 'type' => 'varchar'),
				'created_at' => array('constraint' => 11, 'type' => 'int'),
				'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			), array('id'), true, 'InnoDB', 'utf8_general_ci');

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