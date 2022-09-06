<template>
  <div class="container">
    <div class="card bg-default mx-auto mt-5 shadow-card">
      <div class="card-header">
        Listado de Facturas
      </div>
      <div class="card-body">
        <table class="table table-stripped table-hover display" id="table_bills">
          <thead>
            <tr>
              <th scope="col"># Factura</th>
              <th scope="col">Vendedor</th>
              <th scope="col">Comprador</th>
              <th scope="col">Fecha y Hora</th>
              <th scope="col">Valor Total</th>
              <th scope="col">Editar</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(bill) in list_bills" v-bind:key="bill.id">
              <td>{{ bill.bill_number }}</td>
              <td>{{ bill.vendor }}</td>
              <td>{{ bill.customer }}</td>
              <td>{{ bill.date_bill }}</td>
              <td> $ {{ bill.total_value }}</td>
              <td> <router-link class="btn btn-info btn-rounded btn-sm" :to="'/manage-bill/' + bill.id" tag="button"><i class="fa fa-pencil"></i></router-link></td>
              <td><button class="btn btn-sm btn-rounded btn-danger" @click="deleteBill(bill.id)"><i class="fa fa-trash"></i></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="card-footer text-center">
        <router-link class="btn btn-info btn-sm" to="/manage-bill" tag="button">Crear Factura <i class="fa fa-plus-circle"></i></router-link>
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  export default {
    name: 'Bills',
    components: {

    },
    data() {
      return {
        list_bills: [],

      }
    },
    created() {
      this.getListBills();
    },
    methods: {
      getListBills() {
        axios.get('bills/list').then(resp => {
          console.log(resp);
          this.list_bills = resp.data;
        }).catch(error => {
          console.log(error);
        });
      },
      deleteBill(bill_id){
        Swal.fire({
          title: 'Esta seguro de eliminar la factura seleccionada?',
          showCancelButton: true,
          icon: 'question',
          confirmButtonText: 'Eliminar',
          cancelButtonText: `Cancelar`,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete(`bills/delete/${bill_id}`).then(resp => {
              console.log(resp);
              this.getListBills();
            }).catch(error => {
              console.log(error);
            });
            Swal.fire('Eliminada', '', 'success')
          }
        })
      }
    }
  }
</script>
