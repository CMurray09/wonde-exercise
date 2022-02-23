<?php

namespace Tests\Unit;

use App\Http\Controllers\WondeApiController;
use PHPUnit\Framework\TestCase;

class ApiControllerTest extends TestCase
{
    /**
     * Should retrieve the list of employees that have one or more classes.
     *
     * @return void
     */
    public function test_api_employee_list_can_be_retrieved()
    {
        $controller = new WondeApiController();
        $school = $controller->getSchoolWithTokenAndID();
        $response = $controller->getEmployees($school);
        $this->assertNotNull($response);
    }

    /**
     * Should retrieve the list of classes from an employeeID
     *
     * @return void
     */
    public function test_api_class_list_can_be_retrieved()
    {
        $employeeID = 'A1375078684';
        $controller = new WondeApiController();
        $school = $controller->getSchoolWithTokenAndID();
        $response = $controller->getClasses($school, $employeeID);
        $this->assertNotNull($response);
    }

    /**
     * Should retrieve the list of students from an employeeID and classID
     *
     * @return void
     */
    public function test_api_student_list_can_be_retrieved()
    {
        $employeeID = 'A1375078684';
        $classID = 'A1022974129';
        $controller = new WondeApiController();
        $school = $controller->getSchoolWithTokenAndID();
        $response = $controller->getStudents($school, $classID, $employeeID);
        $this->assertNotNull($response);
    }
}
