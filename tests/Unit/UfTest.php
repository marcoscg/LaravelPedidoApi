<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UfTest extends TestCase
{
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetTest()
    {
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->get('/api/uf');

        $response->assertStatus(200);
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostTest()
    {
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->json('POST', '/api/uf', ['uf' => 'PB', 'descricao' => 'PARABIBA']);

        $json = json_decode($response->getContent());

        $this->id = $json->id;

        $response->assertStatus(201);
    }    

    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPutTest()    
    {
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->json('POST', '/api/uf', ['uf' => 'PB', 'descricao' => 'PARABIBA']);

        $json = json_decode($response->getContent());

        $response = $this->json('PUT', '/api/uf/' . $json->id, ['uf' => 'PB', 'descricao' => 'PARABIBA']);

        $response->assertStatus(200);
    }   
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteTest()    
    {
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->json('POST', '/api/uf', ['uf' => 'PB', 'descricao' => 'PARABIBA']);

        $json = json_decode($response->getContent());

        $response = $this->json('DELETE', '/api/uf/' . $json->id);

        $response->assertStatus(200);
    } 
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostErroTest()    
    {
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->json('POST', '/api/uf', ['uf' => 'P', 'descricao' => '']);

        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
        ]);;
    } 
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPutErroTest()    
    {
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->json('PUT', '/api/uf/99999', ['uf' => 'PB', 'descricao' => 'PARAIBA']);

        $response->assertStatus(404)->assertJson([
            'message' => 'Uf não existe!',
        ]);;
    }     
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteErroTest()    
    {
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->json('DELETE', '/api/uf/9999');

        $response->assertStatus(404)->assertJson([
            'message' => 'Uf não existe!',
        ]);;
    }  
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostErroAcessTest()    
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->json('POST', '/api/uf', ['uf' => 'P', 'descricao' => '']);

        $response->assertStatus(401);
    }     
    
}
