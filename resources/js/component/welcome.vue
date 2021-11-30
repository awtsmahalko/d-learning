<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row" v-show="false">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                        <i class="material-icons">meeting_room</i>
                        </div>
                        <p class="card-category">No. of Classes</p>
                        <h3 class="card-title">1
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        <i class="material-icons text-danger">warning</i>
                        <a href="javascript:;">Get More Space...</a>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                        <i class="material-icons">people</i>
                        </div>
                        <p class="card-category">No. of Students</p>
                        <h3 class="card-title">1</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        <i class="material-icons">date_range</i> Last 24 Hours
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                        <i class="material-icons">books</i>
                        </div>
                        <p class="card-category">Pending Activities</p>
                        <h3 class="card-title">75</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        <i class="material-icons">local_offer</i> Tracked from Github
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon"><i class="material-icons">info_outline</i></div>
                        <p class="card-category">No. of Announcement</p>
                        <h3 class="card-title">+245</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <dashboard-work />
            </div>
        </div>
    </div>
</template>
<script>
import DashboardWork from './dashboard/classWork.vue';
export default {
    components: { DashboardWork },
}
</script>
<style scoped>
.comment {
  font-size: 14px;
  font-weight: 800;
  margin-bottom: 2px;
  /* white-space: break-spaces; */
}

.dropdown-toggle::after {
  content: none !important;
}
</style>
