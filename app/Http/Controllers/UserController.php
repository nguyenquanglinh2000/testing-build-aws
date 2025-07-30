<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $client = DB::getMongoClient()->selectDatabase(config('app.db_name'));
        $users = $client->selectCollection('user')->findOne([]);
        return response()->json($users);
    }
}
