<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->where('id', '<>', $request->user()->id)
            ->latest('created_at');

        return UserResource::collection($users->paginate());
    }

    /**
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        /** @var User $item */
        $item = User::create($request->validated());

        return $this->show($item, $request)->setStatusCode(201);
    }

    /**
     * @param  User  $user
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user, Request $request)
    {
        return UserResource::make($user)->toResponse($request);
    }

    /**
     * @param  UpdateRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return $this->show($user, $request);
    }

    /**
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
