<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Pagination
{

    public static function paginate(Builder $builder, Request $request)
    {
        $perPage = $request->itemsPerPage;

        if (!empty($request->sortBy)) {
            for ($i = 0; $i < count($request->sortBy); $i++) {
                $builder->orderBy($request->sortBy[$i], $request->sortDesc[$i]);
            }
        }

        if ($perPage == -1 || empty($perPage)) {
            return $builder->get();
        }
        return $builder->paginate($perPage);
    }
}
