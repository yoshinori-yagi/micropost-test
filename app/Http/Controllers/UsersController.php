<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Micropost;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'microposts' => $microposts,
        ];

        $data += $this->counts($user);

        return view('users.show', $data);
    }
    
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
    
    public function favorings($id) {
        $user = User::find($id);
        $favorings = $user->favorings()->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $favorings, ];
        
        $data += $this->counts($user);
        
        return view('users.favorings', $data); 
        
    }
    
    public function retweetings($id) {
        $user = User::find($id);
        $retweetings = $user->retweetings()->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $retweetings, ];
        
        $data += $this->counts($user);
        
        return view('users.retweetings', $data); 
        
    }
    
    public function members() {
        return view('users.members');
    }

}