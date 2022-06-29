<template>

   <!--========== NAV ==========-->
   <div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="#" class="nav__link nav__logo">
                 <i class='bx bxs-car bx-flip-horizontal bx-tada  nav__icon' ></i>
                <span class="nav__logo-name">WeekCar</span>
            </a>

            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">Manage</h3>

                    <router-link :to="{name:'dahshome'}" class="nav__link active">
                        <i class='bx bx-home nav__icon' ></i>
                        <span class="nav__name">Home</span>
                    </router-link>


                    <a href="/index" class="nav__link">
                        <i class='bx bx-show-alt nav__icon'></i>
                        <span class="nav__name">Visit Site</span>
                    </a>
                        <router-link :to="{name : 'Companies'}"  class="nav__link">
                            <i class='bx bxs-category bx-rotate-90 mr-1' style="margin-right: 10px !important" ></i>
                            <span class="nav__name" >Companies</span>
                        </router-link>
                          <router-link :to="{name : 'Cars'}"  class="nav__link">
                            <i class='bx  bx-car  mr-1' style="margin-right: 10px !important" ></i>
                            <span class="nav__name" >Cars</span>
                        </router-link>
                         <router-link :to="{name : 'Commands'}"  class="nav__link">
                            <i class='bx  bx-command  mr-1' style="margin-right: 10px !important" ></i>
                            <span class="nav__name" >Commands</span>
                        </router-link>

                     <!-- <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                            <i class='bx bx-car' style="margin-right: 10px !important" ></i>
                            <span class="nav__name">Cars</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="#" class="nav__dropdown-item"> <i class='bx bx-list-ol bx-tada' ></i> All Cras</a>
                                <a href="#" class="nav__dropdown-item"> <i class='bx bx-plus bx-tada' ></i> Add</a>
                                <a href="#" class="nav__dropdown-item"> <i class='bx bxs-edit bx-tada' ></i> Edit</a>

                            </div>
                        </div>
                    </div> -->


                </div>

            </div>
        </div>

         <div class="Bottom-link">
            <a href="#" @click="changeTheme" class="nav__link nav__change_Them mb-3">
                <i class='bx bx-moon nav__icon the-icon' ></i>
            </a>
            <a href="#" class="nav__link " @click="logout">
                <i class='bx bx-log-out nav__icon' ></i>
                <span class="nav__name">Log Out</span>
            </a>
         </div>

    </nav>
</div>

</template>

<script>
import 'boxicons'

export default {

  methods: {

    // change them methode
    changeTheme(){
      const changeThemButton = document.querySelector('.the-icon');
            const body =document.body;
            if(body.classList.length > 0){
                body.classList.remove('dark-theme')
                changeThemButton.classList.remove('bx-sun');
                changeThemButton.classList.add('bx-moon');
            }else{
                body.classList.add('dark-theme')
                changeThemButton.classList.remove('bx-moon');
                changeThemButton.classList.add('bx-sun');
            }


    },
    // logout
    logout(){
        this.$store.dispatch('logout');
         this.logged = false;
         this.$router.go();
    }
  },
    name:'sideBar',
  data () {
    return {

    }
  },


  mounted() {
  },

}
</script>


<style>

</style>
