<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    public function index()
    {
        return User::paginate();
    }

    /**
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $item = $request->validated();

        /** @var User $item */
        $item = User::create($item);

        return response($this->show($item), 201);
    }

    /**
     * @param  User  $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @param  UpdateRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $item = $request->validated();

        $user->update($item);

        return response($this->show($user), 200);
    }

    /**
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }
}
