<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\RoleManagement;
use App\Http\Controllers\Controller;


class RoleManagementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255|unique:role_managements,role_name'
        ]);

        RoleManagement::create(['role_name' => $request->role_name]);

        return response()->json(['success' => 'Role added successfully!']);
    }
}

