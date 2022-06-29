<template>
    <div>
        <!-- navbar content  -->
        <navBar />

        <!-- sidebar content  -->
        <sideBar/>



          <!-- router view for get componenets by vue  router  -->
        <router-view></router-view>
    </div>
</template>

<script>
import navBar from './componnents/navBar.vue'
import sideBar from './componnents/sideBar.vue'
export default {
    mounted() {

    },
  methods: {
  },
  data () {
    return {

    }
  },
    name:'dash_index',
    components:{navBar,sideBar}
}
</script>
