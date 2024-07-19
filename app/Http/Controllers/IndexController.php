<?php

namespace App\Http\Controllers;

use App\Contracts\RepositoryInterface;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    public function index(RepositoryInterface $repository)
    {
        return view('index', ['pokemons' => $repository->all()]);
    }

    public function search(Request $request, RepositoryInterface $repository)
    {
        return view('index', ['pokemons' => $repository->search($request->get('name'))]);
    }


}
