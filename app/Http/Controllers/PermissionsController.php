<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class PermissionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:edit permission', only: ['edit']),
            new Middleware('permission:create permission', only: ['create']),
            new Middleware('permission:delete permission', only: ['delete']),
        ];
    }




    //for show permission page
public function index(Request $request)
    {
        // $products = Product::orderBy('created_at','DESC')->paginate(2);
        // return view('products.list',[
        //     'products'=> $products
        // ]);
    $query = Permission::query();

    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');  
    }

    $permissions = $query->orderBy('created_at', 'DESC')->paginate(10);

    // If AJAX request, return only the table partial
    if ($request->ajax()) {
        return view('permissions.partials.table', compact('permissions'))->render();
    }

    // Otherwise, return full page
    return view('permissions.list', compact('permissions'));
    }

    //for create permission page
    public function create(){
        return view('permissions.create');
    }

    //for store permission page
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:permissions|min:3'
        ]);

        if ($validator->passes()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success','permission added successfully');
        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }
    //for edit permission page
    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permissions.edit',[
            'permission'=> $permission
        ]);
    }

    //for update permission page
    public function update($id, Request $request){
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:permissions,name,'.$id.',id'
        ]);

        if ($validator->passes()){

            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success','permission update successfully');
        }else{
            return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validator);
        }
    }

        //for delete permission page
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return redirect()->route('permissions.index')
                ->with('error', 'Permission not found');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }


}
