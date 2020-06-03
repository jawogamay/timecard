<template>
    <div>
        <form class="form-inline" @submit.prevent="getLunchBreakLogs()">
        <div class="form-group">
            <label>From: </label>
            <input type="date" placeholder="Enter Date" v-model="form.date_from">
        </div>
        <div class="form-group" style="margin-left:10px;">
            <label>To: </label>
             <input type="date" placeholder="Enter Date" v-model="form.date_to">
        </div>
        <button type="submit" class="btn btn-success">Generate</button>
           <router-link class="btn btn-primary" to="/realtimelunch">Go To Realtime Tracking </router-link>
        </form>
        <br>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> User </th>
                    <th> Clock In </th>
                    <th> Clock Out </th>
                    <th>Minutes Spent </th>
                </tr>
            </thead>
            <tbody v-if="show">
                 <tr v-for="lunchbreak in lunchbreaks">
                    <td>{{lunchbreak.id}} </td> 
                    <td>{{lunchbreak.userinfo.user.name}}</td>
                    <td> {{lunchbreak.started_at | dateWithTime}} </td>
                    <td> {{lunchbreak.stopped_at | dateWithTime}} </td>
                    <td>{{parseDate(lunchbreak.started_at,lunchbreak.stopped_at)}}&nbsp;<span class="btn btn-danger btn-xs" v-if="parseDate(lunchbreak.started_at,lunchbreak.stopped_at)>75">Over Lunch</span></td>
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
                lunchbreaks:[],
                show:false,
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
             getLunchBreakLogs(){
                axios.get('/getAlllunchbreak',{
                    params:{
                        date_to:this.form.date_to,
                        date_from:this.form.date_from
                    }
                }).then(({data}) => this.lunchbreaks = data,
                this.show = true)
            },
              parseDate(start,end){
                return moment(end, 'YYYY.MM.DD HH:mm').diff(moment(start, 'YYYY.MM.DD HH:mm'), "m")
            }
        }
    };
</script>