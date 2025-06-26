<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_with_correct_credentials()
    {
        // Membuat akun admin dummy
        $admin = Admin::factory()->create([
            'username' => 'adminuser',
            'password' => bcrypt('password123'),
        ]);

        // Proses login
        $response = $this->post('/login', [
            'username' => 'adminuser',
            'password' => 'password123',
        ]);

        // Pastikan redirect ke dashboard
        $response->assertRedirect('/admin/dashboard');

        // Pastikan autentikasi sebagai admin
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_cannot_login_with_wrong_credentials()
    {
        $admin = Admin::factory()->create([
            'username' => 'adminuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'adminuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest('admin');
    }
}
