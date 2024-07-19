<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;

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


    public static function nameSearchProvider(): array
    {
        return [
            'full_name' => ['search' => 'ivysaur', 'see' => ['ivysaur'], 'dontsee' => ['bulbasaur', 'venusaur']],
            'partial_name' => ['search' => 'lba', 'see' => ['bulbasaur'], 'dontsee' => ['ivysaur', 'venusaur']],
            'not_found' => ['search' => 'pikachu', 'see' => [], 'dontsee' => ['bulbasaur', 'ivysaur', 'venusaur']],
        ];
    }



    #[DataProvider('nameSearchProvider')]
    public function test_search_shows_the_expected_pokemon(string $search, array $see, array $dontsee)
    {
        Http::fake(['*' => Http::response($this->samplePokemonJson(), 200, ['Headers']),]);

        $response = $this->post('/search', ['name' => $search]);

        $response->assertSee($see);

        $response->assertDontSee($dontsee);


    }
}
