<template>

    <!-- Modal -->
    <div class="modal fade " id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new Company</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form enctype="multipart/form-data" >
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Title</label>
                    <input type="text" v-model="Company.title" placeholder="Enter The Barnde Title" class="form-control"   required>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Company Logo</label>
                    <input class="form-control" @change="onImageChaneg" type="file" id="formFile">
                </div>

                <button type="button" class="btn primary-btn" @click="sendData">Submit</button>
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
         this.Company.file = e.target.files[0];
      },
      sendData(){
          this.$emit('getData',this.Company);
          this.Company = {};
          document.getElementById('formFile').value=null;
          this.Company.file = null;
      }
  },

  data () {
    return {
        Company:{
            title:''
        }
    }
  },
    name:'Add'

}
</script>
<style>
.modal-dialog{
    border-radius: 1.25rem;
}
</style>
