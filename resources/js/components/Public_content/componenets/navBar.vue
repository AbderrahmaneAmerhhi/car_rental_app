<template>
    <div class="navbar">

       <Header class="header" id="header">
          <nav class="nav">
              <router-link v-if="logged != false" to="/"  class="nav_logo">
                <i  class='bx bx-user' ></i>
                <span  class="nav__logo-name">{{username}}</span>
               </router-link>
               <router-link v-else to="/"  class="nav_logo">
                <i  class='bx bxs-car ' ></i>
                <span   class="nav__logo-name">WeekCar</span>
               </router-link>

          <div class="nav_menu"  id="nav-menu">
           <ul class="nav_list">
                      <a href="#home" @click="Addactivelinkclass(0)" class="nav__link active-link">
                <i class='bx bx-home'></i>
                <span class="nav__name">
                    Home
                </span>
            </a>
            <a href="#steps" @click="Addactivelinkclass(1)" class="nav__link">
                <i class='bx bxs-carousel' ></i>
                <span class="nav__name">
                    Steps
                </span>
            </a>
            <a href="#cars" @click="Addactivelinkclass(2)" class="nav__link">
                <i class='bx bxs-car-garage' ></i>
                <span class="nav__name">
                    Cars
                </span>
            </a>



            <a href="#contact" @click="Addactivelinkclass(3)" class="nav__link">
                <i class='bx bx-envelope' ></i>
                <span class="nav__name">
                   Contact
                </span>
            </a>

             <a v-if="logged != false" href="#" @click="Addactivelinkclass(4)" class="nav__link"  >
                <i class='bx bx-log-out-circle'></i>
                <span class="nav__name">
                    logout
                </span>
            </a>
            <a v-else href="#" @click="Addactivelinkclass(4)" class="nav__link"  data-bs-toggle="modal" data-bs-target="#authmodal">
                <i class='bx bxs-group' ></i>
                <span class="nav__name">
                    Join us
                </span>
            </a>

                 <svg class="indicator" width="94" height="56" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="47" cy="28" rx="24" ry="28"/>
                    <path d="M24 20C24 20 28 55.9999 48 56L0 55.9997C18 55.9998 24 20 24 20Z"/>
                    <path d="M70 20C70 20 66 55.9999 46 56L94 55.9997C76 55.9998 70 20 70 20Z"/>
                </svg>
           </ul>


              </div>


               <!-- theam butto -->
               <i class="bx bx-moon change-theme-nav-button " @click="changeTheme" ></i>
               <!-- <img src="images/profileoimage.jpg" alt="" class="nav_img"> -->
          </nav>
       </Header>


    </div>
</template>

<script>
import User from '../../../helpers/User';




export default {
  props:{
    //   componenets:objectToString,
      },


  mounted () {
  },
  data () {
    return {

          links:document.getElementsByClassName('nav__link'),
          logged:User.isLogged(),
          // username
          username:User.isLogged().name,

  }
  },
//   emits:['sendComponentName'],
  methods: {

      logout(){
         User.logout();
      },
      Addactivelinkclass(i){

        const activelink = this.links[i];
        activelink.classList.toggle('active-link');
        for(var a=0;a<this.links.length;a++){
            if(a !== i){
               this.links[a].classList.remove('active-link');
            }
        }
        if(i== 4 && this.logged != false){
            this.$store.dispatch('logout');
             this.logged = false;
             this.$router.go();
        }
      },

       changeTheme(){
            const changeThemButton = document.querySelector('.change-theme-nav-button');
            const body =document.body;
            if(body.classList.length > 0){
                body.classList.remove('dark-theme')
                changeThemButton.classList.remove('ri-sun-line');
                changeThemButton.classList.add('ri-moon-line');
            }else{
                body.classList.add('dark-theme')
                changeThemButton.classList.remove('ri-moon-line');
                changeThemButton.classList.add('ri-sun-line');
            }
        },

  },
    name:'navBar',
}



</script>

<style>
</style>
