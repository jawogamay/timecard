<template>
    <div>
        <button class="btn btn-success" @click="newModal()">Add Schedule</button>
        <modal :title="title">
            <form class="form-horizontal" @submit.prevent = "createSchedule()">
                <alert-error :form="form" message="There were some problems with your input."></alert-error>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="user">Shift:</label>
                    <div class="col-sm-9">
                      <input type="text" v-model="form.nameshift" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="timein">Time In:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.timein">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="timeout">Time Out:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.timeout">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="fbin">First Break In:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.fbin">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="fbout">First Break Out:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.fbout">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="fbout">Lunch Break In:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.lunchin">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="fbout">Lunch Break Out:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.lunchout">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="fbout">Last Break In:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.lbin">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="fbout">Last Break Out:</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" v-model="form.lbout">
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </modal>

      <!--   <vue-bootstrap4-table :rows="schedules" :columns="columns" :config="config">
        </vue-bootstrap4-table> -->
        <br><br>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Shift </th>
                    <th> Clock In </th>
                    <th> Clock Out </th>
                </tr>
            </thead>
            <tbody>
                 <tr v-for="schedule in schedules">
                    <td>{{schedule.id}} </td> 
                    <td>{{schedule.nameshift}}</td>
                    <td> {{schedule.time_in}} </td>
                    <td> {{schedule.time_out}} </td>
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
            let title = "Schedule"
            return{
                title:title,
                schedules:[],
                columns:[
                    {
                        label:"ID",
                        name: "id",
                        filter:{
                            type:"simple",
                            placeholder:"ID"
                        },
                        sort:true,
                    },
                    {
                        label:"Shift",
                        name:"nameshift",
                        filter:{
                            type:"simple",
                            placeholder:"Shift",
                        },
                        sort:true
                    },
                    {
                        label:"Clock In",
                        name:"time_in",
                        sort:true
                    },
                    {
                        label:"Clock Out",
                        name:"time_out",
                        sort:true
                    }
                ],
                 config: {
                    checkbox_rows: false,
                    rows_selectable: true,
                   
                    show_refresh_button: false,
                    show_reset_button: false
                },
                form:new Form({
                    nameshift:'',
                    timein:'',
                    timeout:'',
                    fbin:'',
                    fbout:'',
                    lunchin:'',
                    lunchout:'',
                    lbin:'',
                    lbout:''
                })
            }
        },
        mounted(){
            this.getSchedule()
        },
        methods:{
            newModal(){
                $('#addNew').modal('show')
                this.form.reset();
            },
            createSchedule(){
                this.form.post('/schedule').then(()=> {
                    $('#addNew').modal('hide')
                    this.form.clear()
                    toast.fire({
                        icon:'success',
                        title:'Schedule Added Successfully'
                    });
                });
            },
            getSchedule(){
                axios.get('/schedule').then(({data}) => this.schedules = data)
            },
        }
    };
</script>