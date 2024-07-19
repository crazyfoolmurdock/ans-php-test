<x-layout>
   
    <h1>Pokedex</h1>
 
    <form method="post" action="/search">
        @csrf
            <label for="name">Filter Pokemon</label>
            <input type="text" name="name" id="name" required />
            <button type="submit">Search</button>
    </form>

     
    <h3>
     Available Pokemon
    </h3>
     @if(!count($pokemons))
         <p>No Pokemon Found</p>
     @endif
    <ul>
        @foreach ($pokemons as $pokemon)
            <li>
                <a href="/{{ $pokemon['name'] }}" > {{ $pokemon['name'] }}</a>
            </li>
         @endforeach
     </ul>
 </x-layout>