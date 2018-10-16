<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUserTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginRoute()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function testPermissionRoute()
    {
//        $this->visit('/admin/login')
//            ->type('username','admin')
//            ->type('password',bcrypt('admin'))
//            ->press('登陆')
//            ->seePageIs('/admin');
    }

}
