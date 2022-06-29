<template>
        <div >
            <navBar />

            <!-- ========================= Main ====================================== -->
<main class="container">
    <section id="home">
       <home @getBookData="getBookingData" />
    </section>

    <section id="steps">
        <steps />
    </section>

    <section id="cars">
        <cars @getCarData="Book" />
    </section>

    <section id="contact">
       <contact />
    </section>

    <section id="footer">
       <footercmp />
    </section>
</main>

       <!-- auth componenet  -->
         <auth />
        </div>

</template>

<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
// import navbar componenet
import navBar from './componenets/navBar.vue';
import home from './componenets/home.vue';
import steps from './componenets/steps.vue';
import cars from './componenets/cars'
import auth from './componenets/auth.vue';
import contact from './componenets/contact.vue';
import footercmp from './componenets/footercmp.vue';



export default {

  data () {
    return {
        BookingData : {
        }
    }
  },
    components:{navBar,home,steps,cars,auth,contact,footercmp},
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

     // get booking data from home componenet
     getBookingData(data){
            //  dateL:'',
            // dateR:'',
            // location:'',
        this.BookingData = data;
        if(this.BookingData.dateL && this.BookingData.dateR ){
            if(this.BookingData.dateL >= this.BookingData.dateR){
                Swal.fire({
                position: 'center',
                icon: 'error',
                title:  'Pick-Up Date should be bigger than return date',
                timer: 1500
                })
            }else{
                Swal.fire({
                position: 'center',
                icon: 'success',
                title:  'Chose a car now',
                timer: 1500
                })
            }

        }else{
            Swal.fire({
            position: 'center',
            icon: 'error',
            title:  'Please enter all data before booking !',
            showConfirmButton: true,
            timer: 1500
            })
        }


     },
    //book car
     Book(data){
        if(this.BookingData.dateL && this.BookingData.dateR){
          this.BookingData.car_id = data.id;
          this.BookingData.PrixTTC = data.price;
          this.BookingData.url ='/api/command';
          console.log(this.BookingData)
          this.$store.dispatch('addData',this.BookingData);
          this.BookingData = {}
        }else{
            Swal.fire({
            position: 'center',
            icon: 'error',
            title:  'Please enter all data before booking !',
            showConfirmButton: true,
            timer: 1500
            })
        }

     },

    },
    mounted() {
    },
        name:'index',


    }
</script>

<style>

    .container section{
    /* height: 100vh; */
    padding: 2rem 0;

}
</style>
