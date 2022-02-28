<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Wonde\Endpoints\Schools;

class WondeApiController extends Controller
{
    /** Get the list of employees and render the view */
    public function classroomIndex(): \Inertia\Response
    {
        $school = $this->getSchoolWithTokenAndID();
        $employees = $this->getEmployees($school);

        return Inertia::render('Classroom', ['employees' => $employees]);
    }

    /** Setup the API client with the env token and school ID
     *  Return the Wonde Schools
     */
    public function getSchoolWithTokenAndID(): Schools {
        $token = config('services.token')['key'];
        $schoolID = config('services.schoolID')['key'];
        $client = new \Wonde\Client($token);
        return $client->school($schoolID);
    }

    /** Get the list of employees that have at least one class */
    public function getEmployees($school): array {
        $employees = array();
        foreach ($school->employees->all(['classes']) as $employee) {
            if (!empty($employee->classes->data)) {
                array_push($employees, ["fullName" => $employee->forename . ' ' . $employee->surname, "id" => $employee->id]);
            }
        }
        return $employees;
    }

    /** Get the list of classes that match the provided employeeID */
    public function getClasses($employeeID): \Illuminate\Http\JsonResponse {
        $school = $this->getSchoolWithTokenAndID();
        $classes = array();
        foreach ($school->employees->all(['classes']) as $employee) {
            if (!empty($employee->classes->data) && $employee->id == $employeeID) {
                foreach($employee->classes->data as $class)
                array_push($classes, ["className" => $class->name, "id" => $class->id]);
            }
        }

        return response()->json(['status' => 200, $classes]);
    }


    /** Get the student list from the provided classID and employeeID
     * --------------------------------------------------------------
     * Loop through the classes and check if the ID matches the selected class.
     * Then loop through the class employees to check if the ID matches the selected employee.
     *  Last, loop through the students to add them to the array
     */
    public function getStudents($classID, $employeeID): \Illuminate\Http\JsonResponse {
        $school = $this->getSchoolWithTokenAndID();
        $studentArray = array();
        foreach ($school->classes->all(['students', 'employees']) as $class) {
            if ($class->id == $classID) {
                foreach ($class->employees->data as $employee) {
                    if ($employee->id == $employeeID) {
                        foreach ($class->students->data as $student) {
                            array_push($studentArray, $student->forename . ' ' . $student->surname);
                        }
                        break;
                    }
                }
            }
        }
        return response()->json(['status' => 200, $studentArray]);
    }
}
