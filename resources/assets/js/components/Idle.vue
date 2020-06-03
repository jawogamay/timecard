<template>
    <div>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> User </th>
                    <th>Idle Time </th>
                </tr>
            </thead>
            <tbody>
                 <tr v-for="idle in idles">
                    <td>{{idle.id}} </td> 
                    <td>{{idle.user.name}}</td>
                    <td> {{idle.created_at |dateWithTime}} </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script type="text/javascript">
    export default{
        data(){
            return{
                idles:[],
            }
        },
        mounted(){
            this.getIdleData()
        },
        methods:{
            getIdleData(){
                axios.get('/idle').then(({data}) => this.idles = data)
            }
        }
    };
</script>