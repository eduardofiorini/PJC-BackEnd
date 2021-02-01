<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthSeeder extends Seeder
{
	public function run()
	{
        $data = [
            [
                'nome'  => 'Geia PJC',
                'email' => 'geia@pjc.mt.gov.br',
                'senha' => 'cd04919fed4c224f7f3a55f0ec231ffb', //Geia@PJC*
            ]
        ];
        $this->db->table('auth')->insertBatch($data);
	}
}
