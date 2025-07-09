<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()    { return UserResource::collection(User::all()); }
    public function show(User $user) { return UserResource::make($user); }

    public function store(StoreUserRequest $req)
    {
        $user = DB::transaction(fn () =>
            User::create([...$req->validated(), 'password' => bcrypt($req->password)])
        );
        return UserResource::make($user)->response()->setStatusCode(201);
    }

    public function update(UpdateUserRequest $req, User $user)
    {
        DB::transaction(fn () => $user->update([
            ...$req->validated(),
            'password' => $req->filled('password') ? bcrypt($req->password) : $user->password
        ]));
        return UserResource::make($user);
    }

    public function destroy(User $user)
    {
        DB::transaction(fn () => $user->delete());
        return response()->json(['message' => 'User deleted']);
    }

    public function updateOrder(\Illuminate\Http\Request $req)
    {
        DB::transaction(fn () =>
            collect($req->ordered)->each(
                fn ($i) => User::whereId($i['id'])->update(['order' => $i['order']])
            )
        );
        return response()->json(['status' => 'success']);
    }
}
