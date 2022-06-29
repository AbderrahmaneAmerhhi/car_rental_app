<template>
    <div class="container">
        <div class="auth-container">
            <div class="auth-background">
              <img src="/images/backgrounds/Login-amico.svg" alt="">
           </div>
           <div class="auth-form">
               <h1 class="mb-5">Admin Login</h1>
                <div class="input-email mb-3">
                    <label for="email" >Email</label>
                    <i class='bx bxs-user'></i>
                    <input type="email" required id="email" v-model="admin.email" placeholder="Entre youre email ">


                </div>
                <div class="input-pass mb-3">
                    <label for="pass" >Password</label>
                    <i class='bx bxs-lock-open-alt' ></i>
                    <input type="password" required id="pass"  v-model="admin.password" placeholder="Entre your password">
                </div>
                <div class=" mt-2">
                    <button class="btn  primary-btn" @click="login">Login</button>
                </div>
           </div>
        </div>

    </div>
</template>

<script>
import { emit } from 'process'
import Swal from 'sweetalert2/dist/sweetalert2.js'

import 'sweetalert2/src/sweetalert2.scss'
export default {
    mounted() {

    },
  methods: {
    login(){
         axios.post('/api/login',this.admin)
                  .then(res => {
                    this.user={}
                    User.storeUser(res.data)
                    this.$emit('logindata',res.data)

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title:res.data.message,
                        showConfirmButton: true,
                        timer: 1500
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
       }
  },
  data () {
    return {
         admin:{
            password:'',
            email:'',
         }
    }
  },
    name:'adminauth',
    components:{}
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

/*** dark mode end ***/
.auth-container{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    column-gap: 20px;
}
.auth-background{
    width: 100% !important;

}
.auth-background img{
    width: 100% !important;
    height: 100% !important;
}
.auth-form{
    width: 100%;
    padding:70px  30px;
    background:#f6f6f6;
    border-radius: 20px;
}
.input-pass,.input-email{
    display: grid;
     position: relative;

}
.input-pass input,.input-email input{
    background: transparent;
    border: none;
  outline: none;
    padding: 0 30px;
  font-size: 16px;
  font-weight: 500;
  border-bottom: 2px solid rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}
.input-pass input:active,.input-pass input:focus,.input-email input:focus,.input-email input:active{
    border-color: #232D65;
}
.input-email i,.input-pass  i{
    position: absolute;
    color:var(--dark-fr-color);
    font-size: 17px;
    top: 25px !important;
}
@media screen and (max-width: 320px) {
.input-pass input,.input-email input{
    padding: 0 10px;
    font-size: 10px;
    font-weight: 300;
}
.input-email i,.input-pass  i{
    font-size: 11px;
}
}
/* For medium devices and small */
@media screen and (max-width: 767px) {
.auth-container{

    flex-direction: column;
}
.auth-background{
   display: none;

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
