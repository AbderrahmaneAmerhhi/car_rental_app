<template>

    <!-- Modal -->
    <div class="modal fade " id="authmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

         <div class="modal-body">
             <button type="button" class="btn-close" id="closeauthmodal" data-bs-dismiss="modal" aria-label="Close"></button>
            <!-- login form  -->
          <div class="login-container" v-if="loginform == true">
             <h1 class="mb-3">Connection </h1>
             <div class="input_box mb-3">
                <label for="email" >Email</label>
                <input type="email" required id="email" v-model="user.email" placeholder="Entre youre email ">
             </div>
             <div class="input_box mb-3">
                <label for="pass1" >Password</label>
                <input type="password" required id="pass1"  v-model="user.password" placeholder="Entre your password">
             </div>
             <div class="footer_box mb-3">
                <button class="mb-2" @click="login">Login</button>
                <span class="small-link" @click="showregister">I don't have an account, register</span>
             </div>
          </div>
             <!-- register form  -->
          <div class="register-container" v-else>
             <h1 class="mb-3">Create an account </h1>
             <div class="input_box mb-3">
                <label for="name" >UserName</label>
                <input type="text" required id="name"  v-model="user.name" placeholder="Entre youre name ">
             </div>
             <div class="input_box mb-3">
                <label for="email" >Email</label>
                <input type="email" required id="email"  v-model="user.email" placeholder="Entre youre email ">
             </div>
             <div class="input_box mb-3">
                <label for="pass" >Password</label>
                <input type="password"  required v-model="user.password" id="pass" placeholder="Entre  password">
             </div>
             <div class="input_box mb-3">
                <label for="pass2"  >R-Password</label>
                <input type="password" required  v-model="user.password_confirmation" id="pass2" placeholder="Re-enter  password">
             </div>
             <div class="footer_box mb-3">
                <button  class="mb-2" @click="register">Register</button>
                <span class="small-link" @click="showlogin">I have an account, login</span>
             </div>
          </div>
        </div>

        </div>
    </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'
import { mapState } from 'vuex';
import User from '../../../helpers/User';
export default{
     mounted() {

     },
    methods: {
       showregister(){
        this.loginform = false
        this.user={}
       },
       showlogin(){
         this.loginform= true
         this.user={}
       },
       register(){
            this.user.url= '/api/register',
           this.$store.dispatch('register',this.user)
            this.user={}
       },
       login(){
         axios.post('/api/login',this.user)
                  .then(res => {
                     this.user={}
                    User.storeUser(res.data)

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title:res.data.message,
                        showConfirmButton: true,
                        timer: 1500
                      })
                      // close modal
                      document.getElementById('closeauthmodal').click();
                        this.$router.go();

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
       }
    },
    components: {
    },
    data() {

        return {
            user:{
                name:'',
                email:'',
                password:'',
                password_confirmation:'',
            },
            loginform:true,
        }
    },

    computed:{
         ...mapState({
            authuser : state => state.user,
         })
    }


}
</script>

<style>

/*========== VARIABLES CSS ==========*/
:root {
  --header-height: 3.5rem;
  --nav-width: 219px;
 /**========== darkmode =======*/
 --dark-pr-color:#000000;
 --dark-sc-color: #2B2B2B;
 --dark-tr-color:#080218;
 --dark-fr-color:#3F0071;
 --dark-fv-color:#610094;

 --text-seconde-color-dark: #E3E3E3;
 --text-color-dark:#F1F1F1;
 --text-seconde-color-dark: #E3E3E3;
  /*========== Colors ==========*/
  --my-pr-color:  #232D65;
  --my-sc-color: #929DD9;
  --my-tr-color: #A8B0E0;
  --first-color:   #f4f5f7d3;
  --first-color-light: #fefefe;
  --title-color: #19181B;
  --text-color:   #a9aec0d3;
  --text-color-light:   #bec4d4d3;
  --body-color: #F9F6FD;
  --container-color: #FFFFFF;

  /*========== Font and typography ==========*/
  --body-font: 'Poppins', sans-serif;
  --normal-font-size: .938rem;
  --small-font-size: .75rem;
  --smaller-font-size: .75rem;

  /*========== Font weight ==========*/
  --font-medium: 500;
  --font-semi-bold: 600;

  /*========== z index ==========*/
  --z-fixed: 100;
}

/*** dark mode start ***/
body.dark-theme .modal-content{
background: var(--dark-pr-color);
}
body.dark-theme  .input_box input{
    background: #fff;

}
body.dark-theme .footer_box .small-link:hover,body.dark-theme .footer_box .small-link:active{
  color:var(--text-seconde-color-dark)
}
/*** dark mode end ***/
.modal-content{
     padding: 20px !important;
    border-radius: 10px;
}
.modal-body>.btn-close{
 position: absolute;
 right: 10px !important;
 color: #2B2B2B;
}
.login-container,.register-container{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.input_box{
    width: 90%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-direction: row;
    column-gap: 2rem;
}
.input_box input{
 border: none;
 outline: none;
 border-radius: .40rem;
 padding: 7px;
 background:#f5f5f5d3;
}
.footer_box{
    display: flex;
    flex-direction: column;
}
.footer_box button{
    border: none;
    outline: none;
    background: var(--my-pr-color);
    color: #ffffff;
    width: 100%;
    padding: 7px;
    border-radius: .50rem;
    justify-self: center;
}
.footer_box button:hover{
    background: var(--my-sc-color);
}
.footer_box .small-link{
  font-size: var(--smaller-font-size);
  cursor: pointer;
}
.footer_box .small-link:hover,.footer_box .small-link:active{
  color: var(--my-pr-color);
}
@media screen and (max-width: 320px) {


}
/* For medium devices and small */
@media screen and (max-width: 767px) {
.cars-container{
    grid-template-columns: repeat(1,1fr);
 }
 .input_box{
    width: 100%;
    flex-direction: column;
    align-items:flex-start;
}
.input_box input{
 width: 100%;
}
}
/* For medium devices */
@media screen and (min-width: 576px) {

}

@media screen and (min-width: 767px) {

}
/* form large screen */

@media screen and (max-width:968px) {


}

/* For large devices */
@media screen and (min-width: 1024px) {

}
</style>
