<template>
  <!--========== HEADER ==========-->
    <div>
        <header class="header">
            <div class="header__container">
                <img :src="userimg" alt="" class="header__img" data-bs-toggle="modal" data-bs-target="#editusermodal">

                <a href="#" class="header__logo" v-if="logged != false">{{username}}</a>
                <a href="#" class="header__logo" v-else>WeekCar</a>

                <!-- <div class="header__search">
                    <input type="search" placeholder="Search" class="header__input">
                      <i class='bx bx-search header__icon'></i>
                </div> -->

                <div class="header__toggle">
                    <i class='bx bx-menu' id="header-toggle"  @click="showMenu"></i>
                </div>
            </div>

        </header>
        <edituser />
    </div>





</template>

<script>

// import edit user componenet
import edituser from './edituser.vue';
import 'boxicons'

export default {
  components:{edituser},
  data () {
    return {
         username:User.isLogged().name,
         userimg:User.isLogged().image,
          logged:User.isLogged(),
        isAdmin:User.isAdmin(),
    }
  },
    name:'navBar',
    methods: {
    showMenu(event){
        document.querySelector('.nav').classList.toggle('show_nav');
        // console.log(event.target.classList)
        event.target.classList.toggle('bx-x');

    }
  },
}
</script>


<style>
.header__img{
    cursor: pointer;
}
</style>
