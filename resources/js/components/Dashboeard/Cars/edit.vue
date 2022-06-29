<template>
    <div class="container mt-5">
        <div class="row  justify-content-center">
             <div class="div-header d-flex flex-row justify-content-between  align-items-center border-bottom p-2">
                 <!-- Back to index link  -->
                 <router-link :to="{name:'Cars'}" class="my-btn  primary-btn"><i class='bx bx-arrow-back'></i></router-link>
                 <!-- icon for decoration  -->
                 <i class='bx bxs-edit bx-tada' ></i>
             </div>
        </div>

            <div class="my-card mt-3">
                 <div class="">
                     <h1>Edit </h1>
                 </div>
                   <form class="mt-4" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Brande</label>
                            <input type="text" v-model="Car.Brande" placeholder="Enter The Car Model" class="form-control"   required>
                        </div>
                        <div class="mb-3 input-group">
                            <input type="number" class="form-control"  v-model="Car.prixJ" placeholder="Entre the Price by Day" aria-label="Dollar amount (with dot and two decimal places)">
                            <span class="input-group-text">MAD</span>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"  v-model="Car.dispo" type="radio" value="1" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    available
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"  v-model="Car.dispo" type="radio" value="0" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    non available
                                </label>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label  class="form-label">fuel Type :</label>
                            <div class="form-check">
                                <input class="form-check-input"  v-model="Car.type" type="radio" value="Diesel fuel" name="fuel" id="flexRadiofuel1" checked>
                                <label class="form-check-label" for="flexRadiofuel1">
                                    Diesel fuel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"  v-model="Car.type" type="radio" value="Gasoline" name="fuel" id="flexRadiofuel2" checked>
                                <label class="form-check-label" for="flexRadiofuel2">
                                Gasoline
                                </label>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="select" class="form-label">Select a Car MFK Company:</label>
                            <select class="form-select" id="select" aria-label="Default select example" v-model="Car.company_id" >
                                <option :value="data.id" v-for="(data,index) in Companies" :key="index" >{{data.title}}</option>
                        </select>
                        </div>



                        <div class="mb-3">
                            <label for="formFile" class="form-label">Car Image</label>
                            <input class="form-control" @change="onImageChaneg" type="file" id="formFile">
                        </div>

                        <button type="button" class="btn primary-btn" @click="updateCar">Submit</button>
                    </form>
            </div>

    </div>
</template>
<script>
import { mapState } from 'vuex';

export default{
    mounted() {
        this.getCar();
        this.getCompanies();
    },

  data () {
    return {
        Companies:[]
    }
  },
  methods: {
    //  getCompanies function
       getCompanies(){
        axios.get('/api/companies')
            .then(res =>{
                this.Companies= res.data.data.data;
            })
            .catch(err => console.log(err))
       },
      // get image file from input
      onImageChaneg(e){
         this.Car.file = e.target.files[0];
      },
      getCar(){
          this.$store.dispatch('getDataById',` /api/cars/${this.$route.params.slug}`);

      },
      updateCar(){
          this.Car.url= `/api/cars/${this.Car.slug}`;
          this.$store.dispatch('UpdateData',this.Car);
          this.$router.push({name:'Cars'})
      }
  },
    name:'editCar',
    computed:{
        ...mapState({
             Car : state => state.rowofData,

        })
    }


}
</script>
<style>

.my-btn{
width: 35px;
height: 30px;
border-radius: .25rem;
text-align: center;
display: grid;
align-items: center;
}
.my-card {
    padding: 10px;
    width: 100%;
    border-radius: 20px;
    background: #fcfcfcc7;
    box-shadow: 0.2rem .5rem .5rem #eceef4;
}
.my-card:hover{
    background:#fbfbfbf3 ;
}
.my-input{
    display: block;
    border: none;
    outline: none;
    background:  #f4f4f4;
    width: 100%;
    height: 40px;
    border-radius: 1rem;
    font-size:  .75rem;
    padding: 10px;
    color: rgb(45, 45, 45);
}
.my-input::placeholder{
    color: rgb(150, 150, 150);
}

</style>
