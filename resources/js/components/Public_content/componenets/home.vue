<template>
    <div class="home_section">
         <div class="home_desc">
              <h1 class="desc_title mt-3">WeekCar Find Your Dream Car</h1>
              <p class="desc mt-3">
                Our company works in providing tourist car rental services. <br/>
                We offer the best sports and classic cars that suit our valued customers
              </p>
              <div class="desc_social  mt-3">
                <a href="https://www.instagram.com/abderrahmane_amerrhi/" class="social_btn ig-icon"><i class='bx bxl-instagram'></i></a>
                <a href="" class="social_btn lk-icon"><i class='bx bxl-linkedin ' ></i></a>
                <a href="" class="social_btn github-icon"><i class='bx bxl-github ' ></i></a>
              </div>
         </div>
         <div class="home_backg">

             <div class="backg">
               <img src="/images/backgrounds/car_first_back.png" alt="first Car Background" />
             </div>

         </div>
         <!-- show form button  -->
         <i class='show-btn bx bxs-chevron-right'   @click="activeform"></i>
         <form  class="form bookform">

            <div class="input-box">
                <span>Pick-Up Date</span>
                  <input  type="date" v-model="BookinData.dateL">
            </div>
            <div class="input-box">
                <span>Return Date</span>
                  <input  type="date" v-model="BookinData.dateR">
            </div>

             <input type="button" class="btn mt-2 " value="submit" @click="sendBookDataToParent">

         </form>
    </div>
</template>

