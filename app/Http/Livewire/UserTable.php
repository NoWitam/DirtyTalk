<?php

namespace App\Http\Livewire;

use App\Enums\UserRoleEnum;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserTable extends Component
{
    public $users;
    public $newUser;

    protected $rules = [
        'newUser.email' => 'required|email',
        'newUser.password' => 'required|min:3',
        'newUser.role' => ['required']
    ];

    public function mount()
    {
        $this->newUser = ['role' => UserRoleEnum::ADMIN];
        $this->users = UserResource::many(User::all());
    }

    public function create()
    {
        $this->validate();
      
        $user = User::create([
            'name' => 'name',
            'email' => $this->newUser['email'],
            'password' => Hash::make($this->newUser['password']),
            'role' => $this->newUser['role']
        ]);
        $this->mount();
    }

    public function delete($id)
    {
        User::destroy($id);
        $this->mount();
    }
    public function render()
    {
        return view('livewire.user-table')
            ->extends('layouts.admin');
    }
}
