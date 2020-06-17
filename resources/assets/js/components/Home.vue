<template>
    <div>
       <div class="pull-right" v-if="!timecard.length">
            <button class="btn btn-default" @click="clockin()">Clock In</button>
       </div>

        <div class="pull-right" v-else>
            <button class="btn btn-default" @click="clockin()" v-if="timecard[0].time_out != null ">Clock In</button>
            <div v-if="timecard[0].time_out ==null">
                <button class="btn btn-danger" v-if="timecard[0].is_working" @click="clockout(timecard[0].id)">Clock Out</button>
                <div  v-if="!other.length" class="pull-right" style="margin-left:10px;">
                    <button class="btn btn-primary" @click="createOthers(timecard[0])">
                        Others
                    </button>
                </div>
                <div class="pull-right" v-else style="margin-left:10px;">
                    <button class="btn btn-primary" @click="createOthers(timecard[0])" v-if="other[0].stopped_at != null">
                        Others
                    </button>
                    <button class="btn btn-info" v-if="other.length && other[0].stopped_at == null" @click="backToWorking(other[0].id)">Clock Out Others</button>
                </div>
                <!-- <div class="pull-right">
                    <div v-if="!fbreak.length && !timecard[0].done_fbreak" class="pull-right" style="margin-left:10px;">
                        <button class="btn btn-warning" @click="clockFirstbreak(timecard[0])">First Break</button>
                    </div>

                    <div class="pull-right" v-else style="margin-left:10px;">
                    <button class="btn btn-warning" @click="clockFirstbreak(timecard[0])" v-if="fbreak[0].stopped_at != null && !timecard[0].done_fbreak">
                        First Break
                    </button>
                    <button class="btn btn-info" v-if="fbreak.length && fbreak[0].stopped_at == null" @click="backToWorkingBreak(fbreak[0].id)">Back To Working</button>
                </div>
                </div> -->
                 <!-- <div class="pull-right">
                    <div v-if="!lbreak.length && !timecard[0].done_lunch" class="pull-right" style="margin-left:10px;">
                        <button class="btn btn-info" @click="clockLunchbreak(timecard[0])">Lunch Break</button>
                    </div>

                    <div class="pull-right" v-else>
                    <button class="btn btn-info" @click="clockLunchbreak(timecard[0])" v-if="lbreak[0].stopped_at != null && timecard[0].done_fbreak && !timecard[0].done_lunch ">
                        Lunch Break
                    </button>
                    <button class="btn btn-info" v-if="lbreak.length && lbreak[0].stopped_at == null" @click="backToWorkingLBreak(lbreak[0].id)">Back To Working</button>
                </div>
                </div> -->
                   <div class="pull-right">
                    <div v-if="!lbreak.length" class="pull-right" style="margin-left:10px;">
                        <button class="btn btn-info" @click="clockLunchbreak(timecard[0])">Lunch Break</button>
                    </div>

                    <div class="pull-right" v-else>
                    <button class="btn btn-info" style="margin-left:10px;" @click="clockLunchbreak(timecard[0])" v-if="lbreak[0].stopped_at != null && !timecard[0].done_lunch ">
                        Lunch Break
                    </button>
                    <button class="btn btn-info" v-if="lbreak.length && lbreak[0].stopped_at == null" @click="backToWorkingLBreak(lbreak[0].id)">Back To Working</button>
                </div>
                </div>
                <!-- <div class="pull-right">
                    <div v-if="!ltbreak.length && !timecard[0].done_lbreak" class="pull-right" style="margin-left:10px;">
                        <button class="btn btn-success" @click="clockLastbreak(timecard[0])">Last Break</button>
                    </div>

                    <div class="pull-right" v-else>
                    <button class="btn btn-success" @click="clockLastbreak(timecard[0])" v-if="ltbreak[0].stopped_at != null && timecard[0].done_fbreak && timecard[0].done_lunch && !timecard[0].done_lbreak ">
                        Last Break
                    </button>
                    <button class="btn btn-info" v-if="ltbreak.length && ltbreak[0].stopped_at == null" @click="backToWorkingLtBreak(ltbreak[0].id)">Back To Working</button>
                </div>
                </div> -->

            </div>
            <br>
            <!-- <strong>{{ activeTimerString }}</strong> -->
            <div v-show="!timecard[0].is_working && timecard[0].work_flag ==1">
            <b>{{calculateHours(timecard)}} </b>
            <b class="text-danger">Undertime</b>
            </div>
        </div>
        <modal>
            <form @submit.prevent = "clockOthers()">
             
                <input type="text" name="name" class="form-control" placeholder="Enter description" v-model="form.description">
                <br>
                <button class="btn btn-success btn-sm">Create</button>
                <br>
            </form>
        </modal>
    </div>
