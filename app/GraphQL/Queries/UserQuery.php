<?php

namespace App\GraphQL\Queries;

use App\Models\User;

class UserQuery
{
    /**
     * Retorna todos os usuários
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke($_, array $args)
    {
        return User::all(); // ou User::query()->get()
    }
}
