<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCreateCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_create_command_creates_active_admin(): void
    {
        $this->artisan('admin:create', [
            '--name' => 'Admin Produksi',
            '--email' => 'admin.production@desa.test',
            '--password' => 'StrongPassword123!',
        ])->assertSuccessful();

        $user = User::where('email', 'admin.production@desa.test')->firstOrFail();

        $this->assertSame('Admin Produksi', $user->name);
        $this->assertSame('admin', $user->role);
        $this->assertTrue($user->is_active);
        $this->assertTrue(Hash::check('StrongPassword123!', $user->password));
    }

    public function test_admin_create_command_rejects_duplicate_email_without_force(): void
    {
        User::factory()->create([
            'email' => 'admin.production@desa.test',
        ]);

        $this->artisan('admin:create', [
            '--name' => 'Admin Baru',
            '--email' => 'admin.production@desa.test',
            '--password' => 'StrongPassword123!',
        ])->assertFailed();
    }

    public function test_admin_create_command_can_update_existing_admin_with_force(): void
    {
        User::factory()->create([
            'name' => 'Admin Lama',
            'email' => 'admin.production@desa.test',
            'is_active' => false,
        ]);

        $this->artisan('admin:create', [
            '--name' => 'Admin Baru',
            '--email' => 'admin.production@desa.test',
            '--password' => 'StrongPassword123!',
            '--force' => true,
        ])->assertSuccessful();

        $user = User::where('email', 'admin.production@desa.test')->firstOrFail();

        $this->assertSame('Admin Baru', $user->name);
        $this->assertSame('admin', $user->role);
        $this->assertTrue($user->is_active);
        $this->assertTrue(Hash::check('StrongPassword123!', $user->password));
    }
}
