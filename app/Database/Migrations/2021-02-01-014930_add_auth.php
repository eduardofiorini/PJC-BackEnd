<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuth extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id_auth' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
                'null' => false
            ],
        ]);
        $this->forge->addPrimaryKey('id_auth');
        $this->forge->createTable('auth');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('auth');
	}
}
