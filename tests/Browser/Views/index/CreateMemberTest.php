<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Member;
use Facebook\WebDriver\WebDriverBy;


class CreateMemberTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $url = 'http://localhost:8000';

    public function setUp()
      {
          parent::setUp();
          exec('php artisan migrate:refresh');
      }

    /**
     * Un visiteur arrive sur la page /
     * - Il saisie son email
     * - Il soumet le formulaire
     * - Un message l'informe qu'il va de recevoir un email "index.success"
     *
     * 2 Points
     */
    public function testAddEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url . '/')
                ->value('input[name=email]', 'test@gmail.com')
                ->press(__('member.index.send'))
                ->assertSee(__('success_message'))
                ->assertVisible('.alert-success');
        });
    }

    /**
     * Un visiteur arrive sur la page /
     * - Il saisie son email (déjà existant en base de donnée)
     * - Il soumet le formulaire
     * - Un message l'informe qu'il va de recevoir un email "index.success"
     *
     * 2 Points
     */
     public function testEmailAlreadyExists()
    {
        factory(Member::class)->create([
            Member::EMAIL => 'test'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit($this->url . '/')
                ->value('input[name=email]', 'test')
                ->press(__('member.index.send'))
                ->assertSee(__('already_exist'))
                ->assertVisible('.alert-warning');
        });
    }

    /**
     * Un visiteur arrive sur la page /
     * - Il ne saisi pas d'email
     * - Il soumet le formulaire
     * - Un message l'informe qu'il doit saisir son email
     *
     * 2 Points
     */
     public function testAddRequiredFields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url . '/')
                ->press(__('member.index.send'))
                ->assertSee(__('required_fields'))
                ->assertVisible('.alert-warning');
        });
    }
}
