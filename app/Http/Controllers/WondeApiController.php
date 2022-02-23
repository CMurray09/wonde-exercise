<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class WondeApiController extends Controller
{
    public function classroomIndex(): \Inertia\Response
    {
        $token = config('services.token')['key'];
        $schoolID = 'A1930499544';

        $client = new \Wonde\Client($token);
        $school = $client->school($schoolID);
        $employees = $this->getEmployees($school);

        return Inertia::render('Classroom', ['employees' => $employees]);
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
    public function getClasses($school, $employeeID): array {
        $employeeClasses = array();
        foreach ($school->employees->all(['classes']) as $employee) {
            if (!empty($employee->classes->data) && $employee->id == $employeeID) {
//                dd($employee);
                foreach($employee->classes->data as $class)
                array_push($employeeClasses, ["className" => $class->name, "id" => $class->id]);
            }
        }
        return $employeeClasses;
    }


    /** Get the student list from the provided classID and employeeID
     * --------------------------------------------------------------
     * Loop through the classes and check if the ID matches the selected class.
     * Then loop through the class employees to check if the ID matches the selected employee.
     *  Last, loop through the students to add them to the array
     */
    public function getStudents($school, $classID, $employeeID): array {
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
        return $studentArray;
    }
}
