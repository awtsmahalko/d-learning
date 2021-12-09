<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button class="btn btn-sm btn-primary" @click="showAddModal" v-show="show_actions"> 
                                <span class="material-icons">add_circle</span> Add Student
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                            <thead class="text-primary">
                                <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Date Joined</th>
                                <th class="text-right" v-show="show_actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="studentsList.length > 0">
                                <tr v-for="(list, keyList) in studentsList" :key="keyList">
                                <td>{{ keyList+1 }}</td>
                                <td>
                                    {{ list.user.fname +
                                    " " +
                                    list.user.mname +
                                    " " +
                                    list.user.lname
                                    }}
                                </td>
                                <td>
                                    {{ new Date(list.created_at).toLocaleString() }}
                                </td>
                                <td v-show="show_actions">
                                    <button class="btn btn-sm btn-danger" @click="removeStudent(list.id)">
                                    <span class="material-icons">remove_circle</span> Remove </button>
                                </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">No Class List Found</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <class-list-modal-create :classesId="classesId" :key="classModalKey" />
    </div>
</template>
<script>
import classListModalCreate from './classListModalCreate.vue'

export default {
    components: { classListModalCreate },
    name:'class-list',
    props: ["classesId"],
    data() {
        return {
            studentsList: [],
            classModalKey: 0,
            show_actions : false
        };
    },
    created() {
        this.show_actions = sessionCategory == 'A' ? true : false;
        this.fetchStudentsList();
    },

    mounted() {
        const thisInstance = this
        this.$root.$on('fetchClassListRecordEvent', function(){
            thisInstance.fetchStudentsList()
        })
    },

    methods: {
        showAddModal() {
            this.classModalKey++;
            setTimeout(function () { $("#addClassListModal").modal('show'); }.bind(this), 500)
        },
        fetchStudentsList() {
            axios.get(baseUrl + "/api/studentsList", {
                params: {
                    class_id: this.classesId,
                },
            })
            .then((data) => {
                this.studentsList = data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },
        removeStudent(id) {
            var _this = this;
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, remove it!",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                return new Promise(function (resolve) {
                    axios
                    .delete(baseUrl + `/api/deleteStudentsList/${id}`)
                    .then((response) => {
                        _this.fetchStudentsList();
                        success_delete();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                });
                },
                allowOutsideClick: false,
            });
        },
    },
}
</script>
