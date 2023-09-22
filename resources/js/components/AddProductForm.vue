<template>
    <div class="add-product-form">
      <h3>Добавить продукт</h3>
      <div>
        <label for="productName">Наименование</label>
        <input type="text" v-model="newProduct.title" id="productName">
      </div>
      <div>
        <label for="productPrice">Цена</label>
        <input type="text" v-model="newProduct.price" id="productPrice">
      </div>
      <div>
        <label for="productQuantity">Количество</label>
        <input type="text" v-model="newProduct.quantity" id="productQuantity">
      </div>
      <button @click="submitProduct">Добавить</button>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        newProduct: {
          title: '',
          price: '',
          quantity: ''
        }
      };
    },
    methods: {
      submitProduct() {
        this.$router.push('/products');
      }
    }
  }
  </script>

  <style scoped>
  .add-product-form {
    margin-bottom: 20px;
  }

  label {
    margin-right: 10px;
  }
  </style>
