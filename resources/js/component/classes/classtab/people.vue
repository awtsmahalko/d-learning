<template>
  <div class="container mt-3">
    <!-- <div class="col-md-12">teacher</div> -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h2 class="card-title">Students</h2>
          <p class="card-category">List of students enrolled in this class</p>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-right">
              <button class="btn btn-sm btn-primary" v-on:click="showAddModal">
                Add Student
              </button>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Date Joined</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td>fname, mname, lname</td>
                    <td>date created</td>
                    <td>
                      <button
                        class="btn btn-sm btn-danger"
                        @click="removeStudent(list.id)"
                      >
                        <span class="material-icons">remove_circle</span>
                        Remove
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
</template>