<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlbumSeeder extends Seeder
{
	public function run()
	{
        $data = [
            ['id_artista' => '1', 'nome' => 'Harakiri'],
            ['id_artista' => '1', 'nome' => 'Black Blooms'],
            ['id_artista' => '1', 'nome' => 'The Rough Dog'],
            ['id_artista' => '2', 'nome' => 'The Rising Tied'],
            ['id_artista' => '2', 'nome' => 'Post Traumatic'],
            ['id_artista' => '2', 'nome' => 'Post Traumatic EP'],
            ['id_artista' => '2', 'nome' => 'Where\'d You Go'],
            ['id_artista' => '3', 'nome' => 'Bem Sertanejo'],
            ['id_artista' => '3', 'nome' => 'Bem Sertanejo - O Show (Ao Vivo)'],
            ['id_artista' => '3', 'nome' => 'Bem Sertanejo - (1ª Temporada) - EP'],
            ['id_artista' => '4', 'nome' => 'Use Your IIIlusion I'],
            ['id_artista' => '4', 'nome' => 'Use Your IIIlusion II'],
            ['id_artista' => '4', 'nome' => 'Greatest Hits']
        ];
        $this->db->table('albuns')->insertBatch($data);
	}
}
