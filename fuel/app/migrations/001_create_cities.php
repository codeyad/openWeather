<?php

namespace Fuel\Migrations;

class Create_cities
{
	public function up()
	{
		\DBUtil::create_table('cities', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'city' => array('constraint' => 50, 'type' => 'varchar'),
			'state_code' => array('constraint' => 2, 'type' => 'char'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('cities');
	}
}