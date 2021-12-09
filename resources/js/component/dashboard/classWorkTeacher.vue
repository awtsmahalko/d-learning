<template>
    <div>
    <div v-for="(activity, keyDate) in activities" :key="keyDate">
    		<div class="row">
    			<h3>{{ keyDate }}</h3>
    		</div>
    		<div v-for="(rowData,key) in activity" :key="key">
    			<div class="card">
    				<table style="width:100%;padding:5px;border-radius:15px;" border="1">
    					<tr align="center">
    						<td width="20%" :rowspan="rowData.length + 1">
    							<b>{{ rowData[0].class.name }}</b>
    							<br> {{ rowData[0].user.fname + ' ' + rowData[0].user.lname}}
    						</td>
    					</tr>
    					<tr v-for="(actRow,keyRow) in rowData" :key="keyRow">
    						<td style="padding:10px;border-right:none;">
    							<b>{{ actRow.category == "A"
                                ? "ACTIVITY"
                                : actRow.category == "E"
                                ? "EXAM"
                                : "QUIZ"
                            }}</b>
    							<router-link :to="{
                                name: 'activityViewTeacher',
                                params: {
                                class_id: actRow.class_id,
                                activity_id: actRow.id,
                                },
                            }">: <b>{{ actRow.title }} </b>
    							</router-link>
    						</td>
    						<!-- <td style="padding:10px;border-left:none;border-right:none;" align="right">
    							<span style="color: green; font-weight: 500">SUBMITTED</span>
    						</td> -->
    						<td style="padding:10px;border-left:none;" align="right">DUE: {{ formatDate(actRow.duedate) }}</td>
    					</tr>
    				</table>
    			</div>
    		</div>
      </div>
  </div>
</template>
<script>
export default {
    name:'class-work-teacher',
    props:["activities"],
    methods:{
        formatDate(value){
            return moment(String(value)).format('hh:mm A')
        },
    }
}
</script>
