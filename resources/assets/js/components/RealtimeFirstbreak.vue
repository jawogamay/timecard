<template>
    <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Break In </th>
                   <th> Break Out </th>
                
                </tr>
            </thead>
            <tbody>
                <tr v-for="firstbreak in firstbreaktimes">
                    <td>{{firstbreak.userinfo.user.name}}</td>
                    <td>{{firstbreak.started_at | dateWithTime}}</td>
                    <td v-if="firstbreak.stopped_at != null"> {{firstbreak.stopped_at | dateWithTime}}</td>
                    <td v-else><p class="text-danger">Not yet clocked out</p></td>
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
            this.getRealtimeFirstBreak();
        },
        methods:{
            getRealtimeFirstBreak(){
                axios.get('/getRealtimeFirstBreak').then(({data}) => this.firstbreaktimes = data)
            }
        }
    };
</script>