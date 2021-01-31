<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArtistaSeeder extends Seeder
{
	public function run()
	{
        $data = [
            ['nome' => 'Serj tankian'],
            ['nome' => 'Mike Shinoda'],
            ['nome' => 'Michel Teló'],
            ['nome' => 'Guns N\' Roses']
        ];
        $this->db->table('artistas')->insertBatch($data);
	}
}
