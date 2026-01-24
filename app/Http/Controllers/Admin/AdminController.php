<?php

namespace App\Http\Controllers\Admin;
 
use App\Models\Branch;
use App\Models\User;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:عرض مستخدم', ['only' => ['index']]);
        $this->middleware('permission:اضافة مستخدم', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $SystemController = new SystemController();
        $roles = $SystemController->getRolsPluck(); 
        $data = $SystemController->getUsers();
        $branches = $SystemController->getBranches();  

        return view('admin.admins.index', compact('data', 'roles','branches'));
    }
	

    public function create()
    {
        $SystemController = new SystemController();
        $roles = $SystemController->getRolsPluck(); 
        $branches = $SystemController->getBranches();  
        
        return view('admin.admins.create', compact('roles','branches'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required', 
            'email' => 'required|unique:users',
            'password' => 'required|same:confirm-password',
            'role_name' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $Admin = User::create($input);
        $Admin->assignRole($request->input('role_name')); 
		$permissions=$Admin->getPermissionsViaRoles();
		$Admin->givePermissionTo($permissions);
        
        return redirect()->route('admin.admins.index')
            ->with('success', 'تم اضافة مستخدم بنجاح');
    }

    public function show($id)
    {
        $Admin = User::findorfail($id);
        return view('admin.admins.show', compact('Admin'));
    }

    public function edit($id)
    {
        $Admin = User::findOrFail($id);
        $SystemController = new SystemController();
        $roles = $SystemController->getRolsPluck(); 
        $branches = $SystemController->getBranches();  
        $AdminRole = $Admin->roles->pluck('name', 'name')->all();
        
        return view('admin.admins.edit', compact('Admin', 'roles','branches', 'AdminRole'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'same:confirm-password',
            'role_name' => 'required'
        ]);

        $input = $request->all();
        $Admin = User::findOrFail($id);

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $Admin->password;
        }
   
        $Admin->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $Admin->assignRole($request->input('role_name')); 

		$permissions = $Admin->getPermissionsViaRoles();
		$Admin->syncPermissions($permissions);
 
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $fileName = $image->getClientOriginalName();
            $uploadDir = 'uploads/profiles/admins/' . $Admin->id;
            $image->move($uploadDir, $fileName);
            $Admin->profile_pic = $uploadDir . '/' . $fileName;
            $Admin->save();
        }
  
        return redirect()->route('admin.admins.index')
            ->with('success', 'تم تعديل بيانات المستخدم بنجاح');
    
    }

    public function destroy(Request $request)
    {
  
        User::findOrFail($request->Admin_id)->delete();
        
        return redirect()->route('admin.admins.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function delete(Request $request){
 
        $user = User::find($request->admin_id);
        
        if($user){
            $user -> delete();
            return redirect()->route('admin.admins.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
        }
    
    }

    public function edit_profile($id)
    {
        $user = User::findOrFail($id);
        return view('admin.profiles.edit', compact('user'));
    }

    public function update_profile(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'same:confirm-password'
        ]);
        
        $input = $request->all();
        $user = User::findOrFail($id);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $user->password;
        }
  
        $user->update($input);
        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic');
            $fileName = $profile_pic->getClientOriginalName();
            $uploadDir = 'uploads/profiles/admins/' . $id;
            $profile_pic->move($uploadDir, $fileName);
            $user->profile_pic = $uploadDir . '/' . $fileName;
            $user->save();
        }
        return redirect()->back()->with('success', 'تم تحديث البيانات الشخصية بنجاح ');
    }

    public function remove_selected(Request $request)
    {
        /*
        $Admins_id = $request->Admins;
        foreach ($Admins_id as $Admin_id) {
            $Admin = Admin::FindOrFail($Admin_id);
            $Admin->delete();
        }
        return redirect()->route('admin.admins.index')
            ->with('success', 'تم الحذف بنجاح');
            */
    }

    public function print_selected()
    {
        $Admins = User::all();
        return view('admin.admins.print', compact('Admins'));
    }
 
}
