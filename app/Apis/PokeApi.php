<?php
namespace App\Apis;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PokeApi
{

    protected function get(string $endpoint = '', array $queryParameters = []): Response
    {

        $response = Http::get(env('POKE_API') . $endpoint, $queryParameters);

        return $response;
    }

    public function getPokemonList(int|null $limit = null): array
    {

        $queryParameters = [];

        if(!is_null($limit)){
            $queryParameters = ['limit' => $limit];
        }

        $response =  $this->get('pokemon', $queryParameters);

        return $response->json();

    }

    public function getPokemon(string $name): array
    {

        $response =  $this->get('pokemon/' . $name);

        return $response->json();

    }





 
    
    
    
}
