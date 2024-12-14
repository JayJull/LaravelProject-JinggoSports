<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testViewDivisi()
    {
        $viewDivisi = $this->get(route('divisi'));
        $viewDivisi->assertStatus(200);
        $viewDivisi->assertSee('Futsal');
    }

    public function testTambahDivisi()
    {
        $requestData = [
            'nama' => 'Tenis'
        ];

        $tambahData = $this->post(route('storeDivisi'), $requestData);
        $tambahData->assertRedirect(route('divisi'));
        $tambahData->assertSee('Create Data Divisi');

        $this->assertDatabaseHas('divisis', [
            'nama' => 'Tenis',
        ]);

        

    }

    public function testTambahDivisiGagalNamaKosong()
    {
    $requestData = [
        'nama' => '',
    ];

    $response = $this->post(route('storeDivisi'), $requestData);
    $response->assertStatus(302);


    $response->assertSessionHasErrors('nama');
    $errors = session('errors')->get('nama');
    $this->assertEquals(['Nama tidak boleh kosong.'], $errors);
    }

    public function testTambahDivisiGagalNamaAngka()
    {
    $requestData = [
        'nama' => 'Berenang123',
    ];

    $response = $this->post(route('storeDivisi'), $requestData);
    $response->assertStatus(302);


    $response->assertSessionHasErrors('nama');
    $errors = session('errors')->get('nama');
    $this->assertEquals(['Nama tidak boleh mengandung angka atau karakter khusus.'], $errors);
    }
    public function testEditDivisi()
    {
        $divisi = Divisi::create([
            'nama' => 'Pemanah',
        ]);

        $updatedData = [
            'nama' => 'Panjat Tebing',
        ];

        $response = $this->post(route('ubahedit', $divisi->id_divisi), $updatedData);


        $response->assertRedirect(route('divisi'));

        $this->assertDatabaseHas('divisis', [
            'id_divisi' => $divisi->id_divisi,
            'nama' => 'Panjat Tebing',
        ]);
        $response->assertSessionHas('toast_success', 'Divisi berhasil diperbarui.');
    }

    // public function testEditDivisiNamaKosongAngka()
    // {
    //     $divisi = Divisi::create([
    //         'nama' => 'Pemanah',
    //     ]);

    //     $updatedData = [
    //         'nama' => 'pemanah123'
    //     ];

    //     $response = $this->post(route('ubahedit', ['id_divisi' => $divisi->id_divisi]), $updatedData);

    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('editdivisi', ['id_divisi' => $divisi->id_divisi]));

    //     $errors = session('errors')->get('nama');
    //     $this->assertSee(['Nama tidak boleh mengandung angka atau karakter khusus.'], $errors);
    // }
    public function testHapusDivisi()
    {
        $divisi = Divisi::create([
            'nama' => 'Panahan',
        ]);
        $id_divisi = $divisi->id_divisi;
        $response = $this->delete(route('hapusdivisi', $id_divisi));

        $response->assertStatus(302);
        $response->assertRedirect(route('divisi'));
        $response->assertSessionHas('toast_success', 'Data Berhasil Dihapus');

        $this->assertDatabaseMissing('divisis', [
            'id_divisi' => $id_divisi,
        ]);
    }
}
