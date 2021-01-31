<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAlbum extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id_album' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_artista' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => false,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false
            ]
        ]);
        $this->forge->addPrimaryKey('id_album');
        $this->forge->addForeignKey('id_artista', 'artistas', 'id_artista');
        $this->forge->createTable('albuns');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('albuns');
	}
}
