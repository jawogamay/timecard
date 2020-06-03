<template>
    <div>
         <form class="form-inline" @submit.prevent="getOthersData()">
        <div class="form-group">
            <label>From: </label>
            <input type="date" placeholder="Enter Date" v-model="form.date_from">
        </div>
        <div class="form-group" style="margin-left:10px;">
            <label>To: </label>
             <input type="date" placeholder="Enter Date" v-model="form.date_to">
        </div>
        <button type="submit" class="btn btn-success">Generate</button>
           <router-link class="btn btn-primary" to="/realtimeothers">Go To Realtime Tracking </router-link>
        </form>
        <br><br>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> User </th>
                    <th> Description </th>
                    <th> Clock In </th>
                    <th> Clock Out </th>
                    <th>Minutes Spent </th>
                </tr>
            </thead>
            <tbody>
                 <tr v-for="odd in odds">
                    <td>{{odd.id}} </td> 
                    <td>{{odd.userinfo.user.name}}</td>
                    <td> {{odd.name}} </td>
                    <td> {{odd.started_at | dateWithTime}} </td>
                    <td> {{odd.stopped_at | dateWithTime}} </td>
                    <td>{{parseDate(odd.started_at,odd.stopped_at)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script type="text/javascript">
import moment from 'moment'
    export default{
        data(){
            return{
                odds:[],
                show:false,
                form:new Form({
                    id:'',
                    date_to:'',
                    date_from:''
                })
            }
        },
        mounted(){
            this.getOthersData()
        },
        methods:{
              getOthersData(){
                axios.get('/othersall',{
                    params:{
                        date_to:this.form.date_to,
                        date_from:this.form.date_from
                    }
                }).then(({data}) => this.odds = data,
                this.show = true)
            },
               parseDate(start,end){
                return moment(end, 'YYYY.MM.DD HH:mm').diff(moment(start, 'YYYY.MM.DD HH:mm'), "m")
            }
        }
    };
</script>
