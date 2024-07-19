<?php

namespace Tests\Integration;

use App\Repositories\PokemonRepository;
use Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PokemonRepositoryTest extends TestCase
{

    public function sampleResponseJson(int $count = 1, array $pokemon = [])
    {
        return json_encode([
            'count' => $count,
            'results' => $pokemon
        ]);

    }

    public function test_all_uses_the_count_from_the_response_for_the_limit_query_parameter_to_get_all_pokemon()
    {
        // make sure we get all the pokemon on one page by using the count property in the initial response to do a new request

        $expectedCount = 5;

        $apiResponseContent = $this->sampleResponseJson($expectedCount);

        Http::fake(['*' => Http::response($apiResponseContent, 200, ['Headers']),]);

        $repository = $this->app->make(PokemonRepository::class);

        $repository->all();

        
        Http::assertSent(function (Request $request) use ($expectedCount) {
            return  str_contains($request->url(), '?limit='.$expectedCount);
        });
        


    }
    

    public function test_all_gets_all_pokemon()
    {
        // 100 pokemon
        $expectedPokemon = array_fill(1, 100, 
            [
                "name" => "bulbasaur",
            ],
        );

        $apiResponseContent = $this->sampleResponseJson(count($expectedPokemon), $expectedPokemon);

        Http::fake(['*' => Http::response($apiResponseContent, 200, ['Headers']),]);

        $repository = $this->app->make(PokemonRepository::class);

        $result = $repository->all();

        $this->assertEquals(new Collection($expectedPokemon), $result);
        

    }

    public function test_get_gets_performs_expected_request()
    {

        $name = 'raichu';

        // the response doesnt really matter, we are testing the request
        Http::fake(['*' => Http::response($this->sampleResponseJson(), 200, ['Headers']),]);

        $repository = $this->app->make(PokemonRepository::class);

        $result = $repository->get($name);

        Http::assertSent(function (Request $request) use ($name) {
            return  str_ends_with($request->url(), '/pokemon/' . $name);
        });
        

    }
}
