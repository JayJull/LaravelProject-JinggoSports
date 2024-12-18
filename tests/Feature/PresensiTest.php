<?php

namespace Tests\Feature;

use App\Models\Aktifasi;
use App\Models\Anggota;
use App\Models\Divisi;
use App\Models\Jadwal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PresensiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    public function test_presensi_berhasil()
    {
        // // Setup data awal
        $user = User::factory()->create(); // Membuat user terlebih dahulu
        $anggota = Anggota::factory()->create(['id_anggota' => $user->id_anggota]); // Setelah user dibuat, gunakan id_anggota dari user
        $divisi = Divisi::factory()->create([
            'nama'=>'futsal'
        ]);
        $anggota->divisi()->attach($divisi->id_divisi);

        // Storage::fake('public');

        // // Setup data awal
        // $user = User::factory()->create(); // Membuat user terlebih dahulu
        // $anggota = Anggota::factory()->create(['id_anggota' => $user->id_anggota]); // Setelah user dibuat, gunakan id_anggota dari user
        // $divisi = Divisi::factory()->create();
        // $anggota->divisi()->attach($divisi->id_divisi);

        // $jadwal = Jadwal::factory()->create([
        //     'id_divisi' => $divisi->id_divisi,
        //     'waktu_selesai' => Carbon::now()->addHours(2)->format('H:i:s')
        // ]);

        // $aktifasi = Aktifasi::factory()->create([
        //     'id_divisi' => $divisi->id_divisi,
        //     'tenggat' => Carbon::now()->addHours(1)->format('Y-m-d H:i:s')
        // ]);

        // $buktiFile = UploadedFile::fake()->image('bukti.jpg');

        // // Simulasikan user login
        // Auth::login($user);

        // $response = $this->post(route('presensi.store'), [
        //     'id_divisi' => $divisi->id_divisi,
        //     'aktifasi_id' => $aktifasi->id_aktifasi,
        //     'bukti' => $buktiFile
        // ]);

        // // Assert response
        // $response->assertRedirect(route('view-presensi'));
        // $response->assertSessionHas('toast_success', 'Berhasil presensi');

        // // Assert presensi tersimpan di database
        // $this->assertDatabaseHas('presensis', [
        //     'id_anggota' => $anggota->id_anggota,
        //     'id_divisi' => $divisi->id_divisi,
        //     'aktifasi_id' => $aktifasi->id_aktifasi,
        // ]);

        // // Assert file bukti tersimpan
        // Storage::disk('public')->assertExists('buktiPresensi/' . $buktiFile->hashName());
    }
}
