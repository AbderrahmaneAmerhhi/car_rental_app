<template>
  <div>
     <!-- state cards componenet  -->
      <cards :data="cardsdata"  ref="my_comp" @resendData="sendNewData"/>

  <div class="container mt-5">
    <!-- content  -->

     <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="div-header d-flex flex-row justify-content-between align-item-center border-bottom p-2">
                    <h3>
                        <i class='bx bx-list-ul bx-flashing' ></i>
                    </h3>
                    <div>

                          <!-- get archived Brandes  -->
                          <a v-if="activedata == true" href="#" title="get archived data" @click="getArchiveCompanies()"  class="btn primary-btn btn-ac-arch">
                           <i class='bx bx-archive '></i>
                          </a>
                          <a v-else-if="activedata == false" href="#" title="get actived data" @click="getActiveCompanies()"  class="btn primary-btn btn-ac-arch">
                           <i class='bx bx-check-square '></i>
                          </a>
                         <!-- import file excel with data  && send this data to db  -->
                         <input type="file" id="file-ex"   class="btn primary-btn" @change="onFileChange" >
                          <label class="btn primary-btn" title="Import Data from Excel"  for="file-ex"><i class='bx bx-up-arrow-alt'></i> Import</label>
                        <!-- export selected  data to excel  -->
                         <vue-excel-xlsx
                             title="Export Data To Excel"
                             class="btn primary-btn"
                            :data="ExpTable"
                            :columns="columns"
                            :file-name="'Companies'"
                            :file-type="'xlsx'"
                            :sheet-name="'sheetname'"
                            >
                            <i class='bx bx-down-arrow-alt bx-tada bx-flip-horizontal' ></i> Export
                        </vue-excel-xlsx>
                        <!-- add new row in db -->
                        <a href="#" title="Add New Data" data-bs-toggle="modal" data-bs-target="#AddModal"  class="btn primary-btn">
                            <i class="fas fa-plus"></i>
                        </a>

                    </div>

                </div>
            </div>
       </div>
    <vue-good-table
      ref="my-table"
      :columns="columns"
      :rows="rows"
       @on-selected-rows-change="getSelectedDataForExporting"
      :select-options="{
          enabled: true,
          selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row

       }"
      :search-options="{ enabled: true }"

      >
       <template slot="table-row" slot-scope="props">
              <span v-if="props.column.label == 'Deleted_at' && props.row.deleted_at != undefined ">
                <span class="badge bg-danger"> {{props.row.deleted_at}}</span>
            </span>
            <span v-else-if="props.column.label == 'Deleted_at'   ">
                <span class="badge bg-info">Deleted Date Not exist</span>
            </span>
            <div v-if="props.column.label == 'Logo'">
               <img :src="props.row.logo"  class="img-fluid   " style="border-radius:50%;width:50px;height:50px" :alt="props.row.slug +' logo'">
            </div>
            <div class="dropdown d-flex justify-content-center align-items-center" v-else-if="props.column.field == 'Action'">
                <a class="text-black  text-center" href="#"  id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="action-btn fa-solid fa-ellipsis-vertical"></i>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <!-- <li><router-link class="dropdown-item" :to="props.row.path" ><i class='bx bx-show bx-tada bx-flip-horizontal' ></i> Show</router-link></li> -->
                    <li><router-link class="dropdown-item" :to="{name:'editCompany', params: { slug: props.row.slug }}" ><i class='bx bxs-edit bx-tada' ></i> Edit</router-link></li>
                    <li v-if="props.row.deleted_at == null"><a class="dropdown-item" href="#" @click='handleDelete(props.row)'><i class='bx bxs-trash-alt bx-tada' ></i> Delete</a></li>
                    <li v-else><a class="dropdown-item" href="#" @click='activerow(props.row)'><i class='bx bx-check-square bx-tada' ></i> Active</a></li>
                </ul>
            </div>
        <span v-else>
            {{props.formattedRow[props.column.field]}}
        </span>


        </template>
      </vue-good-table>
       <!-- pagination componnent  -->
         <div class="pagination-section">
                 <pagination  :data="AllData" class="pag" @pagination-change-page="getCompaniesByPagination" ></pagination >
         </div>


       <!-- add Brand Modal  -->
       <Add @getData="getDataFromAdd" />
  </div>

  </div>

