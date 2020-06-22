<template>
    <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Time </th>
                   <th> Others In </th>
                
                </tr>
            </thead>
            <tbody>
                <tr v-for="firstbreak in firstbreaktimes">
                    <td>{{firstbreak.userinfo.user.name}}</td>
                    <td><countdown :time="new Date(firstbreak.time_outexpire) - new Date()">
                      <template slot-scope="props">{{ props.hours }} hours, {{ props.minutes }} minutes, {{ props.seconds }} seconds.</template>
                    </countdown>&nbsp;</td>
                    <td> {{firstbreak.started_at | dateWithTime}}</td>
                    <!-- <td v-else><p class="text-danger">Not yet clocked out</p></td> -->
                </tr>
            </tbody>
        </table>
    
</template>
<script type="text/javascript">
    export default{
        data(){
            return{
                firstbreaktimes:[],
            }
        },
        mounted(){
            this.getRealTimeOthers();
        },
        methods:{
            getRealTimeOthers(){
                axios.get('/getRealTimeOthers').then(({data}) => this.firstbreaktimes = data)
            }
        }
    };
</script>