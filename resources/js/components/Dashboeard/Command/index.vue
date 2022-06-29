<template>
    <div>
    <!-- state cards componenet  -->
      <cards :data="cardsdata"  ref="my_comp" @resendData="sendNewData"/>
    <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="div-header d-flex flex-row justify-content-between align-item-center border-bottom p-2">
                    <h3>
                        <i class='bx bx-list-ul bx-flashing' ></i>
                    </h3>
                    <div>
                        <!-- export selected  data to excel  -->
                         <vue-excel-xlsx
                             title="Export Data To Excel"
                             class="btn primary-btn"
                            :data="ExpTable"
                            :columns="columns"
                            :file-name="'Commands'"
                            :file-type="'xlsx'"
                            :sheet-name="'sheetname'"
                            >
                            <i class='bx bx-down-arrow-alt bx-tada bx-flip-horizontal' ></i> Export
                        </vue-excel-xlsx>
                    </div>
                </div>
            </div>
       </div>
     <!-- my table (fetch cars data in this table)    -->
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


            <div v-if="props.column.label == 'Car Image'">
               <img :src="props.row.car.image"  class="img-fluid   " style="border-radius:50%;width:50px;height:50px" :alt="props.row.slug +' logo'">
            </div>
            <div class=" dropdown d-flex justify-content-center align-items-center" v-else-if="props.column.field == 'Action'">
                <a class="text-black  text-center" href="#"  id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class=" action-btn fa-solid fa-ellipsis-vertical"></i>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li v-if="props.row.deleted_at == null"><a class="dropdown-item" href="#" @click='handleDelete(props.row)'><i class='bx bxs-trash-alt bx-tada' ></i> Delete</a></li>
                </ul>
            </div>
        <span v-else>
            {{props.formattedRow[props.column.field]}}
        </span>


        </template>
      </vue-good-table>
<!-- pagination componnent  -->
         <div class="pagination-section">
                 <pagination  :data="AllData" class="pag" @pagination-change-page="getCommands" ></pagination >
         </div>


      <!-- add Car Modal  -->
       <!-- <Add/> -->
    </div>
</template>
<script>
// import add modal componenet
// import Add from './Add.vue';
// flatPicker for Good table
import flatPickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';
import 'flatpickr/dist/themes/material_blue.css';

// maphelpers hellping to work eith store
import { mapState,mapMutations,mapGetters,mapActions } from 'vuex';

// import laravel-vue-pagination pagination componenet
import pagination from 'laravel-vue-pagination';

// import cadrs component
import cards from '../componnents/cards';
export default{
  components:{
     pagination,cards
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
            label: 'Car',
            field: 'car.Brande',
            type:'string',
             filterable: true,
            filterOptions: {
                enabled: true,
                placeholder: "Filter By Car"
            }
            },
             {
            label: 'Car Image',
            field: 'img',

            },
            {
            label: 'Command By',
            field: 'user.name',
            type:'string',
             filterable: true,
            filterOptions: {
                enabled: true,
                placeholder: "Filter By UserName"
            }
            },
             {
            label: 'Amount',
            field: 'PrixTTC',
             filterable: true,
            filterOptions: {
                enabled: true,
                placeholder: "Filter By Pric "
            },
            formatFn: this.formatPrixFn
            },
          {
            label: 'dateL',
            field: 'dateL',
            type: 'date',
            dateInputFormat: 'yyyy-MM-dd',
            dateOutputFormat: 'MMM do yy',
            filterOptions: {
                enabled: true,
                placeholder: 'Filter dateL',
                filterFn: this.dateRangeFilter,
          },
        },
        {
            label: 'dateR',
            field: 'dateR',
            type: 'date',
            dateInputFormat: 'yyyy-MM-dd',
            dateOutputFormat: 'MMM do yy',
            filterOptions: {
                enabled: true,
                placeholder: 'Filter dateR',
                filterFn: this.dateRangeFilter,
          },
        },
           {
            label: 'Created_at',
            field: 'created_at',
            type: 'date',
            dateInputFormat: 'yyyy-MM-dd',
            dateOutputFormat: 'MMM do yy',
            filterOptions: {
                enabled: true,
                placeholder: 'Filter created_at',
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
          label: 'Action',
          field: 'Action',
        },

        ],
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
        ExpTable:[],

    }
    },
    methods: {
        // get Commands from db methode
        getCommands(page){
            if(typeof page ===  'undefined'){
                page = 1;
            }
            this.url = `/api/command?page=${page}`
            this.cardsdata[0].title= 'Commands'
            this.cardsdata[0].icon= 'bx bx-file'
                 // send icons and titles to cards componenets
             this.cardsdata[1].title= 'Companies'
             this.cardsdata[1].icon= 'bx bx-category'
             this.cardsdata[2].title= 'Users'
             this.cardsdata[2].icon= 'bx bxs-user'
             this.cardsdata[3].title= 'Cars'
             this.cardsdata[3].icon= 'bx bx-car'
            this.$store.dispatch('getData', this.url);

            this.$forceUpdate();

        },

        // change prix day forma
        formatPrixFn: function(value) {
        return value + ' MAD';
        },

        // delete command function
        handleDelete(row){
            let data= {};
            data.url = `/api/command/${row.id}`;
            data.id = row.id;
            this.$store.dispatch('deleteData',data);


        },
        // get the selected data for export it to excel
        getSelectedDataForExporting() {
            this.ExpTable = this.$refs['my-table'].selectedRows;
        },


         // get data from cards componenet for change it if the state data change
        sendNewData(data){

            data[0].number = this.rows.length;
            data[1].number = this.CompaniesCount;
            data[2].number = this.UsersCount;
            data[3].number = this.carsCount;
        }
    },
       watch: {
      rows(val, oldVal) {
      // execute the child function for executing event and change the state data
      this.$refs.my_comp.resendToParent()

    },

  },
 mounted() {
          this.getCommands()
         if( this.getCommands()){
            this.$refs.my_comp.resendToParent()
         }




        let inputs = [
        'input[placeholder="Filter created_at"]',
        'input[placeholder="Filter updated_at"]',
        'input[placeholder="Filter dateR"]',
        'input[placeholder="Filter dateL"]',

        ];
        inputs.forEach(function(input) {
        flatPickr(input, {
            dateFormat: "m-d-Y",
            mode: "range",
            allowInput: true
        });
        });



    },
     computed:{
      // get command and more data from store
     ...mapState({

        rows : state => state.rows,
        AllData : state => state.AllData,
     }),
        Total: function () {
        return this.$store.state.AllData.total

        },
        CompaniesCount: function () {
        return this.$store.state.stateData.CompaniesCount

        },
        UsersCount: function () {
        return this.$store.state.stateData.usersCount

        },
        carsCount: function () {
        return this.$store.state.stateData.carsCount

        },
    }
}

</script>
