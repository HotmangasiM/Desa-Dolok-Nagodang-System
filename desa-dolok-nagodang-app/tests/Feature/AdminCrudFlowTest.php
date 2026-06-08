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
use Illuminate\Http\UploadedFile;
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
            'family_card_number' => 'KK-1234567890ABC',
            'birth_place' => 'Medan-123!',
            'birth_date' => now()->addDay()->toDateString(),
            'education' => 'S1-Teknik!',
            'occupation' => 'Petani123!',
            'rt' => '0A!',
            'rw' => '1@',
            'village' => 'Dolok-123!',
            'district' => 'Uluan-1',
            'regency' => 'Toba!',
            'province' => 'Sumut123',
            'postal_code' => 'ABCDE',
            'phone' => '0812-ABC!',
            'email' => 'emailtanpaat',
            'gender' => 'Laki-laki',
            'life_status' => 'alive',
        ])->assertSessionHasErrors([
            'nik',
            'full_name',
            'family_card_number',
            'birth_place',
            'birth_date',
            'education',
            'occupation',
            'rt',
            'rw',
            'village',
            'district',
            'regency',
            'province',
            'postal_code',
            'phone',
            'email',
        ]);

        $this->post(route('admin.citizens.store'), [
            'nik' => '1234567890123456',
            'full_name' => 'QA Citizen',
            'gender' => 'Laki-laki',
            'birth_place' => 'Dolok Nagodang',
            'birth_date' => '1990-01-01',
            'education' => 'Sarjana',
            'occupation' => 'Petani',
            'family_card_number' => '1234567890123450',
            'address' => 'Dusun QA',
            'rt' => '1',
            'rw' => '2',
            'village' => 'Dolok Nagodang',
            'district' => 'Uluan',
            'regency' => 'Toba',
            'province' => 'Sumatera Utara',
            'postal_code' => '22386',
            'phone' => '081234567890',
            'email' => 'qa.citizen@desa.test',
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
            'family_card_number' => '1234567890123451',
            'education' => 'Magister',
            'occupation' => 'Guru',
            'address' => 'Dusun QA Updated',
            'rt' => '3',
            'rw' => '4',
            'village' => 'Dolok Nagodang',
            'district' => 'Laguboti',
            'regency' => 'Toba',
            'province' => 'Sumatera Utara',
            'postal_code' => '22381',
            'phone' => '081111111111',
            'email' => 'qa.citizen.updated@desa.test',
            'life_status' => 'deceased',
        ])->assertRedirect(route('admin.citizens.index'));

        $this->assertDatabaseHas('citizens', [
            'id' => $citizen->id,
            'full_name' => 'QA Citizen Updated',
            'gender' => 'Perempuan',
            'family_card_number' => '1234567890123451',
            'education' => 'Magister',
            'occupation' => 'Guru',
            'rt' => '3',
            'rw' => '4',
            'village' => 'Dolok Nagodang',
            'district' => 'Laguboti',
            'regency' => 'Toba',
            'province' => 'Sumatera Utara',
            'postal_code' => '22381',
            'phone' => '081111111111',
            'email' => 'qa.citizen.updated@desa.test',
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
        $today = now()->toDateString();
        $uploadedAtDate = now()->copy()->month(8)->day(15)->hour(10)->minute(0);

        if ($uploadedAtDate->lt(now())) {
            $uploadedAtDate->addYear();
        }

        $uploadedAt = $uploadedAtDate->format('Y-m-d\TH:i');

        $this->post(route('admin.news.store'), [
            'title' => 'QA News Invalid File',
            'content' => 'Konten berita QA',
            'status' => 'published',
            'published_at' => $uploadedAt,
            'image' => UploadedFile::fake()->create('thumbnail.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors([
            'image',
        ]);

        $this->post(route('admin.news.store'), [
            'title' => 'QA News Invalid Date',
            'content' => 'Konten berita QA',
            'status' => 'published',
            'published_at' => now()->subDay()->format('Y-m-d\TH:i'),
        ])->assertSessionHasErrors([
            'published_at',
        ]);

        $this->post(route('admin.news.store'), [
            'title' => 'QA News Title',
            'content' => '<h2>Judul Bagian</h2><p style="margin-left: 40px;"><strong>Konten tebal QA</strong></p><ul><li>Poin pertama</li></ul><a href="https://desa.test" onclick="alert(1)">Tautan Desa</a><script>alert("xss")</script>',
            'status' => 'published',
            'published_at' => $uploadedAt,
        ])->assertRedirect(route('admin.news.index'));

        $news = News::where('title', 'QA News Title')->firstOrFail();
        $publishedDateIndonesian = $news->published_at->locale('id')->translatedFormat('d F Y');
        $publishedDateEnglish = $news->published_at->format('d F Y');

        $this->assertSame('qa-news-title', $news->slug);
        $this->assertStringContainsString('<strong>Konten tebal QA</strong>', $news->content);
        $this->assertStringContainsString('<ul><li>Poin pertama</li></ul>', $news->content);
        $this->assertStringNotContainsString('<script>', $news->content);
        $this->assertStringNotContainsString('onclick', $news->content);

        $this->get(route('public.news.show', $news->slug))
            ->assertOk()
            ->assertSee($publishedDateIndonesian)
            ->assertDontSee($publishedDateEnglish)
            ->assertSee('<strong>Konten tebal QA</strong>', false)
            ->assertSee('<ul><li>Poin pertama</li></ul>', false)
            ->assertDontSee('alert("xss")', false)
            ->assertDontSee('onclick="alert(1)"', false);

        $this->put(route('admin.news.update', $news), [
            'title' => 'QA News Title Updated',
            'content' => '<h3>Subjudul Update</h3><ol><li>Langkah pertama</li></ol><blockquote>Catatan penting</blockquote>',
            'status' => 'draft',
            'published_at' => $uploadedAt,
        ])->assertRedirect(route('admin.news.index'));
        $news->refresh();
        $this->assertSame('draft', $news->status);
        $this->assertStringContainsString('<h3>Subjudul Update</h3>', $news->content);
        $this->assertStringContainsString('<ol><li>Langkah pertama</li></ol>', $news->content);

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
            'name' => 'QA Official Invalid',
            'position' => 'Kepala QA',
            'term_end' => '2026-12-31',
        ])->assertSessionHasErrors([
            'term_end',
        ]);

        $this->post(route('admin.officials.store'), [
            'name' => 'QA Official',
            'position' => 'Kepala QA',
            'phone' => '080000000001',
            'email' => 'official@desa.test',
            'term_start' => '2026-01-01',
            'term_end' => '2026-12-31',
            'sort_order' => 1,
        ])->assertRedirect(route('admin.officials.index'));

        $official = Official::where('name', 'QA Official')->firstOrFail();
        $this->put(route('admin.officials.update', $official), [
            'name' => 'QA Official Updated',
            'position' => 'Sekretaris QA',
            'phone' => '080000000002',
            'email' => 'official-updated@desa.test',
            'term_start' => '2026-02-01',
            'term_end' => '2026-11-30',
            'sort_order' => 2,
        ])->assertRedirect(route('admin.officials.index'));
        $this->assertDatabaseHas('officials', [
            'id' => $official->id,
            'phone' => '080000000002',
            'term_start' => '2026-02-01 00:00:00',
            'term_end' => '2026-11-30 00:00:00',
        ]);

        $this->delete(route('admin.officials.destroy', $official))->assertRedirect(route('admin.officials.index'));
        $this->assertSoftDeleted('officials', ['id' => $official->id]);

        $this->post(route('admin.letters.store'), [
            'letter_type_id' => $letterType->id,
            'citizen_id' => $citizen->id,
            'subject' => 'Surat QA Invalid',
            'status' => 'submitted',
            'submission_date' => $today,
            'payload' => [
                'child_name' => 'Anak 123!',
                'child_birth' => 'Balige @ 2005_01_01',
                'child_gender' => 'Laki-laki1',
                'child_job' => 'Pelajar123!',
                'child_religion' => 'Islam@',
                'child_address' => 'Dusun QA #1',
                'business_name' => 'Warung 123!',
                'business_type' => 'Perdagangan @Pasar',
                'father_name' => 'Ayah 123!',
                'mother_name' => 'Ibu @QA',
                'guardian_name' => 'Wali #1',
            ],
        ])->assertSessionHasErrors([
            'payload.child_name',
            'payload.child_birth',
            'payload.child_gender',
            'payload.child_job',
            'payload.child_religion',
            'payload.child_address',
            'payload.business_name',
            'payload.business_type',
            'payload.father_name',
            'payload.mother_name',
            'payload.guardian_name',
        ]);

        $this->post(route('admin.letters.store'), [
            'letter_type_id' => $letterType->id,
            'citizen_id' => $citizen->id,
            'subject' => 'Surat QA Invalid Date Past',
            'status' => 'submitted',
            'submission_date' => now()->subDay()->toDateString(),
        ])->assertSessionHasErrors([
            'submission_date',
        ]);

        $this->post(route('admin.letters.store'), [
            'letter_type_id' => $letterType->id,
            'citizen_id' => $citizen->id,
            'subject' => 'Surat QA Invalid Date Future',
            'status' => 'submitted',
            'submission_date' => now()->addDay()->toDateString(),
        ])->assertSessionHasErrors([
            'submission_date',
        ]);

        $this->post(route('admin.letters.store'), [
            'letter_type_id' => $letterType->id,
            'citizen_id' => $citizen->id,
            'subject' => 'Surat QA',
            'status' => 'submitted',
            'submission_date' => $today,
            'payload' => [
                'purpose' => 'Testing QA',
                'father_income' => '500000',
                'mother_income' => 'Rp. 750.000/Bulan',
                'child_name' => 'Anak QA',
                'child_birth' => 'Balige, 2005-01-01',
                'child_gender' => 'Laki laki',
                'child_job' => 'Pelajar',
                'child_religion' => 'Islam',
                'child_address' => 'Dusun QA, RT 1/RW 2',
                'business_name' => 'Warung Sembako',
                'business_type' => 'Perdagangan',
                'father_name' => 'Ayah QA',
                'mother_name' => 'Ibu QA',
                'guardian_name' => 'Wali QA',
            ],
        ])->assertRedirect(route('admin.letters.index'));

        $letter = Letter::where('subject', 'Surat QA')->firstOrFail();
        $this->assertSame('SUBMITTED', $letter->status);
        $this->assertSame($citizen->nik, $letter->applicant_national_id);
        $this->assertSame('Rp 500.000', $letter->payload['father_income']);
        $this->assertSame('Rp 750.000', $letter->payload['mother_income']);
        $this->assertSame('Anak QA', $letter->payload['child_name']);
        $this->assertSame('Balige, 2005-01-01', $letter->payload['child_birth']);
        $this->assertSame('Laki laki', $letter->payload['child_gender']);
        $this->assertSame('Pelajar', $letter->payload['child_job']);
        $this->assertSame('Islam', $letter->payload['child_religion']);
        $this->assertSame('Dusun QA, RT 1/RW 2', $letter->payload['child_address']);
        $this->assertSame('Warung Sembako', $letter->payload['business_name']);
        $this->assertSame('Perdagangan', $letter->payload['business_type']);
        $this->assertSame('Ayah QA', $letter->payload['father_name']);
        $this->assertSame('Ibu QA', $letter->payload['mother_name']);
        $this->assertSame('Wali QA', $letter->payload['guardian_name']);

        $this->put(route('admin.letters.update', $letter->id), [
            'letter_number' => $letter->letter_number,
            'letter_type_id' => $letterType->id,
            'citizen_id' => $citizen->id,
            'subject' => 'Surat QA Updated',
            'status' => 'completed',
            'submission_date' => $today,
            'payload' => [
                'purpose' => 'Testing QA Updated',
                'father_income' => '1000000',
                'mother_income' => '1250000',
                'child_name' => 'Anak QA Update',
                'child_birth' => 'Balige, 2005-02-02',
                'child_gender' => 'Perempuan',
                'child_job' => 'Mahasiswa',
                'child_religion' => 'Kristen',
                'child_address' => 'Dusun QA Baru, RT 3/RW 4',
                'business_name' => 'Kedai Kopi',
                'business_type' => 'Jasa',
                'father_name' => 'Ayah QA Update',
                'mother_name' => 'Ibu QA Update',
                'guardian_name' => 'Wali QA Update',
            ],
        ])->assertRedirect(route('admin.letters.index'));

        $letter->refresh();

        $this->assertDatabaseHas('letters', [
            'id' => $letter->id,
            'subject' => 'Surat QA Updated',
            'status' => 'COMPLETED',
        ]);
        $this->assertSame('Rp 1.000.000', $letter->payload['father_income']);
        $this->assertSame('Rp 1.250.000', $letter->payload['mother_income']);
        $this->assertSame('Anak QA Update', $letter->payload['child_name']);
        $this->assertSame('Balige, 2005-02-02', $letter->payload['child_birth']);
        $this->assertSame('Perempuan', $letter->payload['child_gender']);
        $this->assertSame('Mahasiswa', $letter->payload['child_job']);
        $this->assertSame('Kristen', $letter->payload['child_religion']);
        $this->assertSame('Dusun QA Baru, RT 3/RW 4', $letter->payload['child_address']);
        $this->assertSame('Kedai Kopi', $letter->payload['business_name']);
        $this->assertSame('Jasa', $letter->payload['business_type']);
        $this->assertSame('Ayah QA Update', $letter->payload['father_name']);
        $this->assertSame('Ibu QA Update', $letter->payload['mother_name']);
        $this->assertSame('Wali QA Update', $letter->payload['guardian_name']);

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