</template>
<script type="text/javascript">
import moment from 'moment'
import Modal from './Reusable/ModalSmall.vue'
    export default{
        components:{
            Modal
        },
        data(){
            
            return{
                timecard:[],
                activeTimerString: 'Calculating...',
                counter: { seconds: 0, timer: null },
                other:[],
                fbreak:[],
                lbreak:[],
                ltbreak:[],
                isWorking:false,
                form:new Form({
                    id:'',
                    timecard_id:'',
                    description:''
                })
            }
        },
        mounted(){
            this.getTimecard();
            this.createdClocks();
            this.createdCoaching();
            this.createdFirstBreak();
            this.createdLunchBreak();
            this.createdLastBreak();
            this.getLastbreak();
            this.getOthers();
            this.getLunchbreak();
            this.getFirstBreak();
            
        },
        methods:{

        _padNumber: number =>  (number > 9 || number === 0) ? number : "0" + number,
        /**
         * Splits seconds into hours, minutes, and seconds.
         */
        _readableTimeFromSeconds: function(seconds) {
            const hours = 3600 > seconds ? 0 : parseInt(seconds / 3600, 10)
            return {
                hours: this._padNumber(hours),
                seconds: this._padNumber(seconds % 60),
                minutes: this._padNumber(parseInt(seconds / 60, 10) % 60),
            }
        },
            getTimecard(){
                axios.get('/timecard').then((response) => {
                    this.timecard = response.data
                })
            },
            startTimer(timecard){
                if(timecard[0].time_in){
                    let vm = this
                    let started = moment(timecard[0].time_in);
                    vm.counter.seconds = parseInt(moment.duration(moment().diff(started)).asSeconds())
                    vm.counter.ticker = setInterval(() => {
                        const time = vm._readableTimeFromSeconds(++vm.counter.seconds)
                        vm.activeTimerString = `${time.hours} Hours | ${time.minutes}:${time.seconds}`
                    }, 1000)
                }
            },
            getLunchbreak(){
                axios.get('/lunchbreak').then((response) => {
                    this.lbreak = response.data
                })
            },
             getLastbreak(){
                axios.get('/lastbreak').then((response) => {
                    this.ltbreak = response.data
                })
            },
            getFirstBreak(){
                axios.get('/firstbreak').then((response) => {
                    this.fbreak = response.data
                })
            },
            calculateHours(timecard){
                if(timecard[0].time_out){
                    const started = moment(timecard[0].time_in)
                    const stopped = moment(timecard[0].time_out)
                    const time = this._readableTimeFromSeconds(
                    parseInt(moment.duration(stopped.diff(started)).asSeconds())
                )
                return `${time.hours} Hours | ${time.minutes} mins | ${time.seconds} seconds`
                }
                return ''
            },
            backToWorking(id){
                swal.fire({
                    title: 'Back to Work',
                    text: "Press the Yes Button To Back to Work",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
                    confirmButtonText: 'Yes'
                    
                }).then((result) => {
                    if(result.value){
                        axios.put('/others/'+id).then(() => {
                            this.isWorking = true;
                            toast.fire({
                                icon:'success',
                                title:'You are back to Work'
                            })
                            Fire.$emit('createdClocks');
                            Fire.$emit('createdCoaching')
                            this.form.reset();
                        })
                    }
                })
            },
            backToWorkingBreak(id){
                swal.fire({
                    title: 'Back to Work',
                    text: "Press the Yes Button To Back to Work",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if(result.value){
                        axios.put('/firstbreak/'+id).then(() => {
                            toast.fire({
                                icon:'success',
                                title:'You are back to work !'
                            })
                            Fire.$emit('createdFirstBreak')
                            Fire.$emit('createdClocks')
                        })
                    }
                })
            },
            backToWorkingLBreak(id){
                swal.fire({
                    title: 'Back to Work',
                    text: "Press the Yes Button To Back to Work",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if(result.value){
                        axios.put('/lunchbreak/'+id).then(() => {
                            toast.fire({
                                icon:'success',
                                title:'You are back to work !'
                            })
                            Fire.$emit('createdLunchBreak')
                            Fire.$emit('createdClocks')
                        })
                    }
                })
            },
            backToWorkingLtBreak(id){
                swal.fire({
                    title: 'Back to Work',
                    text: "Press the Yes Button To Back to Work",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if(result.value){
                        axios.put('/lastbreak/'+id).then(() => {
                            toast.fire({
                                icon:'success',
                                title:'You are back to work !'
                            })
                            Fire.$emit('createdLastBreak')
                            Fire.$emit('createdClocks')
                        })
                    }
                })
            },
            clockFirstbreak(firstbreak){
                this.form.timecard_id = firstbreak.id 
               swal.fire({
                    title: 'First Break',
                    text: "Press the Yes Button To First Break",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if(result.value){
                        this.form.post('/firstbreak',{
                            params:{
                                timecard_id:this.form.timecard_id
                            }
                        }).then(() => {
                            toast.fire({
                                icon:'success',
                                title:'First Break Successfully Created'
                            })
                            Fire.$emit('createdFirstBreak')
                            Fire.$emit('createdClocks')
                        })
                    }
                });
            },
            clockLunchbreak(lunchbreak){
                this.form.timecard_id = lunchbreak.id 
               swal.fire({
                    title: 'Lunch Break',
                    text: "Press the Yes Button To Lunch Break",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if(result.value){
                        this.form.post('/lunchbreak',{
                            params:{
                                timecard_id:this.form.timecard_id
                            }
                        }).then(() => {
                            toast.fire({
                                icon:'success',
                                title:'Lunch Break Successfully Created'
                            })
                            Fire.$emit('createdLunchBreak')
                            Fire.$emit('createdClocks')
                        })
                    }
                });
            },
            clockLastbreak(lastbreak){
                this.form.timecard_id = lastbreak.id 
               swal.fire({
                    title: 'Last Break',
                    text: "Press the Yes Button To First Break",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if(result.value){
                        this.form.post('/lastbreak',{
                            params:{
                                timecard_id:this.form.timecard_id
                            }
                        }).then(() => {
                            toast.fire({
                                icon:'success',
                                title:'Lunch Break Successfully Created'
                            })
                            Fire.$emit('createdLastBreak')
                            Fire.$emit('createdClocks')
                        })
                    }
                });
            },
            clockOthers(){
                this.form.post('/others',{
                    params:{
                        timecard_id: this.form.timecard_id
                    }
                }).then((response) => {
                    $('#addNew').modal('hide')
                    this.isWorking = false
                    toast.fire({
                        icon:'success',
                        title:'Activity Successfully Created'
                    })
                    Fire.$emit('createdClocks');
                    Fire.$emit('createdCoaching')
                    this.form.reset()     
                    window.location.reload()               
                });
            },
            getOthers(){
                axios.get('/others').then((response) => {
                    this.other = response.data
                });
            },
            clockin(){
                // swal.fire({
                //     title: 'Clock In',
                //     text: "Press the Yes Button To Clock In",
                //      type: 'input',                   
                //     showCancelButton: true,
                //     confirmButtonColor: '#3085d6',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'Yes'
                // }).then((result)=> {
                //     if(result.value){
                //         axios.post('/timecard').then((response)=> {
                //             this.isWorking = true;
                //             toast.fire({
                //                 icon:'success',
                //                 title:'Clock In Submitted'
                //             })
                //             Fire.$emit('createdClocks')
                //             this.startTimer(response.data)
                //         })
                //     }
                // })
                const { value: reason } =  swal.fire({
                title: 'Optional if you are late',
                input: 'text',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                inputPlaceholder: 'Type your reason here why you late'
                }).then((reason)=> {
                  if(reason){
                        axios.post('/timecard',{reason:reason.value}).then((response)=> {
                        this.isWorking = true;
                        toast.fire({
                            icon:'success',
                            title:'Clock In Submitted'
                        })
                        Fire.$emit('createdClocks')
                        this.startTimer(response.data)
                    })
                  }
                })


            },
            createOthers(others){
                $('#addNew').modal('show')
                this.form.timecard_id = others.id
                
            },
            clockout(id){
                swal.fire({
                    title: 'Clock Out',
                    text: "Press the Yes Button To Clock Out",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
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
                this.getTimecard();
                Fire.$on('createdClocks',()=> {
                    this.getTimecard()
                })
            },
            createdCoaching(){
                this.getOthers();
                Fire.$on('createdCoaching',()=> {
                    this.getOthers()
                })
            },
            createdFirstBreak(){
                this.getFirstBreak();
                Fire.$on('createdFirstBreak',() => {
                    this.getFirstBreak()
                })
            },
             createdLunchBreak(){
                this.getLunchbreak();
                Fire.$on('createdLunchBreak',() => {
                    this.getLunchbreak()
                })
            },
            createdLastBreak(){
                this.getLastbreak();
                Fire.$on('createdLastBreak',() => {
                    this.getLastbreak()
                })
            }

        }
    };
</script>