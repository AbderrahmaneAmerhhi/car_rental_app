<template>
    <div class="container mt-5">
        <div class="row  justify-content-center">
             <div class="div-header d-flex flex-row justify-content-between  align-items-center border-bottom p-2">
                 <!-- Back to index link  -->
                 <router-link :to="{name:'Companies'}" class="my-btn  primary-btn"><i class='bx bx-arrow-back'></i></router-link>
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
                            <label for="exampleInputEmail1" class="form-label">Title :</label>
                            <input type="text" v-model="Company.title"  placeholder="Enter The Barnde Title" class="my-input"   required>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Company Logo</label>
                            <input class="form-control" @change="onImageChaneg" type="file" id="formFile">
                        </div>

                        <button type="button" class="btn primary-btn" @click="updateCompany">Submit</button>
                    </form>
            </div>

    </div>
</template>
<script>
import { mapState } from 'vuex';

export default{
    mounted() {
        this.getCompanies();
    },

  data () {
    return {
    }
  },
  methods: {
      // get image file from input
      onImageChaneg(e){
         this.Company.file = e.target.files[0];
      },
      getCompanies(){
          this.$store.dispatch('getDataById',` /api/companies/${this.$route.params.slug}`);

      },
      updateCompany(){
          this.Company.url= `/api/companies/${this.Company.slug}`;
          this.$store.dispatch('UpdateData',this.Company);
          this.$router.push({name:'Companies'})
      }
  },
    name:'editBrande',
    computed:{
        ...mapState({
             Company : state => state.rowofData,

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
