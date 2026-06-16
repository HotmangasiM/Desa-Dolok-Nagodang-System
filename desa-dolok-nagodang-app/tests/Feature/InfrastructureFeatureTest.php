<?php

namespace Tests\Feature;

use App\Models\Infrastructure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InfrastructureFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Infra Admin',
            'email' => 'infra-admin@desa.test',
            'password' => 'admin12345',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_create_search_update_and_delete_infrastructure(): void
    {
        $this->actingAs($this->admin);

        $futureYear = now()->year + 1;

        $this->post(route('admin.infrastructure.store'), [
            'nama_barang' => 'Jalan Desa',
            'kondisi' => 'Baik',
            'status' => 'publish',
            'tahun_pengadaan' => $futureYear,
        ])->assertSessionHasErrors([
            'tahun_pengadaan',
        ]);

        $this->post(route('admin.infrastructure.store'), [
            'nama_barang' => 'Jalan Desa',
            'kode_barang' => 'INF-001',
            'jenis_barang' => 'Jalan Beton',
            'jumlah_luas' => '120 Meter',
            'nilai_harga' => 150000000,
            'tahun_pengadaan' => now()->year,
            'kondisi' => 'Baik',
            'keterangan' => 'DD',
            'status' => 'publish',
            'content' => 'Pembangunan jalan desa tahap pertama.',
        ])->assertRedirect(route('admin.infrastructure.index'));

        $this->post(route('admin.infrastructure.store'), [
            'nama_barang' => 'Jalan Desa',
            'kode_barang' => 'INF-002',
            'jenis_barang' => 'Drainase',
            'jumlah_luas' => '80 Meter',
            'nilai_harga' => 50000000,
            'tahun_pengadaan' => now()->year - 1,
            'kondisi' => 'Rusak Ringan',
            'keterangan' => 'HIBAH',
            'status' => 'draft',
            'content' => 'Perbaikan drainase lingkungan.',
        ])->assertRedirect(route('admin.infrastructure.index'));

        $published = Infrastructure::where('kode_barang', 'INF-001')->firstOrFail();
        $draft = Infrastructure::where('kode_barang', 'INF-002')->firstOrFail();

        $this->assertSame('jalan-desa', $published->slug);
        $this->assertSame('jalan-desa-2', $draft->slug);

        $this->get(route('admin.infrastructure.index', ['search' => 'INF-001']))
            ->assertOk()
            ->assertSee('Jalan Desa')
            ->assertSee('INF-001')
            ->assertDontSee('INF-002');

        $this->put(route('admin.infrastructure.update', $draft->id), [
            'nama_barang' => 'Drainase Dusun',
            'kode_barang' => 'INF-002',
            'jenis_barang' => 'Drainase',
            'jumlah_luas' => '85 Meter',
            'nilai_harga' => 75000000,
            'tahun_pengadaan' => now()->year,
            'kondisi' => 'Baik',
            'keterangan' => 'ADD',
            'status' => 'publish',
            'content' => 'Drainase dusun sudah diperbarui.',
        ])->assertRedirect(route('admin.infrastructure.index'));

        $draft->refresh();

        $this->assertDatabaseHas('infrastructures', [
            'id' => $draft->id,
            'nama_barang' => 'Drainase Dusun',
            'slug' => 'drainase-dusun',
            'status' => 'publish',
            'keterangan' => 'ADD',
        ]);

        $this->delete(route('admin.infrastructure.destroy', $published->id))
            ->assertRedirect(route('admin.infrastructure.index'));

        $this->assertDatabaseMissing('infrastructures', [
            'id' => $published->id,
        ]);
    }

    public function test_public_infrastructure_only_shows_published_items_and_uses_schema_fields(): void
    {
        $publish = Infrastructure::create([
            'slug' => 'jalan-utama-desa',
            'nama_barang' => 'Jalan Utama Desa',
            'kode_barang' => 'PUB-001',
            'jenis_barang' => 'Jalan Beton',
            'jumlah_luas' => '200 Meter',
            'nilai_harga' => 250000000,
            'tahun_pengadaan' => now()->year,
            'kondisi' => 'Baik',
            'keterangan' => 'DD',
            'status' => 'publish',
            'content' => 'Akses utama desa sudah dibangun dengan beton.',
        ]);

        Infrastructure::create([
            'slug' => 'gudang-draft',
            'nama_barang' => 'Gudang Draft',
            'kode_barang' => 'PUB-002',
            'jenis_barang' => 'Bangunan',
            'jumlah_luas' => '1 Unit',
            'nilai_harga' => 90000000,
            'tahun_pengadaan' => now()->year,
            'kondisi' => 'Baik',
            'keterangan' => 'ADD',
            'status' => 'draft',
            'content' => 'Draft yang tidak boleh muncul ke publik.',
        ]);

        $this->get(route('public.infrastruktur.index'))
            ->assertOk()
            ->assertSee('Jalan Utama Desa')
            ->assertSee('Jalan Beton')
            ->assertSee('Akses utama desa sudah dibangun dengan beton.')
            ->assertDontSee('Gudang Draft');

        $this->get(route('public.infrastruktur.index', ['search' => 'Beton']))
            ->assertOk()
            ->assertSee('Jalan Utama Desa')
            ->assertDontSee('Gudang Draft');

        $this->get(route('public.infrastruktur.show', $publish->slug))
            ->assertOk()
            ->assertSee('Jalan Utama Desa')
            ->assertSee('Akses utama desa sudah dibangun dengan beton.');
    }
}
