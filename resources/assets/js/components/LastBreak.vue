<template>
    <div>
        <form class="form-inline" @submit.prevent="getLastBreakLogs()">
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
            <!-- <tbody v-if="show">
                 <tr v-for="lastbreak in lastbreaks">
                    <td>{{lastbreak.id}} </td> 
                    <td>{{lastbreak.userinfo.user.name}}</td>
                    <td> {{lastbreak.started_at | dateWithTime}} </td>
                    <td> {{lastbreak.stopped_at | dateWithTime}} </td>
                    <td>{{parseDate(lastbreak.started_at,lastbreak.stopped_at)}}&nbsp;<span class="btn btn-danger btn-xs" v-if="parseDate(lastbreak.started_at,lastbreak.stopped_at)>75">Over Lunch</span></td>
                </tr>
            </tbody> -->
        </table>
    </div>
</template>
<script type="text/javascript">
import moment from 'moment'
    export default{
        data(){
            return{
                lastbreaks:[],
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
             getLastBreakLogs(){
                axios.get('/getAllLastbreak',{
                    params:{
                        date_to:this.form.date_to,
                        date_from:this.form.date_from
                    }
                }).then(({data}) => this.lastbreaks = data,
                this.show = true)
            },
              parseDate(start,end){
                return moment(end, 'YYYY.MM.DD HH:mm').diff(moment(start, 'YYYY.MM.DD HH:mm'), "m")
            }
        }
    };
</script>