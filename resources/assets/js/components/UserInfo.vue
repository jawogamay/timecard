<template>
    <div>
        <button class="btn btn-success" @click="newModal()">Add User Info</button>
        <br><br>
        <modal :title="title">
            <form class="form-horizontal" @submit.prevent = "addUserInfo()">
                <alert-error :form="form" message="There were some problems with your input."></alert-error>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="user">User:</label>
                    <div class="col-sm-10">
                      <select class="form-control" v-model="form.user">
                        <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="schedule">Schedule:</label>
                    <div class="col-sm-10">
                      <select class="form-control" v-model="form.schedule">
                        <option v-for="schedule in schedules" :key="schedule.id" :value="schedule.id">{{schedule.nameshift}}</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="department">Department:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="department" placeholder="Enter Department" v-model="form.department">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="position">Position:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="position" placeholder="Enter Position" v-model="form.position">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="position">Details:</label>
                    <div class="col-sm-10">
                      <textarea type="text" class="form-control" id="position" placeholder="Enter Details" v-model="form.details"></textarea>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </modal>
         <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Department </th>
                    <th> Position </td>
                   <th> Sched Clock in </th>
                    <th> Sched Clock out </th>
                
                </tr>
            </thead>
            <tbody>
                <tr v-for="userinfo in userinfos">
                    <td>{{userinfo.user.name}}</td>
                    <td>{{userinfo.department}}</td>
                    <td>{{userinfo.position}}</td>
                    <td>{{userinfo.schedule.time_in}}</td>
                    <td>{{userinfo.schedule.time_out}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script type="text/javascript">
import Modal from './Reusable/Modal.vue'
    export default{
        components:{
            Modal
        },
        data(){
            let title = "User Information"
            return{
                title:title,
                users:[],
                userinfos:[],
                schedules:[],
                form:new Form({
                    user:'',
                    schedule:'',
                    position:'',
                    details:'',
                    department:''
                })      
            }
        },
        mounted(){
            this.getUsers();
            this.getSchedule();
            this.getUserInfo();
        },
        methods:{
            newModal(){
                $('#addNew').modal('show');
            },
            addUserInfo(){
                this.form.post('/userinfo').then(()=> {
                    $('#addNew').modal('hide')
                    this.form.clear()
                    toast.fire({
                        icon:'success',
                        title:'User Information Added Successfully'
                    })
                })
            },
            getUserInfo(){
                axios.get('/getAllUserInfo').then(({data}) => this.userinfos = data)
            },
            getUsers(){
                axios.get('/users').then((response) => {
                    if(response.data != 0){
                        this.users = response.data
                    }
                })
            },
            getSchedule(){
                axios.get('/getSchedule').then((response) => {
                    if(response.data != 0)
                        this.schedules = response.data
                })
            }
        }
    };
</script>
<style scoped>
label{
    text-align: left;
    color:#5a7391;
}


</style>