<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Teacher</h4>
                            <p class="card-category">Master Data of all Teacher</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button class="btn btn-sm btn-primary" @click="showCreateModal">
                                        <span class="material-icons">add_circle</span> New Teacher
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Teacher</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="listTeacher.length > 0">
                                            <tr v-for="(teacherData, keyTeacher) in listTeacher" :key="keyTeacher">
                                                <td>{{ keyTeacher + 1 }}</td>
                                                <td>{{ teacherData.student_id }}</td>
                                                <td>{{ teacherData.fname + " " + teacherData.mname + " "+teacherData.lname }}</td>
                                                <td>{{ teacherData.username }}</td>
                                                <td>{{ teacherData.email }}</td>
                                                <td class="text-right">
                                                    <button class="btn btn-sm btn-warning" @click="showUpdateModal(teacherData)">
                                                        <span class="material-icons">edit_note</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" @click="deleteData(teacherData.id)">
                                                        <span class="material-icons">delete_forever</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <teacher-modal-create :key="userKey" :UserId="UserId" :ModalType="modalType" :TeacherData="teacherData" />
    </div>
</template>
<script>
import teacherModalCreate from "./teacherModalCreate.vue"

export default {
  components: { teacherModalCreate },
  name : 'teacher-index',
  data(){
      return {
          listTeacher : [],
          UserId : '',
          modalType: '',
          userKey: 0,
          teacherData : []
      }
  },
  created() {
    this.fetchTeacher();
    this.userKey
  },
  methods:{
      showCreateModal(){
        this.userKey++;
        this.modalType = 'C';
        this.teacherData = [];

        setTimeout(function () { $("#teacherCreateModal").modal('show'); }.bind(this), 500)
      },
      fetchTeacher(){
        axios.get(baseUrl + "/api/teacher/view/record").then((res) => {
            this.listTeacher = res.data;
        }).catch(error => {
            console.log(error);
        });
      },
      showUpdateModal(data){
        this.userKey++;
        this.modalType = 'U';
        this.teacherData = data;
        
        setTimeout(function () { $("#teacherCreateModal").modal('show'); }.bind(this), 500)

      },
      deleteData(id){
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
                .delete(baseUrl + "/api/user/delete/record",{
                    params:{
                        id:id
                    }
                })
                .then((response) => {
                    _this.fetchTeacher();
                    response.data == 1 ? success_delete() : entry_already_exists();
                })
                .catch((error) => {
                    console.log(error);
                });
            });
            },
            allowOutsideClick: false,
        });
      }
  },
    mounted(){
        const thisInstance = this
        this.$root.$on('fetchTeacherRecordEvent', function(){
            thisInstance.fetchTeacher()
        })
    }
}
</script>
