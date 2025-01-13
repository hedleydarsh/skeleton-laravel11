<?php

namespace App\Repositories\Api\V1\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserListResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRepository extends BaseRepository
{
    protected $model = User::class;

    public function all($queryParams)
    {
        $perPage = $queryParams['per_page'] ?? 25;
        $users = $this->model
            ->when(isset($queryParams['q']), function ($query) use ($queryParams) {
                $query->where('name', 'like', '%' . $queryParams['q'] . '%')
                    ->orWhere('email', 'like', '%' . $queryParams['q'] . '%')
                    ->orWhere('nickname', 'like', '%' . $queryParams['q'] . '%');
            })
            ->paginate($perPage);
        return UserListResource::collection($users);
    }

    public function beforeStore($attributes)
    {
        $attributes['profiles'] = json_decode($attributes['profiles']);

        if (isset($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            unset($attributes['password']);
        }

        if (request()->file('image')) {
            $attributes['image'] = uploadImage(request()->image, 'users');
        }

        return $this->create($attributes, true);
    }

    public function beforeUpdate($resource, $attributes)
    {
        $attributes['profiles'] = json_decode($attributes['profiles']);

        if (request()->file('image')) {
            $attributes['image'] = uploadImage(request()->image, 'users');
        }

        return $this->update($resource, $attributes, true);
    }

    public function afterSave($resource, $attributes): Model|JsonResource
    {
        $resource->syncRoles($attributes['profiles']);
        return $resource;
    }

    public function find($id)
    {
        return new UserResource($this->model->with('roles.permissions')->find($id));
    }

    public function changeRole($attributes)
    {
        $user = $this->model->find(auth()->user()->id);
        $user->active_role = $attributes['active_role'];

        $user->save();
        return $user;
    }

    public function updateRoles($id, $attributes): Model|JsonResource
    {
        $user = $this->model->find($id);
        $user->syncRoles($attributes['roles']);

        if (!in_array($user->active_role, $attributes['roles'])) {
            $user->active_role = $attributes['roles'][0];
            $user->save();
        }

        return $user;
    }
}
