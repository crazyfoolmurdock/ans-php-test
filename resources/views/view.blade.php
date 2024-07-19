<x-layout>
   
    <h1>{{$pokemon['name'] }}</h1>


    <img src="{{ $pokemon['sprites']['front_default']}}" />
    
    <p><b>Species: </b><span>{{ $pokemon['species']['name'] }}</span></p>
    <p><b>Height: </b><span>{{ $pokemon['height'] }}</span></p>
    <p><b>Weight: </b><span>{{ $pokemon['weight'] }}</span></p>

    <b>Abilities:</b>
    <ul>
        @foreach ($pokemon['abilities'] as $ability)
        <li>{{$ability['ability']['name'] }}</li>
            
        @endforeach

    </ul>

    <a href="/">Main Page</a>

 </x-layout>