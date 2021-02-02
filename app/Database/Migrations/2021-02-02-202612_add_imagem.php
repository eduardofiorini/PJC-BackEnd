<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImagem extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_imagem' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_album' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => false,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ]
        ]);
        $this->forge->addPrimaryKey('id_imagem');
        $this->forge->addForeignKey('id_album', 'albuns', 'id_album');
        $this->forge->createTable('imagens');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('imagens');
    }
}
