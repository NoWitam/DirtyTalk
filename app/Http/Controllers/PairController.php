<?php

namespace App\Http\Controllers;

use App\Http\Requests\PairRequest;
use App\Http\Resources\MatchResource;
use App\Models\Pair;
use Illuminate\Http\Request;

class PairController extends Controller
{
    public function view(PairRequest $request, ?Pair $pair = null)
    {
        return view('app.matches', [
            'pair' => $pair,
            'bot' => $pair ? MatchResource::one($pair->bot) : null
        ]);
    }
}
