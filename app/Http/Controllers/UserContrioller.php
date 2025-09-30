<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserContrioller extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('permission:view user', only: ['index']),
            new Middleware('permission:create user', only: ['create']),
            new Middleware('permission:edit user', only: ['edit']),
            new Middleware('permission:delete user', only: ['delete']),
            
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles'); // eager load roles

        // Search filter
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Role filter
        if ($request->role && $request->role !== 'all') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Sort filter
        if ($request->sort) {
            switch ($request->sort) {
                case 'latest':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'ASC');
                    break;
                case 'role_asc':
                    $query->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->select('users.*')
                        ->orderBy('roles.name', 'ASC');
                    break;
                case 'role_desc':
                    $query->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->select('users.*')
                        ->orderBy('roles.name', 'DESC');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $users = $query->paginate(10);

        $roles = \Spatie\Permission\Models\Role::orderBy('name', 'ASC')->get();

        if ($request->ajax()) {
            return view('users.partials.table', compact('users'))->render();
        }

        return view('users.list', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $roles = Role::orderBy('name','ASC')->get();
            return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name','ASC')->get();

        $hasRole = $user->roles->pluck('id');

            return view('users.edit',[
            'user' => $user,
            'roles' => $roles,
            'hasRole'=>$hasRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email,'.$id.',id'
        ]);
        if($validator->fails()){
            return redirect()->route('users.edit',$id)->withInput()->withErrors('The email has already been taken.');
        }
        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success','User update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')
                ->with('error', 'User not found');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'users deleted successfully');
    }
}
