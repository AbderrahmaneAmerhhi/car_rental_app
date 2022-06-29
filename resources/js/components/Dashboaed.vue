<template>
    <index  v-if="logged != false  && isAdmin == true"/>

    <auth @logindata="login" v-else />
</template>

<script>
import User from '../helpers/User'
import index from './Dashboeard/index.vue'
import auth from './Dashboeard/auth.vue'
export default {
  methods: {
    login(data){
      console.log(data)
      this.logged = data;
      data.admin == 1 ? this.isAdmin= true :false

    }
  },
  data () {
    return {
        logged:User.isLogged(),
        isAdmin:User.isAdmin(),
    }
  },
    name:'dashboard',
    components:{index,auth}

}

</script>
