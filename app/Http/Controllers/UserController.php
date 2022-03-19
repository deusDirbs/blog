<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Route user/
 */
class UserController extends Controller implements UserInterface
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'email' => 'sometimes|required|email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ip_address' => ['required', 'ip'],
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('admin/user/index', compact('users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        return view('admin/user/create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'ip_address' => $_SERVER["REMOTE_ADDR"],
            'geo_location' => "[55.755831, 37.617673]",
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users');
    }

    /**
     * @param User $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $id)
    {
        return view('admin/user/edit',[
            'user' => $id,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $user->where(['id' => $request->id])->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success','user updated successfully!');
    }

    /**
     * @param $id
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, User $user)
    {
        $user->where(['id' => $id])->delete();

        return back()->with('user-delete','user was deleted successfully!');
    }
}
