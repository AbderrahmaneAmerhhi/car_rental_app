<template>
        <div class="body-content">
             <i class="bx bx-moon fthem-btn" @click="changeTheme" ></i>
             <h2 class="mt-5 f-title"><i class='bx bxs-car bx-flip-horizontal bx-tada  nav__icon' ></i> WeekCar</h2>
             <span class="f-description mb-5"> The best car rental services in the country </span>
             <!-- start btn  -->
             <router-link class="start__button mt-5" :to="{name:'index'}"  >START</router-link>
        </div>

</template>

<script>
// animation scrollreval
import ScrollReveal from 'scrollreveal'
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

            //  change vue good table theme
            // nocturnal
            // console.log(this.$refs['my-table']);
    },
     scrollAnimation(){
        const sr = ScrollReveal({
            origin: 'top',
            distance: '260px',
            duration: 2500,
            delay: 200,
        })
        sr.reveal(`.f-title`, {delay:200})
        sr.reveal(`.f-description`, {delay:600})
        sr.reveal(`.start__button`, {delay:700,origin:'bottom',delay:250})
    }
    },
    mounted() {
        this.scrollAnimation();
    },
        name:'index',


    }
</script>

<style>

     .fthem-btn{
        cursor: pointer;
        position: absolute;
        right: 1rem;
        top: 4rem;
        font-size: 1.4rem ;

     }
    .body-content{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }
    .f-title{
    font-size:2rem;
    color: #929DD9;
    }
    .f-description{
        font-size:.75rem;
    }
    .start__button{
       margin-top: 50;
        position: relative;

        border: 2px solid hsl(213, 90%, 30%);
        width: 70px;
        height: 70px;
        border-radius: 50%;
       display: flex;
        align-items: center;
        justify-content: center;
        align-self: center;
        font-size: .75rem;
        color:#929DD9;
        font-weight: 500;

    }
    .start__button:hover{
        color:#A8B0E0;
    }
    .start__button::before{
        content: '';
       border: 2px solid hsl(213, 98%, 43%);
       width: 90px;
       height: 90px;
       border-radius: 50%;
       position: absolute;

       box-shadow: 0 0 12px hsl(213, 98%, 43%);
       transition: .3s;
       animation: button 3s infinite;

    }

    /* button animation  */
    @keyframes button{
        0%{
             box-shadow: 0 0 12px hsl(211, 98%, 43%);
        }
        50%{
             box-shadow: 0 0 26px hsl(211, 98%, 43%);
        }
    }
</style>
