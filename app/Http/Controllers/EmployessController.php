<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Random;

class EmployessController extends Controller
{
    public function add_employee(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required',
            'company_name' => 'required',
            'department' => 'required',
            'designation' => 'required',
        ];

        $data = $request->all();

        $message = [
            'first_name.required' => 'first name required',
            'last_name.required' => 'last name required',
            'user_name.required' => 'user name required',
            'email.required' => 'email required',
            'email.email' => 'valid email required',
            'password.required' => 'password required',
            'phone.required' => 'phone required',
            'company_name.required' => 'company name required',
            'department.required' => 'department required',
            'designation.required' => 'designation required',
        ];

        $validator = Validator::make($data,$rules,$message);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        User::insert([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employee_id' => rand(100,500),
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'department' => $request->department,
            'designation' => $request->designation,
            'role' => 'employee',
        ]);


        return response()->json(['employee' => 'employee added successfully'],200);
    }

    public function update_employee(Request $request,$id)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'company_name' => 'required',
            'department' => 'required',
            'designation' => 'required',
        ];

        $data = $request->all();

        $message = [
            'first_name.required' => 'first name required',
            'last_name.required' => 'last name required',
            'user_name.required' => 'user name required',
            'email.required' => 'email required',
            'email.email' => 'valid email required',
            'phone.required' => 'phone required',
            'company_name.required' => 'company name required',
            'department.required' => 'department required',
            'designation.required' => 'designation required',
        ];

        $validator = Validator::make($data,$rules,$message);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        User::where('id',$id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'department' => $request->department,
            'designation' => $request->designation,
        ]);

        if ($request->password) {
            if ($request->password == $request->confirm_password) {
                User::where('id',$id)->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            else{
                return response()->json(['match_error' => 'confirm password dosenot match'],200);
            }
        }
        return response()->json(['employee' => 'employee updated successfully'],200);
    }
    public function delete_employee($id)
    {
        User::where('id',$id)->delete();
        return response()->json(['employee' => 'employee deleted successfully'],200);
    }
}
