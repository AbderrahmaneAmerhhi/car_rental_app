<template>

    <div class="container-fluid px-4">
         <div class="row g-3 my-2">
             <div class=" col-md-3" v-for="(data,index) in data" :key="index">
                <div class="cadr p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded">
                    <div>
                        <h3 class="fs-5">{{data.title}}</h3>
                        <p class="counter fs-5" v-bind:data-target="data.number" >{{data.number}}</p>
                    </div>
                    <i class="fs-1  border  p3 card-icon "></i>
                </div>
             </div>

         </div>
    </div>

</template>

<script>

export default {
  data () {
    return {
    }
  },
  created () {

  },
  mounted() {

      this.addIcons();
      this.CounterAnimation();
  },
   props: {
    data: {
      type: Array
    }
  },
   watch: {


  },
    name:'cards',
    methods: {
        // add icon to stat cards
        addIcons(){
            if(this.data){
                const iconele = document.querySelectorAll('.card-icon');
                for(var i =0;i< this.data.length;i++){
                    iconele.forEach((ele,index) =>{


                       if(i === index){
                             ele.classList.remove('bx')
                             ele.classList.remove('bx-stats')
                             if(ele.classList.length > 4){
                                // remove the Previous  class for adding a new class icon
                                for(var n=0;n<ele.classList.length;n++){
                                    ele.classList.remove(''+ele.classList[n+4]+'')
                                }
                             }
                           if( this.data[i].icon){
                               this.data[i].icon.split(' ').forEach(l =>{
                                ele.classList.toggle(l)
                                })

                           }else{
                            // add card default icon
                             var defaultClass = 'bx bx-stats';
                             defaultClass.split(' ').forEach(l => ele.classList.toggle(l))
                           }

                       }

                    });
                }
            }

        },
        // stat cards Counte up animation
        CounterAnimation(){
            const counters = document.querySelectorAll('.counter');
            counters.forEach((counter)=>{
                counter.innerText = '0';
                const UpdateCounter = () =>{
                const target = +counter.getAttribute('data-target');
                const c = +counter.innerText;

                 const increment =target/200;
                if(c < target){

                    counter.innerText = `${Math.ceil(c + increment)}`;
                    setTimeout(UpdateCounter, 1)
                 }
                };
            UpdateCounter();
            })


        },
        resendToParent(){
            this.$emit('resendData',this.data);


            this.addIcons();
            this.CounterAnimation();
            this.$forceUpdate();


        }

  },
  computed:{

  }
}
</script>


<style>

/* .cadr{
   position: relative;

} */
/* .cadr::before{
    content: '';
    width: 6px;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    background-color: #232D65;
} */

.card-icon{

    width: 60px;
    height: 60px;
    display: grid;
    text-align: center;
    align-items: center;
    background-color: #929DD9;
    color:  #232D65;
    border-radius: 50%;
}
.cadr:hover::before{
    background-color: #929DD9;
}
.cadr:hover .card-icon{
     background-color: #A8B0E0;
}
</style>
