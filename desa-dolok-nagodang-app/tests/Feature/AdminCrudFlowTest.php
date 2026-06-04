<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Citizen;
use App\Models\Letter;
use App\Models\LetterType;
use App\Models\News;
use App\Models\Official;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'QA Admin',
            'email' => 'qa-admin@desa.test',
            'password' => 'admin12345',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_citizen_crud_flow(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.citizens.index'))->assertOk();

        $this->post(route('admin.citizens.store'), [])->assertSessionHasErrors([
            'nik',
            'full_name',
            'gender',
            'life_status',
        ]);

        $this->post(route('admin.citizens.store'), [
            'nik' => 'ABC4567890123456',
            'full_name' => 'QA Citizen 123!',
            'gender' => 'Laki-laki',
            'life_status' => 'alive',
        ])->assertSessionHasErrors([
            'nik',
            'full_name',
        ]);

        $this->post(route('admin.citizens.store'), [
            'nik' => '1234567890123456',
            'full_name' => 'QA Citizen',
            'gender' => 'Laki-laki',
            'birth_place' => 'Dolok Nagodang',
            'birth_date' => '1990-01-01',
            'address' => 'Dusun QA',
            'phone' => '081234567890',
            'life_status' => 'alive',
        ])->assertRedirect(route('admin.citizens.index'));

        $citizen = Citizen::where('nik', '1234567890123456')->firstOrFail();

        $this->get(route('admin.citizens.index', ['search' => 'QA Citizen']))
            ->assertOk()
            ->assertSee('QA Citizen');

        $this->put(route('admin.citizens.update', $citizen), [
            'nik' => '1234567890123456',
            'full_name' => 'QA Citizen Updated',
            'gender' => 'Perempuan',
            'address' => 'Dusun QA Updated',
            'phone' => '081111111111',
            'life_status' => 'deceased',
        ])->assertRedirect(route('admin.citizens.index'));

        $this->assertDatabaseHas('citizens', [
            'id' => $citizen->id,
            'full_name' => 'QA Citizen Updated',
            'gender' => 'Perempuan',
            'life_status' => 'deceased',
        ]);

        $this->delete(route('admin.citizens.destroy', $citizen))
            ->assertRedirect(route('admin.citizens.index'));

        $this->assertSoftDeleted('citizens', ['id' => $citizen->id]);
    }

    public function test_admin_news_asset_official_and_letter_crud_flows(): void
    {
        $this->actingAs($this->admin);

        $citizen = Citizen::create([
            'nik' => '6543210987654321',
            'full_name' => 'QA Letter Citizen',
            'gender' => 'Laki-laki',
            'life_status' => 'alive',
        ]);

        $letterType = LetterType::create([
            'name' => 'Surat QA',
            'code' => 'QA',
            'is_active' => true,
        ]);

        $this->post(route('admin.news.store'), [
            'title' => 'QA News Title',
            'content' => 'Konten berita QA',
            'status' => 'published',
            'published_at' => '2026-06-04',
        ])->assertRedirect(route('admin.news.index'));

        $news = News::where('title', 'QA News Title')->firstOrFail();
        $this->assertSame('qa-news-title', $news->slug);

        $this->put(route('admin.news.update', $news), [
            'title' => 'QA News Title Updated',
            'content' => 'Konten berita QA updated',
            'status' => 'draft',
            'published_at' => '2026-06-04',
        ])->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', ['id' => $news->id, 'status' => 'draft']);

        $this->delete(route('admin.news.destroy', $news))->assertRedirect(route('admin.news.index'));
        $this->assertSoftDeleted('news', ['id' => $news->id]);

        $this->post(route('admin.assets.store'), [
            'item_name' => 'QA Asset',
            'item_code' => 'QA-ASSET-001',
            'category' => 'Elektronik',
            'quantity' => 2,
            'condition' => 'good',
            'location' => 'Kantor Desa',
        ])->assertRedirect(route('admin.assets.index'));

        $asset = Asset::where('item_code', 'QA-ASSET-001')->firstOrFail();
        $this->put(route('admin.assets.update', $asset), [
            'item_name' => 'QA Asset Updated',
            'item_code' => 'QA-ASSET-001',
            'category' => 'Elektronik',
            'quantity' => 3,
            'condition' => 'damaged',
            'location' => 'Gudang',
        ])->assertRedirect(route('admin.assets.index'));
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'quantity' => 3, 'condition' => 'damaged']);

        $this->delete(route('admin.assets.destroy', $asset))->assertRedirect(route('admin.assets.index'));
        $this->assertSoftDeleted('assets', ['id' => $asset->id]);

        $this->post(route('admin.officials.store'), [
            'name' => 'QA Official',
            'position' => 'Kepala QA',
            'phone' => '080000000001',
            'email' => 'official@desa.test',
            'sort_order' => 1,
        ])->assertRedirect(route('admin.officials.index'));

        $official = Official::where('name', 'QA Official')->firstOrFail();
        $this->put(route('admin.officials.update', $official), [
            'name' => 'QA Official Updated',
            'position' => 'Sekretaris QA',
            'phone' => '080000000002',
            'email' => 'official-updated@desa.test',
            'sort_order' => 2,
        ])->assertRedirect(route('admin.officials.index'));
        $this->assertDatabaseHas('officials', ['id' => $official->id, 'phone' => '080000000002']);

        $this->delete(route('admin.officials.destroy', $official))->assertRedirect(route('admin.officials.index'));
        $this->assertSoftDeleted('officials', ['id' => $official->id]);

        $this->post(route('admin.letters.store'), [
            'letter_type_id' => $letterType->id,
            'citizen_id' => $citizen->id,
            'subject' => 'Surat QA',
            'status' => 'submitted',
            'submission_date' => '2026-06-04',
            'payload' => ['purpose' => 'Testing QA'],
        ])->assertRedirect(route('admin.letters.index'));

        $letter = Letter::where('subject', 'Surat QA')->firstOrFail();
        $this->assertSame('SUBMITTED', $letter->status);
        $this->assertSame($citizen->nik, $letter->applicant_national_id);

        $this->put(route('admin.letters.update', $letter->id), [
            'letter_number' => $letter->letter_number,
            'letter_type_id' => $letterType->id,
            'citizen_id' => $citizen->id,
            'subject' => 'Surat QA Updated',
            'status' => 'completed',
            'submission_date' => '2026-06-04',
            'payload' => ['purpose' => 'Testing QA Updated'],
        ])->assertRedirect(route('admin.letters.index'));

        $this->assertDatabaseHas('letters', [
            'id' => $letter->id,
            'subject' => 'Surat QA Updated',
            'status' => 'COMPLETED',
        ]);

        $this->delete(route('admin.letters.destroy', $letter->id))
            ->assertRedirect(route('admin.letters.index'));
        $this->assertDatabaseMissing('letters', ['id' => $letter->id]);
    }

    public function test_admin_dashboard_and_public_letter_application_are_production_safe(): void
    {
        $this->actingAs($this->admin);

        $citizen = Citizen::create([
            'nik' => '1111222233334444',
            'full_name' => 'QA Public Applicant',
            'gender' => 'Perempuan',
            'address' => 'Dusun Market Ready',
            'life_status' => 'alive',
        ]);

        $letterType = LetterType::create([
            'name' => 'Surat Market Ready',
            'code' => 'MRD',
            'is_active' => true,
        ]);

        Letter::create([
            'letter_number' => '001/MRD/VI/2026',
            'letter_type_id' => $letterType->id,
            'applicant_national_id' => $citizen->nik,
            'subject' => 'Surat Dashboard QA',
            'payload' => [],
            'submission_date' => '2026-06-04',
            'status' => 'SUBMITTED',
            'created_by' => $this->admin->id,
        ]);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard');

        auth()->logout();

        $this->post(route('public.letters.storeApplication', $letterType->code), [
            'nik' => $citizen->nik,
            'full_name' => $citizen->full_name,
            'phone' => '081299990000',
            'purpose' => 'Keperluan produksi',
        ])->assertRedirect(route('public.letters.apply', $letterType->code));

        $this->assertDatabaseHas('letters', [
            'letter_type_id' => $letterType->id,
            'applicant_national_id' => $citizen->nik,
            'subject' => 'Pengajuan Online - Surat Market Ready',
            'status' => 'SUBMITTED',
            'created_by' => $this->admin->id,
        ]);
    }
}
