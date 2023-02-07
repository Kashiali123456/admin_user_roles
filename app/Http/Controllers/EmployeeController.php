<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeStoreRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json([
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // $employees = Employee::create([
        //     'name'=> $request->name,
        //     'contact_no'=> $request->contact_no,
        //     'designation'=> $request->designation,
        //     'profile'=> $request->profile,
        //     'department' => $request->department,
        //     'job_type'=> $request->job_type,
        //     'email'=> $request->email,
        //     'joining_date' => $request->joining_date,
        //     'status'=> $request->status,
        //     'password'=> Hash::make($request->password),

           
        // ]);
        //  return ($employees);
        //  $user = User::create([
        //     'name' => $request->name,
        //     'password' => bcrypt($request->password),
        //     'email' => $request->email,
          
        // ]);
        //     return ($user);

        $employees = new Employee;
        $employees->name = $request->name;
        $employees->contact_no = $request->contact_no;
        $employees->designation= $request->designation;
        $employees->email = $request->email;
        $employees->profile =$request->profile;
        $employees->department = $request->department;
        $employees->job_type = $request->job_type;
        $employees->joining_date= $request->joining_date;
        $employees->status= $request->status;
        $employees->password= Hash::make($request->password);
        $employees->save();
        

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'joining_date' => $request->joining_date,
            'designation'=> $request->designation,
            'department' => $request->department,
            'job_type'=> $request->job_type,
            'scopes' => 'is_employee',
        ]);
        if (auth()->attempt(array('email' => $request->email, 'password' => $request->password),true)) {
            return $user;
        }   
    }
    
    public function punch()
    {
        $employees = Employee::all();
        return response()->json([
            'employees' => $employees
        ]);
    }
    public function punchin(Request $request)
    {
        $id= $request->id;
        $attendances = array();
        $attendanceObj = array(
            'id'=> 1,
            'day'=> $request->day,
            'punch_time'=> $request->punch_time,
            'punch_out'=> "",
            'break_time'=> "",
            'full_day' => "",
            'over_time'=> "",
            'total_production_time' => "",
            "updated_at" => "",
        );
        $employeeAttendance = Employee::select('id', 'attendance')->where('id', $id)->get();
        if($employeeAttendance[0]->attendance == null){
            $date = "22-1-22";
            $updatedAttendanceObj[$date] = $attendanceObj;
            // dd($updatedAttendanceObj);
            array_push($attendances, $updatedAttendanceObj);
        } else {
            $empAttendanceArr = $employeeAttendance[0]->attendance;
            $attendanceId = sizeof($empAttendanceArr)+1;
            $attendanceObj['id'] = $attendanceId;
            $attendanceObj['day'] = $request->day;
            $attendances = $employeeAttendance[0]->attendance;
            $date = "23-1-22";
            $updatedAttendanceObj[$date] = $attendanceObj;
            array_push($attendances, $updatedAttendanceObj);
            // dd($attendances);
        }
        // dd($attendanceObj, $id, );
        Employee::where('id', $id)->update(['attendance' => $attendances]);
        return response()->json([
            'employees' => $attendances
        ]);             
    }

    public function punchOut(Request $request)
    {
        $id= $request->id;
        $punchOut = $request->punchOut;
        $punchOutTime =  $request->punch_out;
        $attendances = array();
        $employeeAttendance = Employee::select('id', 'attendance')->where('id', $id)->get();
        $attendances = $employeeAttendance[0]->attendance;
        for($i = 0; $i < sizeof($attendances); $i++){
            // dd($attendances[$i][$punchOut]);
            if(isset($attendances[$i][$punchOut])){
                $attendances[$i][$punchOut]["punch_out"]  = $punchOutTime;
            }
        }
        Employee::where('id', $id)->update(['attendance' => $attendances]);
        return response()->json([
            'employees' => $attendances
        ]);             
    }



/**
 * Display the specified resource.
 *
 * @param  \App\Models\Employee  $employee
 * @return \Illuminate\Http\Response
 */
public function show(Employee $employee)
{
    //
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());

        return response()->json([
            'message' => "Employee updated successfully!",
            'employee' => $employee
        ], 200);
        return redirect()->route('employees.index')
        ->with('success','Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'message' => "Employee deleted successfully!",
        ], 200);
        return redirect()->route('employees.index')->with('success','Employee updated successfully');
    }
   
}
