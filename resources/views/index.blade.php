<x-layout>
   
    <h1>Pokedex</h1>
 
     
    <h3>
     Available Pokemon
    </h3>
     @if(!count($pokemons))
         <p>No Pokemon Found</p>
     @endif
    <ul>
        @foreach ($pokemons as $pokemon)
            <li>
                {{ $pokemon['name'] }}
            </li>
         @endforeach
     </ul>
 </x-layout>