<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Typeuser;
use App\Models\Permission;
use App\Models\PermissionGroup;


class PermissionController extends Controller
{
    public function index()
    {
        if(Auth::check()){

            $user = User::where('active','y')->get();

            return view('admin.page.setting.account.index',compact('user'));
        }
        return view('admin.page.auth.login');
    }

    public function edit($id,Request $request)
    {
        if(Auth::check()){

            $user = User::findOrfail($id);
            $type = Typeuser::where('active','y')->get();
            
            return view('admin.page.setting.account.edit',compact('user','type'));
        }
        return view('admin.page.auth.login');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            ' typeuser' => 'nullable|exists:type_users,id',
        ]);

        $user = User::findOrFail($id);
        $user->type_user_id = $request->input('typeuser') ?: null;
        $user->save();

        session()->put('success_update', 'อัปเดตสิทธิ์เรียบร้อย');
        return redirect()->route('admin.permission');
    }

    public function Permissions()
    {
        if(Auth::check()){
            $type = Typeuser::where('active','y')->get();
            
            return view('admin.page.setting.account.permissions',compact('type'));
        }
        return view('admin.page.auth.login');
    }

    public function Permissions_edit($id)
    {
        if (Auth::check()) {
            $current = Permission::where('type_user_id', $id)
                                    ->where('can_access', true)
                                    ->pluck('key')
                                    ->toArray();
            $permissions = PermissionGroup::orderBy('group_name')
                                ->orderBy('sort_order')
                                ->get();
            $permissionGroups = [];

            foreach ($permissions as $item) {
                if ($item->group_name) {
                    $permissionGroups[$item->group_name][$item->key] = $item->label_th;
                } else {
                    $permissionGroups[$item->key] = $item->label_th;
                }
            }
        
            $type = Typeuser::findOrFail($id);
            return view('admin.page.setting.account.type', compact('type', 'current','permissionGroups'));
        }
        return view('admin.page.auth.login');
    }
    public function updatePermissions(Request $request, $typeUserId)
    {
        $allPermissionKeys = [
            'admin','dashboard', 'document_request', 'setting',
            'document', 'document_file', 'document_import',
            'document_period', 'document_type', 'permission_type','permission','survey',
            'request','approved','surveyreport','synonym'
        ];
        
        foreach ($allPermissionKeys as $key) {
            $hasPermission = in_array($key, $request->permissions ?? []);

            Permission::updateOrCreate(
                ['type_user_id' => $typeUserId, 'key' => $key],
                ['can_access' => $hasPermission]
            );
        }

        session()->put('success_permission', 'อัปเดตสิทธิ์เรียบร้อยแล้ว');
        return redirect()->back();
    }

    public function Permissions_create(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Store the new permission (you can add your logic here)
        $permission = new Typeuser();
        $permission->name = $request->name;
        $permission->create_date = now();
        $permission->save();

        // Redirect with success message
        session()->put('success_per_create', 'เพิ่มสิทธิ์เรียบร้อย');
        return redirect()->route('admin.permission_type_edit',['id' => $permission->id]);
    }

    public function delete($id)
    {
        $text = Typeuser::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.permission_type')->with('success', 'ลบข้อมูลสำเร็จ');
    }

}