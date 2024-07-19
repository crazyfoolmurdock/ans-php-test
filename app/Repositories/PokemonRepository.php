<?php
namespace App\Repositories;

use App\Apis\PokeApi;
use PokePHP\Filter;
use Illuminate\Support\Collection;
use App\Contracts\RepositoryInterface;

class PokemonRepository implements RepositoryInterface
{
    protected PokeApi $api;
    public function __construct(PokeApi $api)
    {
        $this->api = $api;

       

    }


    public function all(): Collection
    {

        $initial = $this->api->getPokemonList(1);

        $total = $initial['count'];

        $response = $this->api->getPokemonList($total);

        return new Collection($response['results']);


    }

   
    
    
}
