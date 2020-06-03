<template>
    <div>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Clock in </th>
                    <th> Clock out </th>
                    <th> Action </th>
                
                </tr>
            </thead>
            <tbody>
                <tr v-for="reactivate in reactivates">
                    <td> {{reactivate.userinfo.user.name}}</td>
                    <td>{{reactivate.time_in | dateWithTime}}</td>
                    <td>{{reactivate.time_out | dateWithTime}}</td>
                    <td><button class="btn btn-danger" @click="reactivateUser(reactivate.id)">Reactivate <button class="btn btn-danger" @click="reactivateUser(reactivate.id)">Comment</button></button></td>

                </tr>
            </tbody>
        </table>
    </div>
</template>
<script type="text/javascript">
    export default{
        data(){
            return{
                reactivates:[]
            }
        },
        mounted(){
                this.getReactivateData();
        },
        methods:{
            getReactivateData(){
                axios.get('/reactivateTimecard').then(({data}) => this.reactivates = data)
            },
            reactivateUser(id){
                axios.put('/reactivateUser/'+id).then((response)=> {

                })
            }
        }
    };
</script>