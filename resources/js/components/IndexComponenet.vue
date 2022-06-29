<template>
    <div class="container">

        <router-view></router-view>
    </div>
</template>

<script>
import index from './Public_content/sb_index'
    export default {
        name:'indexcomponent',
        components:{index},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
