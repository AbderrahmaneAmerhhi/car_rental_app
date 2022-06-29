<template>
    <div class="cars-section">
        <!-- get cars by  mf company  -->

        <!-- <swiper
            :slides-per-view="3"
            :space-between="50"
              class="mb-3"
               @swiper="getCompanies">
        <swiper-slide   v-for="(item, index) in Companies" :key="index" >
           <a @click="getCarsByCMP(item.id)" style="cursor: pointer" title="Get cars by mf company">
                <img :src="item.logo" alt="Company logo">
                <span class="mf-c-title">
                {{item.title}}
                </span>
            </a>
        </swiper-slide >

        </swiper> -->
        <div class="swiper mySwiper mb-3">
            <div class="swiper-wrapper">
                     <div class="swiper-slide"  v-for="(item, index) in Companies" :key="index" >
                        <a @click="getCarsByCMP(item.id)" style="cursor: pointer" title="Get cars by mf company">
                        <img :src="item.logo" alt="Company logo">
                        <span class="mf-c-title">
                        {{item.title}}
                        </span>
                        </a>

                     </div>

            </div>
            </div>

         <h1 class="b-title ">Our Cars</h1>
         <div class="cars-container " v-if="Cars.length >0 ">
             <div class="car-content " v-for="(item, index) in Cars" :key="index">
                  <img :src="item.image" alt="first Car Background" class="car_img" />
                  <div class="car-data">
                     <span class="car-type"> <i class='bx bxs-gas-pump' ></i> {{item.type}} </span>
                     <span class="car-mf-company">{{item.company.title}}</span>
                     <span class="car-brande">{{item.Brande}}</span>
                     <span class="car-j-prix "><span class="prix">{{item.prixJ}} DH</span>  /day</span>

                     <button class="btn" @click="sendDataToparent(item)" v-if="logged != false"> Book car</button>
                     <button class="btn" v-else  data-bs-toggle="modal" data-bs-target="#authmodal"> Book car</button>
                  </div>
             </div>
         </div>
         <div class="cars-container " v-else>
                 <span>no car to show</span>
         </div>
         <!-- pagination componnent  -->
         <div class="pagination-section">
                 <pagination  :data="AllData" class="pag" @pagination-change-page="getCars" ></pagination >
         </div>
    </div>
</template>

<script>
// import {Swiper,SwiperSlide } from 'vue2-swiper'
// import Swiper from 'vue-swiper2'

//  import { Swiper, SwiperSlide } from '@mscalessio/vue2-swiper';
// import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'

// import laravel-vue-pagination pagination componenet
import pagination from 'laravel-vue-pagination';
import { mapState } from 'vuex';
export default{
//   created () {

//      this.getCompanies();
//   },
     mounted() {
        this.getCompanies();
        this.getCars();
     },
    methods: {
       //   get cars
      getCars(page){

           if(typeof page ===  'undefined'){
                page = 1;
            }
            const url = `/api/cars?type=indexdata&page=${page}`;
            this.$store.dispatch('getData',url);
       },
       // get companies
        getCompanies(){

            axios.get('/api/companies?type=indexdata')
            .then(res =>{
                this.Companies= res.data.data;
                 var swiper = new Swiper(".mySwiper", {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        },
                });
            })
            .catch(err => console.log(err))

       },
       // get cars by company
       getCarsByCMP(id){
         const url = `/api/cars?type=indexdata&cmpid=${id}`;
            this.$store.dispatch('getData',url);
       },
       // send car data to parent for booking
       sendDataToparent(item){
        this.car.price = item.prixJ;
        this.car.id = item.id;
        this.$emit('getCarData',this.car);
         this.getCars();
       },

    },

    components: {
      pagination,
    //   Swiper,SwiperSlide
    },
    data() {

        return {
             Companies:{},
             logged:User.isLogged(),
             car:{ },
        }
    },

    computed:{
        ...mapState({
            Cars: state => state.rows,
            AllData : state => state.AllData,
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
body.dark-theme .cars-container  .car-content{
 background: var(--dark-sc-color) !important;
 color: var(--text-seconde-color-dark);
}
body.dark-theme .cars-container  .car-content .car_img{

    background: var(--dark-pr-color);
}
body.dark-theme .car-content  .car-data .car-mf-company, body.dark-theme .car-content  .car-data .car-brande{
    color: var(--text-seconde-color-dark);

}
body.dark-theme .car-content  .car-data .car-j-prix{
    color: var(--text-color-dark) !important;

}
body.dark-theme .car-content  .car-data .car-j-prix .prix{
     color: #c5ff7d;

}
body.dark-theme .car-content  .car-data .btn{
    background: var(--dark-pr-color);
}
body.dark-theme .car-content  .car-data .btn:hover{
    background:#202020;
}
body.dark-theme .swiper-slide img {

border-radius: 50%;
background:  var(--text-color-dark);

}
body.dark-theme .swiper-slide .mf-c-title{
  color: var(--text-color-dark);
}
/*** dark mode end ***/

.cars-container {

    row-gap: 1rem;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3,1fr);
    row-gap: 20px;
    column-gap: 10px;

}
.cars-container  .car-content{
    border-radius: .56rem;
    padding: 5px 10px;
    background: #FFFFFF !important;
   box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
}
.cars-container  .car-content:hover{
    background: #f7f7f7 !important;
}
.cars-container  .car-content .car_img{
    border-radius: .56rem;
    max-height: 250px ;
    background: var(--my-sc-color);
    width: 100%;
}
.car-content  .car-data{
    padding: 10px;
    display: grid;
    row-gap: 1rem;
}
.car-content  .car-data .car-type{

  color: var(--text-color);
  font-size: var(--smaller-font-size);
  font-weight: 400;
}
.car-content  .car-data .car-mf-company,.car-content  .car-data .car-brande{
    color: #2B2B2B;
    font-size: var(--normal-font-size);
    font-weight: 500;
}
.car-content  .car-data .car-j-prix{
    color: var(--my-pr-color);
    font-size: var(--normal-font-size);
    font-weight: 500;
}
.car-content  .car-data .car-j-prix .prix{
     color: #a6cd77;

}
.car-content  .car-data  .btn{
    flex: 1 1 7rem;
    padding: 10px 34px;
    border: none;
    border-radius: 0.5rem;
    background: #495182;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
}
.car-content  .car-data  .btn:hover{

    background: var(--my-sc-color);

}


/* swiper style */
 .swiper {
        width: 100%;
        height: 100%;
        /* column-gap: 50px; */
      }

.swiper-slide {
/* width: 100px !important; */
text-align: center;
font-size: 18px;
/* Center slide text vertically */
display: -webkit-box;
display: -ms-flexbox;
display: -webkit-flex;
display: flex;
-webkit-box-pack: center;
-ms-flex-pack: center;
-webkit-justify-content: center;
justify-content: center;
-webkit-box-align: center;
-ms-flex-align: center;
-webkit-align-items: center;
align-items: center;
flex-direction: column;
}

.swiper-slide img {
display: block;
width: 100px;
height:  100px;
}
.swiper-slide .mf-c-title{
  color: #080218;
  font-size: var(--normal-font-size);
}
@media screen and (max-width: 320px) {


}
/* For medium devices and small */
@media screen and (max-width: 767px) {
.cars-container{
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
