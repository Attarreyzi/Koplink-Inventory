<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test apakah halaman utama redirect ke login.
     */
    public function test_homepage_redirects_to_login(): void
    {
        $response = $this->get('/');

        // Memastikan request dialihkan (redirect 302) ke halaman login
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test apakah halaman login bisa diakses dengan baik.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        // Memastikan halaman sukses dimuat (status 200)
        $response->assertStatus(200);
    }

    /**
     * Test apakah halaman admin terlindungi dan redirect ke login jika belum login.
     */
    public function test_admin_dashboard_is_protected(): void
    {
        $response = $this->get('/admin/dashboard');

        // Karena belum login, maka harus diredirect ke halaman login
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
