<template>
    <div id="classroomContainer">
        <div id="classroomHeader">
            <h1 class="font-semibold text-3xl leading-tight greyText">
                Classroom
            </h1>
        </div>
        <loading :active="isLoading"></loading>
        <div class="flex-row divPadding">
            <div class="flex-col">
                <label class="greyText">Employees</label><br>
                <select class="form-control" @change="onChangeEmployee($event)">
                    <option value="Choose Employee">Choose Employee</option>
                    <option v-for="employee in employees" :value="employee.id">
                        {{employee.fullName}}
                    </option>
                </select>
            </div>
        </div>

        <div class="flex-row divPadding" v-if="this.classList.length > 0">
            <div class="flex-col">
                <label class="greyText">Classes</label><br>
                <select class="form-control" @change="onChangeClass($event)">
                    <option value="Choose Class">Choose Class</option>
                    <option v-for="classList in this.classList" :value="classList.id">
                        {{classList.className}}
                    </option>
                </select>
            </div>
        </div>

        <div class="flex-row divPadding" id="classroomTable">
            <div class="flex-col">
                <table class="greyText" v-if="this.studentList.length > 0">
                    <tr>
                        <th class="text-2xl tableHeaderPadding">Students</th>
                    </tr>
                    <tr v-for="student in studentList"><td>{{ student }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</template>

<style>
    #classroomContainer {
        background-color: #2d3748;
        position: relative;
        margin: 0 auto;
        width: 50em;
        min-height: 50em;
        top: 5em;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .greyText {
        color: #9ca3af;
    }
    .divPadding {
        padding-top: 2em;
        padding-bottom: 2em;
    }
    .tableHeaderPadding {
        padding-bottom: 1em;
    }
    #classroomHeader {
        padding-top: 2em;
    }
    #classroomTable {
        display: flex;
        justify-content: center;
    }
    #classroomTable table {
        align-self: center;
    }
</style>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components: {
        Loading
    },
    data() {
        return {
            classList: [],
            studentList: [],
            employeeID: null,
            classID: null,
            isLoading: false,
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
                this.isLoading = true;
                axios.get('/classes/' + this.employeeID)
                    .then((response) => {
                        for(const item of response.data[0]) {
                            this.classList.push(item);
                        }
                        this.isLoading = false;
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
                this.isLoading = true;
                axios.get('/students/' + this.classID + '/' + this.employeeID)
                    .then((response) => {
                        for(const item of response.data[0]) {
                            this.studentList.push(item);
                        }
                        this.isLoading = false;
                    }).catch(function (error) {
                    console.log(error);
                })
            }
        }
    }
};

</script>
