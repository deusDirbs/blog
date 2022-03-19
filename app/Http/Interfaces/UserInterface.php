<?php

namespace App\Http\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface UserInterface
{
    public function index();

    public function create(Request $request);

    public function save(Request $request);

    public function edit(User $user);

    public function update(Request $request, User $user);

    public function delete($id, User $user);
}
