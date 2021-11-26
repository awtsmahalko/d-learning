<template>
    <div class="card">
        <div class="card-body">
            <table border="1px" width="100%" style="text-align:center;
            ">
                <thead>
                    <tr>
                        <th>Student's Name</th>
                        <th>Present</th>
                        <th>Late</th>
                        <th>Absent</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gomed, Reynaldo</td>
                        <td>50</td>
                        <td>50</td>
                        <td>50</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    name:'student-attendance',
    data(){
        return {
            classId:''
        }
    },
    created(){
        this.classId = this.$route.params.id;
        // this.fetchAttendance();
    }, 
    methods: {
    fetchAttendance() {
      axios
        .get(baseUrl + "/api/class/attendance/view", {
          params: {
            class_id: this.classId
          },
        })
        .then((data) => {
          console.log(data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
}
</script>