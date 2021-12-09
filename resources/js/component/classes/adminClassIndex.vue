<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Class</h4>
                    <p class="card-category">Here you can manage your classes</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button class="btn btn-sm btn-primary" @click="showAddModal">
                                <span class="material-icons">add_circle</span> Add Class
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Teacher</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="classes.length > 0">
                                <tr v-for="(ClassData, keyClasses) in classes" :key="keyClasses">
                                    <td>{{ keyClasses + 1 }}</td>
                                    <td>{{ ClassData.code }}</td>
                                    <td>{{ ClassData.name }}</td>
                                    <td>{{ ClassData.description }}</td>
                                    <td>{{ ClassData.user.fname + " " + ClassData.user.mname + " " + ClassData.user.lname }}</td>
                                    <td class="text-right">
                                        <router-link
                                            :to="{
                                            name: 'classView',
                                            params: { id: ClassData.id },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            ><span class="material-icons">preview</span></router-link
                                        >
                                        <router-link
                                            :to="{
                                            name: 'classlistView',
                                            params: { id: ClassData.id },
                                            }"
                                            class="btn btn-sm btn-alert"
                                            ><span class="material-icons">groups</span></router-link
                                        >
                                        <button class="btn btn-sm btn-warning" @click="showUpdateModal(ClassData)">
                                            <span class="material-icons">edit_note</span>
                                        </button>
                                        <button class="btn btn-sm btn-danger" @click="deleteClass(ClassData.id)">
                                            <span class="material-icons">delete_forever</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                <td colspan="4" align="center">No Classes Found</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <class-modal-create :key="ModalKey" :UserId="ModalUserId" :ModalType="ModalType" :ModalData="ModalData"/>
    </div>
</template>
<script>
import classModalCreate from './classModalCreate.vue';
export default {
    components: { classModalCreate },
    name: 'admin-class-index',
    data(){
        return {
            classes : [],
            ModalKey: 0,
            ModalUserId: 0,
            ModalType:'',
            ModalData:[]
        }
    },
    mounted() {
        this.getClasses();

        const thisInstance = this
        this.$root.$on('fetchClassRecordEvent', function(){
            thisInstance.getClasses()
        })
    },
    methods: {
        async getClasses() {
            await this.axios
            .get(baseUrl + "/api/class/view/record", {
                params: {
                    user_id: sessionUserId,
                    category: sessionCategory,
                },
            })
            .then((response) => {
                this.classes = response.data;
            })
            .catch((error) => {
            console.log(error);
            });
        },
        deleteClass(id) {
            var _this = this;
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                return new Promise(function (resolve) {
                    axios
                    .delete(baseUrl + "/api/class/delete/record",{
                        params:{
                            id:id
                        }
                    })
                    .then((response) => {
                        _this.getClasses();
                        response.data == 1 ? success_delete() : swal('Cannot proceed','Class has records','warning');;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                });
                },
                allowOutsideClick: false,
            });
        },
        showAddModal() {
            this.ModalKey++;
            this.ModalType = 'C';
            this.ModalData = [];

            setTimeout(function () { $("#classCreateModal").modal('show'); }.bind(this), 500)
        },
        showUpdateModal(data) {
            this.ModalKey++;
            this.ModalType = 'U';
            this.ModalData = data;

            setTimeout(function () { $("#classCreateModal").modal('show'); }.bind(this), 500)
        },
    },
}
</script>
