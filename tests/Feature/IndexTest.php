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



    public function sampleSinglePokemonJson()
    {
        return '
{
    "abilities": [
        {
            "ability": {
                "name": "overgrow",
                "url": "https://pokeapi.co/api/v2/ability/65/"
            },
            "is_hidden": false,
            "slot": 1
        },
        {
            "ability": {
                "name": "chlorophyll",
                "url": "https://pokeapi.co/api/v2/ability/34/"
            },
            "is_hidden": true,
            "slot": 3
        }
    ],
    "species": {
        "name": "ivysaur",
        "url": "https://pokeapi.co/api/v2/pokemon-species/2/"
    },
    "name": "ivysaur",
    "height": 10,
    "id": 2,
    "weight": 130,
    "sprites": {
        "back_default": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/back/2.png",
        "back_female": null,
        "back_shiny": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/back/shiny/2.png",
        "back_shiny_female": null,
        "front_default": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/2.png",
        "front_female": null,
        "front_shiny": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/2.png",
        "front_shiny_female": null
    }
}
';
    }


    public function test_view_shows_the_expected_data(): void
    {
        $apiResponseContent = $this->sampleSinglePokemonJson();

        Http::fake(['*' => Http::response($apiResponseContent, 200, ['Headers']),]);
        
        $response = $this->get('/pokemon-name');
        
        $stats = json_decode($apiResponseContent, true);

        $response->assertSee($stats['name']);
        $response->assertSee($stats['height']);
        $response->assertSee($stats['weight']);
        $response->assertSee($stats['species']['name']);

        foreach($stats['abilities'] as $ability){
            $response->assertSee($ability['ability']['name']);
        }
    }
}
