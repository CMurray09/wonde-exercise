<template>
    <div>
        <h2 class="font-semibold text-xl leading-tight">
            Classroom
        </h2>
    </div>
    <div class="flex-row">
        <div class="flex-col">
            <select v-bind:value="employees">
                <option>John Doe</option>
                <option>Emma Smith</option>
            </select>
        </div>

        <div class="flex-col">
            <select v-bind:value="classes">
                <option>English</option>
                <option>Math</option>
            </select>
        </div>
    </div>

    <table v-bind:value="students">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
        <tr><td>Kelsey</td><td>Smith</td></tr>
        <tr><td>Jacob</td><td>Smith</td></tr>
    </table>
</template>

<script>
import { defineComponent } from 'vue'
import Dropdown from "@/Jetstream/Dropdown";

export default defineComponent({
    components: {Dropdown},
    props: {
        employees: Array,
        classes: Array,
        students: Array,
    }
})
</script>
