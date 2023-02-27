<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait MatchTrait {

    public function findMatch(String $model_string, Request $request)
    {
        $model = 'App\\Models\\'.$model_string;
        $collection = $model::get();
        $match = $collection->filter(function ($item) use ($request) {
            return $this->match($item, $request);
        });

        return $match;
    }

    private function match(object $item, Request $request): bool
    {                
        if ($item->first_name != $request->first_name) return false;
        if ($item->second_name != $request->second_name) return false;
        if ($item->first_last_name != $request->first_last_name) return false;
        if ($item->second_last_name != $request->second_last_name) return false;

        return true;
    }
}