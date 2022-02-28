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
                <option v-for="classList in this.classList" :value="classList.id">
                    {{classList.className}}
                </option>
            </select>
        </div>
    </div>

    <table v-if="this.studentList.length > 0">
        <tr>
            <th>Student's Full Name</th>
        </tr>
        <tr v-for="student in studentList"><td>{{ student }}</td></tr>
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
            classID: null,
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
             /** Checks if the same or default option has been selected. No need to reload the same data. */
            if (event.target.value !== "Choose Employee" && this.employeeID !== event.target.value) {
                this.employeeID = event.target.value;
                this.classList = [];
                this.studentList = [];
                axios.get('/classes/' + this.employeeID)
                    .then((response) => {
                        for(const item of response.data[0]) {
                            this.classList.push(item);
                        }
                }).catch(function (error) {
                    console.log(error);
                })
            }
        },
        onChangeClass(event) {
            /** Checks if the same or default option has been selected. No need to reload the same data. */
            if (event.target.value !== "Choose Class" && this.classID !== event.target.value) {
                this.classID = event.target.value;
                this.studentList = [];
                axios.get('/students/' + this.classID + '/' + this.employeeID)
                    .then((response) => {
                        for(const item of response.data[0]) {
                            this.studentList.push(item);
                        }
                }).catch(function (error) {
                    console.log(error);
                })
            }
        }
    }
};

</script>
