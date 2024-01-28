<?php
// app/Http/Controllers/Api/EmployeeController.php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json(['employees' => $employees]);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json(['employee' => $employee]);
    }

    public function store(Request $request)
    {
        $input=$request->all();
        try {
            $request->validate([
                'name' => 'required|unique:employees,name',
                'department' => 'required',
                'email' => 'required|email|unique:users',
                'password'=>"required|min:6"
            ]);
    
            $employee = Employee::create($input);
    if($employee){
        // Create a user for the employee
        $user=User::create([
            'employee_id' => $employee->id,
            'name' => $employee->name, // You can customize this
            'email'=>$input['email'],
            'password' => bcrypt($input['password']), // You can customize this
        ]);
    }
            return response()->json(['employee' => $employee,'user'=>$user], 201);
        } catch (ValidationException $e) {
            // Handle validation errors and return a custom response
            return response()->json(['errors' => $e->errors()], 422);
        }
       
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'department' => 'required',
        ]);

        $employee = Employee::findOrFail($id);
        if($employee){
            // Create a user for the employee
            $user=User::where('employee_id',$employee->id)->update([
                'employee_id' => $employee->id,
                'name' => $employee->name, // You can customize this
                'email'=>$input['email'],
                'password' => bcrypt($input['password']), // You can customize this
            ]);
        }
        $employee->update($request->all());

        return response()->json(['employee' => $employee,'user'=>$user]);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user=User::where('employee_id',$employee->id);
        $employee->delete();
        $user->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
