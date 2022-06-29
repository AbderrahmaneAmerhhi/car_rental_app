import Vue from "vue";
import Vuex from 'vuex';
import axios from 'axios'
import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'
// moment js for conver date
import moment from 'moment';
import User from "../helpers/User";

Vue.use(Vuex);

const store = new Vuex.Store({

    state:{
        AllData:{},
        rows:{},
        rowofData:[],
        stateData:[],


    },
    mutations:{
        // get data  from db mutation
       async fetchData(state,url){
             const   token = User.isLogged().token
            const config = {
                headers: {
                  accept: 'application/json',
                  'Authorization': `Bearer ${token}`
                //   'cache-control': 'no-cache',
                //   'content-type':'multipart/form-data'
             }
            }
            await  axios.get(url,config)
                  .then(res =>{
                          // stat data if exist for cards
                          if(res.data.statsData){
                            state.stateData=res.data.statsData;

                          }
                         // rows data for table
                        state.rows= res.data.data.data;
                         console.log(state.rows)
                         // all data for pagination data
                         state.AllData=res.data.data;

                         // change date forma for using it in vue good table
                         state.rows.forEach(l => {
                         l.created_at = moment(String(l.created_at)).local().format('yyyy-MM-DD');
                         l.updated_at = moment(String(l.updated_at)).local().format('yyyy-MM-DD');
                         if(l.deleted_at){
                            l.deleted_at = moment(String(l.deleted_at)).local().format('yyyy-MM-DD');
                         }else if(l.dateL && l.dateR){
                            l.dateL = moment(String(l.dateL)).local().format('yyyy-MM-DD');
                            l.dateR = moment(String(l.dateR)).local().format('yyyy-MM-DD');
                         }

                      })

                  })
                  .catch(err => console.log(err))
        },

        // store Data Mutation
        storeData(state,params){
            const   token = User.getUser().token
            const config = {
                headers: {
                  accept: 'application/json',
                  'Authorization': `Bearer ${token}`
             }
            }
            state.rowofData  = params;

            let formData = new FormData();
            // send data
            formData.append('data', JSON.stringify(state.rowofData))
            if(state.rowofData.file){
                formData.append('file',state.rowofData.file);
            }
            axios.post(params.url,formData,config)
                  .then(res => {


                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title:res.data.message,
                        showConfirmButton: true,
                        timer: 1500
                      })
                      // close modal
                      document.getElementById('closemodal').click();

                  })
                  .catch(err =>{
                     //   show first error message in alert
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title:err.response.data.message,
                        showConfirmButton: true,
                        timer: 1500
                        })


                  })
        },
        // removeData mutation
          removeData(state,params){
            const   token = User.getUser().token
            const config = {
                headers: {
                  accept: 'application/json',
                  'Authorization': `Bearer ${token}`
             }
            }
            Swal.fire({
                title: 'Are you sure?',
                text: "Confirm the deletion",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(params.url,config)
                    .then(res => {
                      Swal.fire({
                          position: 'center',
                          icon: 'success',
                          title:res.data.message,
                          showConfirmButton: true,
                          timer: 1500
                        })
                        state.rows= state.rows.filter((ele) => ele.id !== params.id)
                    })
                    .catch(err => console.log(err.response.data.errors) )
                }
              })

          },

        // active archived row
        activeRow(state,params){
            const   token = User.getUser().token
            const config = {
                headers: {
                  accept: 'application/json',
                  'Authorization': `Bearer ${token}`
             }
            }
            Swal.fire({
                title: 'Are you sure?',
                text: "Confirm the Activation",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Active it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(params.url,config)
                    .then(res => {
                      Swal.fire({
                          position: 'center',
                          icon: 'success',
                          title:res.data.message,
                          showConfirmButton: true,
                          timer: 1500
                        })
                        state.rows= state.rows.filter((ele) => ele.id !== params.id)
                    })
                    .catch(err => console.log(err.response.data.errors) )
                }
              })

          },
          // get data by id for showing or editing data
          fetchDataById(state,url){
            const   token = User.getUser().token
            const config = {
                headers: {
                  accept: 'application/json',
                  'Authorization': `Bearer ${token}`
             }
            }
            axios.get(url,config)
            .then(res => {
                state.rowofData = res.data.data;

            })
            .catch(err => console.log(err.response.data.errors) )
          },

          // edit data mutation
        editData(state,params){
            const   token = User.getUser().token
            const config = {
                headers: {
                  accept: 'application/json',
                  'Authorization': `Bearer ${token}`
             }
            }
            state.rowofData  = params;

            let formData = new FormData();
            // send data
            formData.append('data', JSON.stringify(state.rowofData))
            if(state.rowofData.file){
                formData.append('file',state.rowofData.file);
            }
            formData.append('_method','put');
            axios.post(params.url,formData,config)
                  .then(res => {
                      console.log(res.image);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title:res.data.message,
                        showConfirmButton: true,
                        timer: 2000
                      })
                  })
                  .catch(err =>{
                    //   show first error message in alert
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title:err.response.data.message,
                        showConfirmButton: true,
                        timer: 1500
                        })

                  })
        },


        // authUser (for register)
        authUser(state,params){
            const config = {
                headers: {
                  accept: 'application/json',
               }
            }
            state.rowofData  = params;
            axios.post(params.url,state.rowofData,config)
                  .then(res => {
                    if(res.data.token){
                     state.user = res.data
                    }
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title:res.data.message,
                        showConfirmButton: true,
                        timer: 1500
                      })
                      // close modal
                      document.getElementById('closeauthmodal').click();

                  })
                  .catch(err =>{
                     //   show first error message in alert
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title:err.response.data.message,
                        showConfirmButton: true,
                        timer: 1500
                        })


                  })
        },
        // signout mutation
        signout(){
            // const   token = User.getUser().token
            // const config = {
            //     headers: {
            //       accept: 'application/json',
            //       'Authorization': `Bearer ${token}`
            //  }
            // }
            // axios.post('/api/logout',config)
            //       .then(res => {

            //         Swal.fire({
            //             position: 'center',
            //             icon: 'success',
            //             title:res.data.message,
            //             showConfirmButton: true,
            //             timer: 1500
            //           })

            //       })
            //       .catch(err =>{
            //          //   show first error message in alert
            //         Swal.fire({
            //             position: 'center',
            //             icon: 'error',
            //             title:err.response.data.message,
            //             showConfirmButton: true,
            //             timer: 1500
            //             })


            //       })
                  User.logout();

        }

    },

    actions:{
        // execute fetch data mutation in this action
        getData({commit},params){
            commit('fetchData',params);
        },



        // Add data Mutation for  execute store mutation
        addData({commit},params){
            commit('storeData',params);
        } ,

        // delete data action for execute the mutation remove
      deleteData({commit},params){
        commit('removeData',params);
        },
        // execute activerow mutation with this action
       activeData({commit},params){
           commit('activeRow',params);
        },
        // execute fetchdatabyid mutation by this action

        getDataById({commit},params){
            commit('fetchDataById',params);
        },

        // execute Edit Data mutation
        UpdateData(context,params){
             context.commit('editData',params);
        },

        // execute authUser mutation
        register({commit},params){
           commit('authUser',params)
        },
        // logout action
        logout({commit}){
          commit('signout')
        }
    },

    getters:{

    }

})

export default store;
