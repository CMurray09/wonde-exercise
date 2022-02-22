<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class WondeApiController extends Controller
{
    public function index() {
        $token = config('services.token')['key'];
        $schoolID = 'A1930499544';

        $client = new \Wonde\Client($token);
        $school = $client->school($schoolID);

        /** TODO:
         * 1: Retrieve the list of employees to send to the front-end.
         *    This list will be displayed in a dropdown for the user to select from.
         * 2: A list of classes that correlates to the employee ID will be retrieved and displayed in a second dropdown.
         * 3: After the user selects a class from the second list,
         *    the student names that correlates to the class ID will be retrieved.
         */

        return Inertia::render('Classroom');
    }

    // Get and return a list of employees
    public function getEmployees($school) {
        $employeeArray = array();
        foreach ($school->employees->all() as $employee) {
            array_push($employeeArray, $employee->forename . ' ' . $employee->surname);
        }
        return $employeeArray;
    }

    // Get a list of classes
    public function getClasses($school) {
        $classArray = array();
        foreach ($school->classes->all() as $class) {
            array_push($classArray, $class->name);
        }
        return $classArray;
    }

    // Get and return a list of students with contact info
    public function getStudents($school) {
        $studentArray = array();
        foreach ($school->students->all(['contacts']) as $student) {
            array_push($studentArray, $student->forename . ' ' . $student->surname);
        }
        return $studentArray;
    }
}
