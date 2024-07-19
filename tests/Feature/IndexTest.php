<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use PokePHP\PokeApi;
use Mockery\MockInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    public function samplePokemonJson()
    {
        return '{
            "count": 3,
            "next": "https://pokeapi.co/api/v2/pokemon/?offset=20&limit=20",
            "previous": null,
            "results": [
                {
                    "name": "bulbasaur",
                    "url": "https://pokeapi.co/api/v2/pokemon/1/"
                },
                {
                    "name": "ivysaur",
                    "url": "https://pokeapi.co/api/v2/pokemon/2/"
                },
                {
                    "name": "venusaur",
                    "url": "https://pokeapi.co/api/v2/pokemon/3/"
                }
            ]
        }';

    }


    public function test_it_shows_a_list_of_all_pokemon()
    {
        
        $apiResponseContent = $this->samplePokemonJson();

        Http::fake(['*' => Http::response($apiResponseContent, 200, ['Headers']),]);
        
        $response = $this->get('/');

        $pokemon = array_column(json_decode($apiResponseContent, true)['results'], 'name');
        $response->assertSee($pokemon);

    }
}
