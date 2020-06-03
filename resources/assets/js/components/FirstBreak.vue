<template>
    <div>
        <form class="form-inline" @submit.prevent="getFirstBreakAll()">
        <div class="form-group">
            <label>From: </label>
            <input type="date" placeholder="Enter Date" v-model="form.date_from">
        </div>
        <div class="form-group" style="margin-left:10px;">
            <label>To: </label>
             <input type="date" placeholder="Enter Date" v-model="form.date_to">
        </div>
        <button type="submit" class="btn btn-success">Generate</button>
           <router-link class="btn btn-primary" to="/realtimefirstbreak">Go To Realtime Tracking </router-link>
        </form>
        <br><br>
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
            <tbody>
                 <tr v-for="firstbreak in firstbreaks">
                    <td>{{firstbreak.id}} </td> 
                    <td>{{firstbreak.userinfo.user.name}}</td>
                    <td> {{firstbreak.started_at | dateWithTime}} </td>
                    <td> {{firstbreak.stopped_at | dateWithTime}} </td>
                    <td>{{parseDate(firstbreak.started_at,firstbreak.stopped_at)}}</td>
                </tr>
            </tbody>
        </table>
        <!-- <pre>{{firstbreaks}}</pre> -->
    </div>
</template>
<script type="text/javascript">
import moment from 'moment'
    export default{
        data(){
            return{
                firstbreaks:[],
                 show:false,
                form:new Form({
                    id:'',
                    date_to:'',
                    date_from:''
                })

            }
        },
        mounted(){
            this.getFirstBreakAll();    
        },
        methods:{
            getFirstBreakAll(){
                axios.get('/getFirstBreakAll',{
                    params:{
                        date_to:this.form.date_to,
                        date_from:this.form.date_from
                    }
                }).then(({data}) => this.firstbreaks = data,
                this.show = true)
            },
           
             parseDate(start,end){
                return moment(end, 'YYYY.MM.DD HH:mm').diff(moment(start, 'YYYY.MM.DD HH:mm'), "m")
            }
        }

    };
</script>