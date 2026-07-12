<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCreateCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_account_can_be_created_using_command_options(): void
    {
        $this->artisan('admin:create', [
            '--name' => 'Admin Desa',
            '--email' => 'admin@desa.id',
            '--password' => 'PasswordKuat123!',
        ])->assertSuccessful();

        $user = User::where('email', 'admin@desa.id')->first();

        $this->assertNotNull($user);
        $this->assertSame('Admin Desa', $user->name);
        $this->assertSame('admin', $user->role);
        $this->assertTrue($user->is_active);
        $this->assertTrue(Hash::check('PasswordKuat123!', $user->password));
    }

    public function test_existing_admin_can_be_updated_with_force_option(): void
    {
        User::factory()->create([
            'name' => 'Admin Lama',
            'email' => 'admin@desa.id',
            'password' => Hash::make('PasswordLama123!'),
            'role' => 'staff',
            'is_active' => false,
        ]);

        $this->artisan('admin:create', [
            '--name' => 'Admin Baru',
            '--email' => 'admin@desa.id',
            '--password' => 'PasswordBaru123!',
            '--force' => true,
        ])->assertSuccessful();

        $user = User::where('email', 'admin@desa.id')->firstOrFail();

        $this->assertSame('Admin Baru', $user->name);
        $this->assertSame('admin', $user->role);
        $this->assertTrue($user->is_active);
        $this->assertTrue(Hash::check('PasswordBaru123!', $user->password));
    }
}