<script>
// animation scrollreval
import ScrollReveal from 'scrollreveal'
export default{
  methods: {
    activeform(event){
      const form = document.querySelector('.form');
      form.classList.toggle('active-form');
      console.log(form.classList.length)
      if(form.classList.length >= 3){

         event.target.classList.remove('bxs-chevron-right');
         event.target.classList.toggle('bxs-chevron-left');
          event.target.title='Hide form'

      }else{
          event.target.classList.remove('bxs-chevron-left');
         event.target.classList.toggle('bxs-chevron-right');
          event.target.title='Show form'

      }

    },
    sendBookDataToParent(){
        this.$emit('getBookData',this.BookinData)
        this.BookinData={}
    },
    scrollAnimation(){
        const sr = ScrollReveal({
            origin: 'top',
            distance: '260px',
            duration: 2500,
            delay: 200,
        })
        sr.reveal(`.home_desc`, {delay:200,origin:'left'})
        sr.reveal(`.show-btn`, {delay:600,origin:'left'})
        sr.reveal(`.bookform`, {delay:600,origin:'left'})
        sr.reveal(`.home_backg`, {delay:700,origin:'right'})
    }
    },
    mounted() {
        this.scrollAnimation();
    },
  data () {
    return {
        BookinData:{
            dateL:'',
            dateR:'',
            location:'',
        }
    }
  },
  props: {
  },

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
body.dark-theme .home_section form{
 background: var(--dark-sc-color);
}
body.dark-theme .input-box input{
  background: #202020;
  color: #F1F1F1;

}
body.dark-theme .input-box input::-webkit-input-placeholder{
    color:#bfbfbf !important;
}
body.dark-theme input[type="date"]::-webkit-calendar-picker-indicator{
   background-color: rgb(71, 71, 71) !important;
}
body.dark-theme .home_section form .btn{
    background: var(--dark-pr-color);
}
body.dark-theme .home_section form .btn:hover{
    background:#202020;
}
body.dark-theme   .home_section .home_desc  .social_btn{
    color: var(--text-seconde-color-dark);
}
body.dark-theme  .home_section .home_desc .desc{
    color: var(--text-color-dark);
}
/*** dark mode end ***/
.home_section{
    position: relative;
    display: flex;
    justify-content: space-around;
    flex-direction: row;
    width:100%;
    /* height: 100vh !important; */
    /* margin-top: 20px; */

}
.home_section  .show-btn{
   display: none;
}
.home_section form{
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
    background: #fff;
    padding: 20px;
    border-radius: 0.5rem;
    position: absolute;
    left: 0;
    bottom:1rem


}
.input-box{
    flex: 1 1 7rem;
    display: flex;
    flex-direction: column;
}
.input-box span{
    font-weight: 500;
}
.input-box input{
    padding: 7px;
    outline: none;
    border: none;
    background: #eeeff1;
    border-radius: 0.5rem;
    font-size: 1rem;
}

.home_section form .btn{
    flex: 1 1 7rem;
    padding: 10px 34px;
    border: none;
    border-radius: 0.5rem;
    background: var(--my-pr-color);
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
}
.home_section form .btn:hover{

    background: var(--my-sc-color);

}
.home_section .home_desc {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex-direction: column;
}

.home_section .home_desc .desc_title{

    font-size: 1.80rem;
    font-family:  var(--body-font);
    color: #929DD9;

}
.home_section .home_desc .desc{

    font-size:var(--small-font-size);
    font-family: var(--body-font);
    color:var(--text-color);

}

/* social btns style and animation  */
.home_section .home_desc .desc_social{
  display: flex;
  column-gap: 25px;
}
.home_section .home_desc  .social_btn{
   width: 40px;
   height: 40px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   text-decoration: none;
   font-size: 26px;
   color: rgb(79, 79, 79);
   border-radius: .25rem;
   outline: 2px solid  rgb(79, 79, 79);
   transition-property: outline-offset,outline-color-background-color;
   transition-duration: .25s;

}
.home_section .home_desc  .social_btn:hover{
    outline-offset: 4px;

}
.home_section .home_desc  .social_btn:hover i{
   animation:  shake .25s;

}
.ig-icon:hover{
  background-image: radial-gradient(circle at 50% 107%,#fdf497 0%,#fdf497 5%,#fd5949 45%,#d6249f 60%,#2654eb 90%);
   color: #fff !important;
  outline-color: #a02d76 ;
}
.lk-icon:hover{
  background-color:#0e76a8;
  color: #fff !important;
  outline-color: #095273 ;
}
.github-icon:hover{
  background-color:#7F7F7F;
    color: #fff !important;
  outline-color: #636363 ;
}
@keyframes shake{
    10%{transform:rotate(15deg)}
    20%{transform:rotate(-15deg)}
    30%{transform:rotate(15deg)}
    40%{transform:rotate(-15deg)}
}
/* home backhgroun style  */
.home_section .home_backg{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
}
.home_section .home_backg .backg{

    background: var(--my-sc-color);
    border-radius: .75rem;
}
.home_section .home_backg .backg:hover{
    background: var(--my-tr-color);
}
.home_section .home_backg .backg:hover img{
    transform: translateY(70px);
    transition: .7s;
}

@media screen and (max-width: 320px) {


}
/* For medium devices and small */
@media screen and (max-width: 767px) {

  .home_section{
    flex-direction: column;
  }
  .home_section .home_backg{
    width: 100%;
    margin-top: 30px;
  }
  .home_section .home_backg img{
    width: auto;
  }

    .home_section .home_desc .desc_title{
        font-size: 1.20rem;
    }
    .home_section .home_desc .desc{
        font-size:.68rem;
    }

    .home_section .home_desc .desc_social{
    column-gap: 20px;
    }
    .home_section .home_desc  .social_btn{
    width: 30px;
    height: 30px;
    }
}
/* For medium devices */
@media screen and (min-width: 576px) {

}

@media screen and (min-width: 767px) {

}
/* form large screen */

@media screen and (max-width:968px) {
  .home_section form {
     bottom: -20px;
     width: 100%;
     display: none;
   }
   .home_section  .show-btn{
    cursor: pointer;
    display: block;
    position: absolute;
    left: -30px;
    bottom: 5px;
    background-color:rgba(52, 94, 201, 0.75);
    backdrop-filter: blur(16px);
    color: #fff;
    padding: 0.25rem;
    border: none;
    outline: none;
    border-radius: .5rem;
    font-size: 1.15rem;
    z-index: 50;
    transition: .4s;

  }
    .home_section  .show-btn:hover{
      transform: translateX(15px);
    }
    .home_section form.active-form{
      display: block;
    }

}

/* For large devices */
@media screen and (min-width: 1024px) {

}
</style>
