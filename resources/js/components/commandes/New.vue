<template>
    <div class="container">
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">New Invoice</h2>
                </div>
                <div>

                </div>
            </div>

            <div class="card__content">
                <div class="card__content--header">
                    <div>
                        <p class="my-1">Customer</p>
                        <select id="" class="input">
                            <option selected disabled>Choisir un client</option>
                            <option :value="customer.id" v-for="customer in allCustomers" :key="customer.id">{{
                                customer.firstname }}</option>
                        </select>
                    </div>
                    <div>
                        <p class="my-1">Date</p>
                        <input v-model="form.date" id="date" placeholder="dd-mm-yyyy" type="date" class="input"> <!---->
                        <p class="my-1">Due Date</p>
                        <input v-model="form.date_echeance" id="due_date" type="date" class="input">
                    </div>
                    <div>
                        <p class="my-1">Numero</p>
                        <input v-model="form.number" type="text" class="input">
                        <p class="my-1">Reference(Optional)</p>
                        <input v-model="form.reference" type="text" class="input">
                    </div>
                </div>
                <br><br>
                <div class="table">

                    <div class="table--heading2">
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Qty</p>
                        <p>Total</p>
                        <p></p>
                    </div>

                    <!-- item 1 -->
                    <div class="table--items2" v-for="(itemcart, i) in listCart" :key="itemcart.id">
                        <p>#{{ itemcart.item_code }} {{ itemcart.description }}</p>
                        <p>
                            <input v-model="itemcart.unit_price" type="text" class="input">
                        </p>
                        <p>
                            <input v-model="itemcart.quantity" type="text" class="input">
                        </p>
                        <p v-if="quantity">
                            {{ (itemcart.quantity) * (itemcart.unit_price) }}
                        </p>
                        <p v-else></p>
                        <p style="color: red; font-size: 24px;cursor: pointer;">
                            &times;
                        </p>
                    </div>
                    <div style="padding: 10px 30px !important;">
                        <button class="btn btn-sm btn__open--modal" @click="openModal()">Add New Line</button>
                    </div>
                </div>

                <div class="table__footer">
                    <div class="document-footer">
                        <p>Terms and Conditions</p>
                        <textarea cols="50" rows="7" class="textarea"></textarea>
                    </div>
                    <div>
                        <div class="table__footer--subtotal">
                            <p>Sub Total</p>
                            <span>$ 1000</span>
                        </div>
                        <div class="table__footer--discount">
                            <p>Discount</p>
                            <input type="text" class="input">
                        </div>
                        <div class="table__footer--total">
                            <p>Grand Total</p>
                            <span>$ 1200</span>
                        </div>
                    </div>
                </div>
                <div class="card__header" style="margin-top: 40px; margin-left: 20px;">
                    <div>
                        <a class="btn btn-secondary">
                            Save
                        </a>
                    </div>
                </div>
            </div>

            <!--==================== add modal items ====================-->
            <div class="modal main__modal" :class="{ show: showModal }">
                <div class="modal__content">
                    <span class="modal__close btn__close--modal" @click="closeModal()">×</span>
                    <h3 class="modal__title">Add Item</h3>
                    <hr><br>
                    <li v-for="(productitem, i) in listProducts" :key="productitem.id"
                        style="display: grid; grid-template-columns: 30px 350px 15px; align-items: center; padding-bottom: 5px;">
                        <p>{{ i + 1 }}</p>
                        <a href="#">{{ productitem.item_code }} {{ productitem.description }}</a>
                        <button @click="addCart(productitem)">+</button>
                    </li>
                    <br>
                    <hr>
                    <div class="model__footer">
                        <button class="btn btn-light mr-2 btn__close--modal" @click="closeModal()">
                            Cancel
                        </button>
                        <button class="btn btn-light btn__close--modal ">Save</button>
                    </div>
                </div>
            </div>

            <br><br><br>
        </div>
    </div>
</template>



<script setup>
import { onMounted, ref } from 'vue';

let form = ref([]);
let allCustomers = ref([])
let customer_id = ref([])
let item = ref([])
let listCart = ref([])
let showModal = ref(false)
let hideModal = ref(true)
let listProducts = ref([])


onMounted(async () => {
    indexForm()
    all_customers()
    getProducts()
});


const indexForm = async () => {

    let response = await axios.get('/api/create_invoice')
    form.value = response.data
    //console.log('form', form);
}


const all_customers = async () => {
    let response = await axios.get('/api/customers')
    allCustomers.value = response.data.customer
    //console.log('response', allCustomers);
}

const addCart = (item) => {

    const itemCart =

    {
        id: item.id,
        item_code: item.item_code,
        description: item.description,
        unit_price: item.unit_price,
        quantity: item.quantity

    }
    listCart.value.push(itemCart)
    console.log(itemCart);
}

const openModal = () => {
    showModal.value = !showModal.value
}
const closeModal = () => {
    showModal.value = !hideModal.value
}

const getProducts = async () => {
    let response = await axios.get('/api/products')
    //console.log('response', response)
    listProducts.value = response.data.products
}
</script>

