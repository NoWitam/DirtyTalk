<?php

namespace App\Http\Controllers;

use App\Events\BotReplyReceived;
use App\Helpers\AiHelper;
use App\Http\Resources\UserResource;
use App\Models\Job;
use App\Models\Message;
use App\Models\Pair;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users', [
            'users' => UserResource::many(User::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.add');
    }

    public function dump()
    {
        dd(Job::all());
    }
}
