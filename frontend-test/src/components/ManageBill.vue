<template>
  <div class="container">
    <div class="card bg-default mx-auto mt-5 shadow-card">
      <div class="card-header">
        <label v-if="bill_id == null">Crear Factura</label>
        <label v-else-if="bill_id != null">Editar Factura</label>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-4">
            <label for="">Vendedor</label>
            <input type="text" class="form-control form-control-sm" placeholder="Vendedor" v-model="vendor">
          </div>
          <div class="col-md-4">
            <label for="">Comprador</label>
            <input type="text" class="form-control form-control-sm" placeholder="Comprador" v-model="customer">
          </div>
          <div class="col-md-4"></div>
        </div>
        <table class="table table-stripped table-hover">
          <thead>
            <tr>
              <th scope="col">Item</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Valor Unitario</th>
              <th scope="col">Valor Total</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, key) in list_items" v-bind:key="item.id">
              <td><input type="text" class="form-control form-control-sm" placeholder="Descripción" v-model="item.item_description" :class="`item-${item.id}`" :id="`description-${item.id}`"></td>
              <td><input type="number" @keyup="calculate(key)" class="form-control form-control-sm" placeholder="Cantidad" v-model="item.quantity" :class="`item-${item.id}`" :id="`quantity-${item.id}`"></td>
              <td><input type="number" @keyup="calculate(key)" class="form-control form-control-sm" placeholder="Valor Unitario" v-model="item.unit_value" :class="`item-${item.id}`" :id="`unit_value-${item.id}`"></td>
              <td><input type="number" disabled class="form-control form-control-sm" placeholder="Valor Total" v-model="item.total_value" :class="`item-${item.id}`" :id="`total_value-${item.id}`"></td>
              <td class="text-center"><button class="btn btn-sm btn-rounded btn-danger" @click="deleteItem(key)"><i class="fa fa-trash"></i></button></td>
            </tr>
            <tr>
              <td class="font-weight-bold" colspan="3" style="text-align: right;">Total</td>
              <td class="font-weight-bold" style="text-align: right;">$ {{ total_bill }}</td>
            </tr>
          </tbody>
        </table>
        <div class="row text-center">
          <div class="col-md-12">
            <button class="btn btn-sm btn-rounded btn-primary" @click="addItem()"> Agregar Item <i class="fa fa-plus"></i></button>
          </div>
        </div>
      </div>
      <div class="card-footer text-center">
        <button class="btn btn-success btn-sm" v-if="bill_id == null" @click="createBill()"> Guardar Factura <i class="fa fa-floppy-o"></i></button>
        <button class="btn btn-success btn-sm" v-else-if="bill_id != null" @click="updateBill()"> Editar Factura <i class="fa fa-floppy-o"></i></button>
        <router-link class="btn btn-info btn-sm" to="/bills" tag="button">Cancelar <i class="fa fa-times"></i></router-link>
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  export default {
    name: 'ManageBill',
    components: {

    },
    data() {
      return {
        bill_id: null,
        vendor: null,
        customer: null,
        total_bill: 0,
        list_items: [
            {'id': 1, 'item_description': '', 'quantity': 0, 'unit_value': 0, 'total_value': 0}
        ],
      }
    },
    created() {
      // Validación que de acuerdo al parametro si existe es una actualización de lo contrario una creación de facturas
      if (this.$route.params.id != undefined) {
        this.bill_id = this.$route.params.id;
        this.getBillId();
      }
    },
    methods: {
      // función que llama al servicio para crear una factura
      createBill() {
        const object = {
          vendor: this.vendor,
          customer: this.customer,
          list_items: this.list_items
        }
        axios.post('bills/create', object).then(resp => {
          if (resp.status == 201) {
            this.$router.push('/bills');
            Swal.fire(resp.data, '', 'success')
          }
        }).catch(error => {
          Swal.fire(error, '', 'error')
        });
      },
      // función que llama al servicio para actualizar una factura
      updateBill() {
        const object = {
          vendor: this.vendor,
          customer: this.customer,
          list_items: this.list_items
        }
        axios.put(`bills/update/${this.bill_id}`, object).then(resp => {
          if (resp.status == 201) {
            this.$router.push('/bills');
            Swal.fire(resp.data, '', 'success')
          }
        }).catch(error => {
          Swal.fire(error, '', 'error')
        });
      },
      // función que llama al servicio traer toda la información de la factura actual
      getBillId() {
        axios.get(`bills/detail/${this.bill_id}`).then(resp => {
          this.vendor = resp.data.vendor;
          this.customer = resp.data.customer;
          this.total_bill = this.formatValue(parseInt(resp.data.total_value));
          this.list_items = resp.data.item_bills;
        }).catch(error => {
        });
      },
      // función que da formato para mostrar el total con separadores de miles y decimales
      formatValue(number){
        const exp = /(\d)(?=(\d{3})+(?!\d))/g;
        const rep = '$1,';
        let arr = number.toString().split('.');
        arr[0] = arr[0].replace(exp,rep);
        return arr[1] ? arr.join('.'): arr[0];
      },
      // función que agrega elementos a las facturas
      addItem(){
        let num_register = this.list_items.length + 1;
        let arr_item = {'id': num_register, 'item_description': '', 'quantity': 0, 'unit_value': 0, 'total_value': 0};
        this.list_items.push(arr_item);
      },
      // función que elimina elementos de las facturas
      deleteItem(key){
          let num_register = this.list_items.length;
          if (num_register > 1) {
              this.list_items.splice(key, 1);
          }
      },
      // función que calcula el total de la factura de acuerdo a los items ingresados
      calculate(key){
        let quantity = this.list_items[key].quantity;
        let unit_value = this.list_items[key].unit_value;
        let total_value = quantity*unit_value;
        let total_items = 0;
        this.list_items[key].total_value = total_value;
        $.each(this.list_items, function(key, value){
          total_items += value.total_value;
        });
        this.total_bill = this.formatValue(total_items);
      }
    }
  }
</script>
