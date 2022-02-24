<template>
    <div>
        <h2 class="font-semibold text-xl leading-tight">
            Classroom
        </h2>
    </div>
    <div class="flex-row">
        <div class="flex-col">
            <select class="form-control" @change="onChangeEmployee($event)">
                <option value="Choose Employee">Choose Employee</option>
                <option v-for="employee in employees" :value="employee.id">
                    {{employee.fullName}}
                </option>
            </select>
        </div>
    </div>

    <div class="flex-row" v-if="this.classList.length > 0">
        <div class="flex-col">
            <select class="form-control" @change="onChangeClass($event)">
                <option value="Choose Class">Choose Class</option>
                <option v-for="className in classList" :value="className.id">
                    {{className.className}}
                </option>
            </select>
        </div>
    </div>

    <table v-if="this.studentList.length > 0">
        <tr>
            <th>Student Full Name</th>
        </tr>
        <tr v-for="student in studentList"><td>{{ student.fullName }}</td></tr>
    </table>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            classList: [],
            studentList: [],
            employeeID: null,
            studentID: null,
        }
    },
    props: {
        employees: {
            fullName: String,
            id: String,
        },
    },
    methods: {
        onChangeEmployee(event) {
            let employeeID = event.target.value;
            if (employeeID !== "Choose Employee") {
                axios({
                    method: 'get',
                    url: '/classes',
                    params: {
                        employeeID
                    }
                }).then(function (response) {
                    // Check console for class list array
                    console.log(response.data.data);
                    this.classList = response.data.data;
                }).catch(function (error) {
                    console.log(error);
                })
            }
        },
        onChangeClass(event) {
            let employeeID = event.target.value;
            let studentID = event.target.value;
            if (employeeID !== "Choose Employee") {
                axios({
                    method: 'get',
                    url: '/students',
                    params: {
                        employeeID: employeeID,
                        studentID: studentID
                    }
                }).then(function (response) {
                    // Check console for student list array
                    console.log(response.data.data);
                    this.studentList = response.data.data;
                }).catch(function (error) {
                    console.log(error);
                })
            }
        }
    }
};

</script>
