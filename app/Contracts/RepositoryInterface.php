<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface RepositoryInterface
{

    public function all(): Collection;

    public function search(string $name): Collection;

    public function get(string $name): array;

}
