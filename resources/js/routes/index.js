import Vue from "vue";
import VueRouter from "vue-router";


import editCompany from  '../components/Dashboeard/Companies/edit.vue';
import CompaniesHome from '../components/Dashboeard/Companies/index.vue';
import editCar from "../components/Dashboeard/Cars/edit.vue";
import CarsHome from "../components/Dashboeard/Cars/index.vue";
import SBindex from "../components/Public_content/sb_index.vue";
import index from "../components/Public_content/index.vue";
import CmdIndex from '../components/Dashboeard/Command/index.vue'
import dashHome from '../components/Dashboeard/home/index.vue'

Vue.use(VueRouter)
const routes = [
    // DashBoeard Routes

    // home dashboear vue route
    {
        path:'/admin/home',component:dashHome,name:'dahshome'
     },
    // Companies routes
 {
    path:'/admin/Companies',component:CompaniesHome,name:'Companies'
 },
 // Edit Companies route
 {
    path:'/admin/editCompany/:slug',component:editCompany,name:'editCompany'
 },
 // Cars route
 {
    path:'/admin/Cars',component:CarsHome,name:'Cars'
 },
 // Edit Car route
 {
    path:'/admin/editCar/:slug',component:editCar,name:'editCar'
 },


 // Commands routes
 {
    path:'/admin/Commands',component:CmdIndex,name:'Commands'
  },
 // Index routes

   // first componenet
   {
    path:'/',component:SBindex,name:'SBindex'
  },
  // index componenet route

 {
    path:'/index',component:index,name:'index'
 },

] ;


// create router
const router = new VueRouter({
    Hashbang: false,
    mode: 'history',
    routes,
})

export default router;
