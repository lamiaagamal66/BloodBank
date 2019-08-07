<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Support\Facades\Auth;
use App\User;
use Auth;

class UserController extends Controller
{
    public function changePassword()
    {
        return view('users.reset-password');
    }

    public function changePasswordSave(Request $request)
    {
        $messages =[
            'old-password' =>'required',
            'password' => 'required|confirmed',
        ];
        $rules =[
            'old-password.required' => 'Old Password Required',
            'password.required' => 'New Password Required'
        ];
        $this->validate($request,$messages,$rules);

        $user = Auth::User();

        if(Hash::check($request->input('old-password'), $user->password)){

            $user->password =bcrypt($request->input('password'));
            $user->save();
            flash()->success('Password Updated');
            return view('users.reset-password');
        }else{
            flash()->error('Error Password');
            return view('users.reset-password');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $model)
    {
        return view('users.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' =>'required',
            'password' =>'required|confirmed',
            'email' =>'email|required',
            'roles_list' =>'required',
        ];
        $messages = [
            'name.required' => 'Name is Required',
            'password.required' => 'Password is Required',
            'email.email' => 'Enter Valid Email',
            'roles_list.required' => 'Roles List is Required'
        ];
        $this->validate($request, $rules , $messages);
        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->except('roles_list'));
        $user->roles()->attach($request->input('roles_list'));

        flash()->success('User Addded Successfully ..');
        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('users.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' =>'required',
            'password' =>'confirmed',
            'email' =>'email|required',
            'roles_list' =>'required',
        ];
        $messages = [
            'name.required' => 'Name is Required',
            'email.email' => 'Enter Valid Email',
            'roles_list.required' => 'Roles List is Required'
        ];
        $this->validate($request, $rules , $messages);
        $user = User::findOrFail($id);

        // if(Hash::check($request->input('password'), $user->password))
        // {
            $user->roles()->sync((array) $request->input('roles_list'));
            $request->merge(['password' => bcrypt($request->password)]);
            $user->update($request->all());
            flash()->success('Updated Successfully ..');
            return redirect(route('user.index'));

        // }else{
        //     flash()->error('Error Password');
        //     return back();
        // }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if(!$user){
            flash()->error('fail to find info ..');
            return redirect(route('user.index'));
        }
        $user->delete();
        flash()->success('Deleted Successfully ..');
        return redirect(route('user.index'));
    }

    public function logout()
    {
        // session_destroy();
        Auth::logout();
        return redirect(route('home'));
    }
}