</template>

<script>
// import add modal componenet
import Add from './Add.vue';
// flatPicker for Good table
import flatPickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';
import 'flatpickr/dist/themes/material_blue.css';

// maphelpers hellping to work eith store
import { mapState,mapMutations,mapGetters,mapActions } from 'vuex';

// import laravel-vue-pagination pagination componenet
import pagination from 'laravel-vue-pagination';

// this biblio for reding excel files
import readXlsxFile from 'read-excel-file'

// import cadrs component
import cards from '../componnents/cards';
export default {


  props: {
  },
  components:{
     Add,pagination,cards
  },
    mounted() {

        this.getActiveCompanies();
        if(this.getActiveCompanies()){
            // execute the child function for executing event and change the state data
            this.$refs.my_comp.resendToParent();
        }

        let inputs = [
        'input[placeholder="Filter crated_at"]',
        'input[placeholder="Filter updated_at"]'
        ];
        inputs.forEach(function(input) {
        flatPickr(input, {
            dateFormat: "m-d-Y",
            mode: "range",
            allowInput: true
        });
        });



    },
  data () {

    return {
         columns: [
            {
            label: '#Id',
            field: 'id',
            filterable: true,
            filterOptions: {
                enabled: true,
                placeholder: "Filter By ID"
            }
            },
            {
            label: 'Title',
            field: 'title',
            type:'string',
             filterable: true,
            filterOptions: {
                enabled: true,
                placeholder: "Filter By title"
            }
            },
            {
            label: 'Logo',
            field: 'logoo',
            type:'file',

            },
           {
            label: 'Created_at',
            field: 'created_at',
            type: 'date',
            dateInputFormat: 'yyyy-MM-dd',
            dateOutputFormat: 'MMM do yy',
            filterOptions: {
                enabled: true,
                placeholder: 'Filter crated_at',
                filterFn: this.dateRangeFilter,
          },
        },
        {
          label: 'Updated_at',
          field: 'updated_at',
          type: 'date',
          dateInputFormat: 'yyyy-MM-dd',
          dateOutputFormat: 'MMM do yy',
          filterOptions: {
            enabled: true,
            placeholder: 'Filter updated_at',
            filterFn: this.dateRangeFilter,
          },
        },
        {
          label: 'Deleted_at',
          field: 'deleted_att',
          type: 'date',
          dateInputFormat: 'yyyy-MM-dd',
          dateOutputFormat: 'MMM do yy',
        //    hidden: true,
          filterOptions: {
            enabled: true,
            placeholder: 'Filter updated_at',
            filterFn: this.dateRangeFilter,
          },
        },
        {
          label: 'Action',
          field: 'Action',
        },

        ],

        Company: {},
        ExpTable:[],


        // cadrs stat data
       cardsdata:[
            {
                title:'defualt title',
            },
            {
                title:'defualt title'
            },
           {
                title:'defualt title',
            },
           {
                title:'defualt title',
            }
        ],
        activedata:true,



    }
  },
   watch: {
    rows(val, oldVal) {
      // execute the child function for executing event and change the state data
      this.$refs.my_comp.resendToParent()
    },

  },
    name:'Companies_index',
    methods: {


          // filter date field in table
          dateRangeFilter(data, filterString) {
            const dateRange = filterString.split('to');
            const startDate = Date.parse(dateRange[0]);
            const endDate = Date.parse(dateRange[1]);
            return (data =
                Date.parse(data) >= startDate && Date.parse(data) <= endDate);
            },

        // execute getdata action with our url for getting the companies
         getActiveCompanies(){
            this.cardsdata[0].icon = '';
            this.url = `/api/companies`
            this.cardsdata[0].title= 'Active MFC CMP'
            this.cardsdata[0].icon= 'bx bx-check-square'
                 // send icons and titles to cards componenets
             this.cardsdata[1].title= 'Cars'
             this.cardsdata[1].icon= 'bx bxs-car'
             this.cardsdata[2].title= 'Users'
             this.cardsdata[2].icon= 'bx bxs-user'
             this.cardsdata[3].title= 'Orders'
             this.cardsdata[3].icon= 'bx bx-file'
            this.$store.dispatch('getData', this.url);
            this.$forceUpdate();
            this.activedata = true;



        },
        getArchiveCompanies(){
             this.url = `/api/companies?type=archive`
            this.cardsdata[0].title= 'Archive MFC CMP'
            this.cardsdata[0].icon= 'bx bx-archive'
            this.cardsdata[1].title= 'Cars'
             this.cardsdata[1].icon= 'bx bxs-car'
             this.cardsdata[2].title= 'Users'
             this.cardsdata[2].icon= 'bx bxs-user'
             this.cardsdata[3].title= 'Orders'
             this.cardsdata[3].icon= 'bx bx-file'
            this.$store.dispatch('getData', this.url);
            this.$forceUpdate();
             this.activedata = false;
        },
        // pagination function
        getCompaniesByPagination(page){
          if(typeof page ===  'undefined'){
                page = 1;
            }
            document.querySelector('.archive-active-icon').classList.forEach((ele)=>{
                if(ele == 'bx-archive'){
                     this.url = `/api/companies?page=${page}`

                }else if(ele == 'bx-check-square'){
                     this.url = `/api/companies?page=${page}&type=archive`
                }});
            // const url = `/api/companies?page=${page}`;
            this.$store.dispatch('getData',  this.url);

        },
         // delete Company function
        handleDelete(row){
            let data= {};
            data.url = `/api/companies/${row.slug}`;
            data.id = row.id;
            this.$store.dispatch('deleteData',data);


        },
        // active archived row
        activerow(row){
            let data= {};
            data.url = `/api/companies/${row.slug}`;
            data.id = row.id;
            this.$store.dispatch('activeData',data);


        },
        // get new Company data from child componenet add for send this data to db
        getDataFromAdd(data){
            this.Company = data;
            this.AddCompany(this.Company);


        },
        // add Company function
        AddCompany(Brande){
            Brande.url ='/api/companies';
            if(this.$store.dispatch('addData',Brande)){
              this.url = `/api/companies`
              this.$store.dispatch('getData', this.url);
            }


        },

        // get the selected data for export it to excel
        getSelectedDataForExporting() {

            this.ExpTable = this.$refs['my-table'].selectedRows;

        },

        // on file change in input file (importin excel )
        onFileChange(event){
            let importedExcel = event.target.files ? event.target.files[0] : null;
            readXlsxFile(importedExcel).then((rows) => {
              // store importing data

              for(var i=0;i<this.rows.length;i++){

                  this.Company.title = rows[i+1][1];
                   this.AddCompany(this.Company)

              }
            })
        },
        // get data from cards componenet for change it if the state data change
        sendNewData(data){

            data[0].number = this.Total;
            data[1].number = this.CarsCount;
            data[2].number = this.UsersCount;
            data[3].number = this.orders;
        }





  },
  computed:{
      // get Companies from store
     ...mapState({

        rows : state => state.rows,
        AllData : state => state.AllData,
     }),
      Total: function () {
       return this.$store.state.AllData.total

    },
    CarsCount: function () {
       return this.$store.state.stateData.CarsCount

    },
    UsersCount: function () {
       return this.$store.state.stateData.usersCount

    },
    orders: function () {
       return this.$store.state.stateData.CommandCount

    },




  }
}
</script>


<style>

.vgt-responsive::-webkit-scrollbar{
    display: none !important;
}
#file-ex{
    display: none;
}
</style>
