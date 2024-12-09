<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        $users = $this->user->get();   
        // $users->load('posts');
        // dump($users);
        // foreach ($users as $user) {
        //     $posts = $user->posts()->get();
        //     // dump($posts);
        // }
        // $users = $this->user->with('posts')->get();
        // if(!Cache::has("users")){
        //     $tmp = $this->user->orderBy('created_at', 'desc')->paginate(5);
        //     Cache::put('users', $tmp);
        //     return $tmp;
        // }
        // return Cache::get('users');
        // dump($this->user->all()->toArray());

        return $this->user->orderBy('created_at', 'desc')->paginate(5);
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function create(array $data)
    {
        $user = User::create($data);
        return $user;
    }

    public function admin_update($id, array $data)
    {
        $user = $this->find($id);
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->role = $data['role'];
        if ($data['password']) {
            $user->password = Hash::make($data['password']);
        }
        $user->img = $data['img'];
        $user->save();
        // $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
