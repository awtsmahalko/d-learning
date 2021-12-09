<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Student</h4>
                            <p class="card-category">Master Data of all Students</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button class="btn btn-sm btn-primary" @click="showCreateModal">
                                        <span class="material-icons">add_circle</span> New Student
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Student</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="listStudent.length > 0">
                                            <tr v-for="(studentData, keyStudent) in listStudent" :key="keyStudent">
                                                <td>{{ keyStudent + 1 }}</td>
                                                <td>{{ studentData.student_id }}</td>
                                                <td>{{ studentData.fname + " " + studentData.mname + " "+studentData.lname }}</td>
                                                <td>{{ studentData.username }}</td>
                                                <td>{{ studentData.email }}</td>
                                                <td class="text-right">
                                                    <button class="btn btn-sm btn-warning" @click="showUpdateModal(studentData)">
                                                        <span class="material-icons">edit_note</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" @click="deleteData(studentData.id)">
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
        <student-modal-create :key="userKey" :UserId="UserId" :ModalType="modalType" :StudentData="studentData" />
    </div>
</template>
<script>
import studentModalCreate from "./studentModalCreate.vue"

export default {
  components: { studentModalCreate },
  name : 'student-index',
  data(){
      return {
          listStudent : [],
          UserId : '',
          modalType: '',
          userKey: 0,
          studentData : []
      }
  },
  created() {
    this.fetchStudent();
    this.userKey
  },
  methods:{
      showCreateModal(){
        this.userKey++;
        this.modalType = 'C';
        this.studentData = [];

        setTimeout(function () { $("#studentCreateModal").modal('show'); }.bind(this), 500)
      },
      fetchStudent(){
        axios.get(baseUrl + "/api/student/view/record").then((res) => {
            this.listStudent = res.data;
        }).catch(error => {
            console.log(error);
        });
      },
      showUpdateModal(data){
        this.userKey++;
        this.modalType = 'U';
        this.studentData = data;
        
        setTimeout(function () { $("#studentCreateModal").modal('show'); }.bind(this), 500)

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
                    _this.fetchStudent();
                    response.data == 1 ? success_delete() : swal('Cannot proceed','Student has records','warning');
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
        this.$root.$on('fetchStudentRecordEvent', function(){
            thisInstance.fetchStudent()
        })
    }
}
</script>
