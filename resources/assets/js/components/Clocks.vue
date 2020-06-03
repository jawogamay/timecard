<template>
    <div>
      <form class="form-inline" @submit.prevent="getClocks()">
        <div class="form-group">
            <label>From: </label>
            <input type="date" placeholder="Enter Date" v-model="form.date_from">
        </div>
        <div class="form-group" style="margin-left:10px;">
            <label>To: </label>
             <input type="date" placeholder="Enter Date" v-model="form.date_to">
        </div>
        <button type="submit" class="btn btn-success">Generate</button>
        <router-link class="btn btn-primary" to="/realtimeclocks">Go To Realtime Tracking </router-link>
        <router-link class="btn btn-danger" to="/reactivate">Reactivate </router-link>

      </form>
      <br>
                <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Name </th>
                    <th> Clock In </th>
                    <th> Clock Out </th>
                    <th>Hours Spent </th>
                    <th>Minutes Spent </th>
                </tr>
            </thead>
            <tbody>
                 <tr v-for="clock in clocks">
                    <td>{{clock.id}} </td> 
                    <td>{{clock.userinfo.user.name}}</td>
                    <td> {{clock.time_in | dateWithTime}} <span class="btn btn-danger btn-xs" v-if="clock.late_flag===1">Late</span></td>
                    <td> {{clock.time_out | dateWithTime}} </td>
                    <td>{{clock.hours}}</td>
                    <td>{{clock.minutes}}</td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-danger" v-if="show" @click="exportReport()"> Download Report </button>
   
    </div>
</template>
<script type="text/javascript">
import moment from 'moment'
    export default{
        data(){
            return{
                show:false,
                clocks:[],
                form:new Form({
                    id:'',
                    date_to:'',
                    date_from:''
                })
            }
        },
        mounted(){
            
        },
        methods:{
            getClocks(){
                axios.get('/getTimecardAll',{
                    params:{
                        date_to:this.form.date_to,
                        date_from:this.form.date_from
                    }
                }).then(({data}) => this.clocks = data,
                this.show = true)
            },
            exportReport(){
                axios({
                  url: '/export', //your url
                  method: 'GET',
                  responseType: 'blob',
                  params:{
                    date_to:this.form.date_to,
                        date_from:this.form.date_from
                  } // important
                }).then((response) => {
                   const url = window.URL.createObjectURL(new Blob([response.data]));
                   const link = document.createElement('a');
                   link.href = url;
                   link.setAttribute('download', 'files.xlsx'); //or any other extension
                   document.body.appendChild(link);
                   link.click();
                });
            }
       /*     parseDate(start,end){
                return moment(end, 'YYYY.MM.DD HH:mm').diff(moment(start, 'YYYY.MM.DD HH:mm'), "hours")
            }*/
        }
    };
</script>