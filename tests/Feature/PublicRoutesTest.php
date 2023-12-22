<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    public function test_public_routes_can_be_accessed()
    {
        // Public routes guest visitors can access
        $response = $this->get('/');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);

        $response = $this->get('/info/a-munka-kulonboztet-meg-teged');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);

        $response = $this->get('/kategoria/kizomba');
        $response->assertSee('Kizomba');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);

        $response = $this->get('/cimke/semba');
        $response->assertSee('Semba');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);

        $response = $this->get('/esemenynaptar');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);

        $response = $this->get('/esemeny/budapest-kizomba-connection-bkc2023-11th-edition-31aug4sept');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);


        // Public auth routes (not logged-in users can access them)
        // registration route is disabled
        $response = $this->get('/admin/nikilogin');
        $response->assertSee('Belépés');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);

        $response = $this->get('/admin/password/reset');
        $response->assertHeader('content-type','text/html; charset=UTF-8');
        $response->assertStatus(200);
    }
}
