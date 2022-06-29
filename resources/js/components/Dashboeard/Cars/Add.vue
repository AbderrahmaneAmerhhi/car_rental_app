<template>

    <!-- Modal -->

    <div class="modal fade " id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new Car</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form enctype="multipart/form-data" >
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

                <button type="button" class="btn primary-btn" @click="AddCar">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn close-btn" id="closemodal" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</template>
<script>

export default{
  methods: {
       //get image from input using event
      onImageChaneg(e){
         this.Car.file = e.target.files[0];
      },

    // get companies function
       getcompanies(){
        axios.get('/api/companies')
            .then(res =>{
                this.Companies= res.data.data.data;
            })
            .catch(err => console.log(err))
       },
       // add brande function
        AddCar(){
            this.Car.url ='/api/cars';
            this.$store.dispatch('addData',this.Car);
             this.$store.dispatch('getData', this.Car.url);


        },

  },

  data () {
    return {
        Companies:[],
        Car:{
            Brande:'',
            type:'Gasoline',
            prixJ:'',
            dispo:0,
            company_id:'',


        }
    }
  },
  mounted() {
    this.getcompanies();
  },
   computed:{

    },
    name:'Add'

}
</script>
<style>
.modal-dialog{
    border-radius: 1.25rem;
}
</style>
