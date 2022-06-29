<template>
    <div class="steps-section">
           <h1 class="b-title steps-title">Car rental steps</h1>

           <div class="step-container">
               <!-- <div class="step-content">
                  <i class='bx bxs-location-plus step-icon' ></i>
                  <h3 class="step-title mb-3">Choose A Location</h3>
                  <p class="step-desc">
                    Choose your location or the city in which you are currently located in order to complete the Booking.
                  </p>
               </div> -->
                <div class="step-content stp-1">
                  <i class='bx bx-calendar step-icon' ></i>
                  <h3 class="step-title mb-3">Pick-Up Date</h3>
                  <p class="step-desc">
                     Select the date you want in the car. If not booked on this date.You must also choose the timing of returning the car.
                  </p>
               </div>
               <div class="step-content stp-2">
                  <i class='bx bx-calendar step-icon' ></i>
                  <h3 class="step-title mb-3">Return Date</h3>
                  <p class="step-desc">
                     Select the date Choose when you will return the car.
                  </p>
               </div>
               <div class="step-content stp-3">
                   <i class='bx bx-calendar-star  step-icon' ></i>
                  <h3 class="step-title mb-3">Book A Car</h3>
                  <p class="step-desc">
                     Book  the car you want,If the car you want is already booked,
                     you can wait for your return or you can book another car.
                  </p>
               </div>
           </div>

    </div>
</template>

<script>
// animation scrollreval
import ScrollReveal from 'scrollreveal'
export default{
  methods: {

    scrollAnimation(){
        const sr = ScrollReveal({
            origin: 'top',
            distance: '260px',
            duration: 2500,
            delay: 200,
        })
        sr.reveal(`.steps-title`, {delay:800,origin:'top'})
        sr.reveal(`.stp-1`, {delay:900,origin:'top'})
        sr.reveal(`.stp-2`, {delay:950,origin:'top'})
        sr.reveal(`.stp-3`, {delay:1000,origin:'top'})
    }
    },
    mounted() {
        this.scrollAnimation();
    },

  data () {
    return {
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
body.dark-theme .step-content .step-icon{
 background: var(--dark-sc-color);
 color: var(--text-seconde-color-dark);
}
body.dark-theme .step-content .step-icon:hover{
 background: #2B2B2B;
 color: var(--text-color-dark);
}
body.dark-theme  .step-container .step-content .step-title{
  color: var(--text-seconde-color-dark);
}
body.dark-theme  .step-container .step-content .step-desc{
    color: var(--text-color-dark);
}

/*** dark mode end ***/

.step-container{
    display: grid;
    grid-template-columns: repeat(3,1fr);
    grid-gap: 20px;
}
.step-container .step-content{
   display: flex;
   justify-content: center;
   align-items: center;
   flex-direction: column;
   padding: 20px;
}
.step-container .step-content .step-icon{
    font-size: 2rem;
    margin-bottom: 10px;
    background: var(--my-tr-color);
    width: 50px;
    height: 50px;
    border-radius: .25rem;
    color: var(--my-pr-color);
    display: flex;
    justify-content: center;
    align-items: center;
}
.step-container .step-content .step-icon:hover{
    background: var(--my-sc-color);
}
.step-container .step-content .step-title{
  color: #2B2B2B;
  text-align: center;
}
.step-container .step-content .step-desc{
    font-size: var(--small-font-size);
    color: #212121;
    text-align: center;
    text-transform: capitalize;
}
@media screen and (max-width: 320px) {


}
/* For medium devices and small */
@media screen and (max-width: 767px) {
.step-container{
    grid-template-columns: repeat(1,1fr);
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
