<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddArtista extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id_artista' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false
            ]
        ]);
        $this->forge->addPrimaryKey('id_artista');
        $this->forge->createTable('artistas');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('artistas');
	}
}
