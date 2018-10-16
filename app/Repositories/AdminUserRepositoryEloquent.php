<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdminUserRepository;
use App\Models\AdminUser;

/**
 * Class AdminUserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AdminUserRepositoryEloquent extends BaseRepository implements AdminUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminUser::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Store user
     * @param array $payload
     * @return bool
     */
    public function store($payload = [])
    {

        $isAble = $this->model->where('username', $payload['username'])->count();
        if($isAble) {
            return response()->json([
	            'status' => false,
	            'msg' => '用户名已被使用'
            ]);
        }

        $data = [];

        if( $payload['password']) {
            $data['password'] = bcrypt( $payload['password']);
        }
        $data['name'] =  $payload['name'];
        $data['email'] =  $payload['email'];
        $data['username'] = $payload['username'];
        $data['tel'] =  $payload['tel'];
        $data['is_super'] = 0;
        $result = parent::create($data);

        if(!$result) {
	        return response()->json([
                'status' => false,
                'msg' => '员工新增失败'
            ]);
        }

        if($result->id && ($roles = array_get($payload, 'roles'))) {
            $this->attachRoles($result->id, $roles);
        }

        return true;
    }

    /**
     * update admin user
     * @param array $attributes
     * @param $id
     * @return array
     */
    public function update(array $attributes, $id)
    {
        
        $data = [];
        if($attributes['password']) {
            $data['password'] = bcrypt($attributes['password']);
        }
        $data['name'] = $attributes['name'];
        $data['email'] = $attributes['email'];
        $data['tel'] = $attributes['tel'];
        $result = parent::update($data, $id);
        if(!$result) {
            return [
                'status' => false,
                'msg' => '员工更新失败'
            ];
        }
        $this->model->find($id)->roles()->detach();

        if(isset($attributes['roles'])) {
            $this->attachRoles($id, $attributes['roles']);
        }
        return ['status' => true];
    }

    /**
     * delete admin user
     * @param $id
     * @return bool|int
     */
    public function delete($id)
    {

        $user = $this->model->find($id);
        if(!$user) {
            return false;
        }

        $user->roles()->detach();

        return $user->delete();
    }

    /**
     * Attach user roles by user id
     * @param $userId
     * @param $roles
     */
    public function attachRoles($userId, $roles)
    {
        $user = $this->model->find($userId);
        $user->attachRoles($roles);
    }
}
