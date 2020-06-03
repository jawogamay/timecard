<template>
    <div>
          <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Time </th>
                    <th> Action </th>
                
                </tr>
            </thead>
            <tbody>
                 <tr v-for="clock in realtimeclocks">
                    <td>{{clock.userinfo.user.name}}</td>
                    <!-- {{new Date(clock.time_in)}} -->
           
                    <!-- {{new Date(clock.userinfo.schedule.created_at).getTime() - new Date(clock.time_in).getTime()}} -->
                    <td > <countdown :time="new Date(clock.time_outexpire) - new Date()">
                      <template slot-scope="props">{{ props.hours }} hours, {{ props.minutes }} minutes, {{ props.seconds }} seconds.</template>
                    </countdown>&nbsp; <span class="btn btn-danger btn-xs" v-if="clock.late_flag===1">Late</span> </td>
                    <td><button class="btn btn-danger" @click="clockout(clock.id)">Clock Out</button> </td>
                   <!--  {{clock.time_in | format_date}}
                    {{newYear}}
                    {{new Date()}}
                    {{clock.userinfo.schedule.time_out.split(':').reduce((acc,time)=> (60*acc) + +time)}} -->
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script type="text/javascript">
import moment from 'moment'
    export default{
        data(){
            let now = new Date();
            let newYear = new Date(now.getFullYear()+1,0,1)
            return{
                realtimeclocks:[],
                activeTimerString: 'Calculating...',
                counter: { seconds: 0, timer: null },
                time: newYear -now,
                newYear:new Date(now.getFullYear()+1,0,1)

            }
        },
        mounted(){
            this.getRealtime();
            this.createdClocks();
        },
        filters:{
            format_date(value){
                if(value){
                    return moment(String(value)).format('YYYYMMDD')
                }
            },
        },
        methods:{
            getRealtime(){
                axios.get('/getRealtime').then(response => {
                    this.realtimeclocks = response.data
                    this.startTimer(this.realtimeclocks)
                })
            },
          clockout(id){
                swal.fire({
                    title: 'Clock Out',
                    text: "Press the Yes Button To Clock Out",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result)=> {
                    if(result.value){
                        axios.put('/updatetimecard/'+id).then(()=> {
                            toast.fire({
                                icon:'success',
                                title:'Clock In Submitted'
                            })
                            Fire.$emit('createdClocks')
                        })
                    }
                })
            },
            createdClocks(){
                this.getRealtime();
                Fire.$on('createdClocks',()=> {
                    this.getRealtime()
                })
            },
       
        }
    };
</script>