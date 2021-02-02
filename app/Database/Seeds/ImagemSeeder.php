<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImagemSeeder extends Seeder
{
	public function run()
	{
        $data = [
            ['id_album' => '1',  'nome' => 'Harakiri.jpg'],
            ['id_album' => '2',  'nome' => 'Black Blooms.jpg'],
            ['id_album' => '3',  'nome' => 'The Rough Dog.jpg'],
            ['id_album' => '4',  'nome' => 'The Rising Tied.png'],
            ['id_album' => '5',  'nome' => 'Post Traumatic.jpg'],
            ['id_album' => '6',  'nome' => 'Post Traumatic EP.jpg'],
            ['id_album' => '7',  'nome' => 'Where\'d You Go.jpg'],
            ['id_album' => '8',  'nome' => 'Bem Sertanejo.png'],
            ['id_album' => '9',  'nome' => 'Bem Sertanejo - O Show (Ao Vivo).jpg'],
            ['id_album' => '10', 'nome' => 'Bem Sertanejo - (1ª Temporada) - EP.jpg'],
            ['id_album' => '11', 'nome' => 'Use Your IIIlusion I.jpg'],
            ['id_album' => '12', 'nome' => 'Use Your IIIlusion II.jpg'],
            ['id_album' => '13', 'nome' => 'Greatest Hits.jpg']
        ];
        $this->db->table('imagens')->insertBatch($data);
	}
}
