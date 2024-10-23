<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimeLineUnitTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_update_timeline(): void
    {
                
        $response = $this->post('/admin/timeline/update/1}',[
            'nama' => 'Megawat',     
            'waktu_mulai' => '2024-10-10',       
            'waktu_berakhir' => '2024-10-20',       
            'status' => '0',       
        ]);
        $this->assertDatabaseHas('time_lines',[
            'nama' => 'Megawat',     
            'waktu_mulai' => '2024-10-10',       
            'waktu_berakhir' => '2024-10-20',       
            'status' => '0',   
        ]);
        $response->assertStatus(302);
    }
}
