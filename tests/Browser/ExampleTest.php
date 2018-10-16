<?php

namespace Tests\Browser;

use App\Models\AdminUser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
//        $user = factory(AdminUser::class)->create([
//            'username' => 'admin',
//            'password' => bcrypt('admin')
//        ]);
        $this->browse(function ($browser) {
//            $first->loginAs(AdminUser::find(1))
//                ->visit('/admin');
            $browser->visit('/admin/login')
                ->type('username','admin')
                ->type('password','admin')
                ->press('登陆')
                ->assertPathIs('/admin');
        });
    }
}
