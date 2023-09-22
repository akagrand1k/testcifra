<template>
      <Navbar />

  <div class="product-table">

    <div class="header-container">
      <product-filter @search="handleSearch"></product-filter>

      <div class="select-container">
        <label for="perPage">Выводить по</label>
        <select id="perPage" v-model="perPage" @change="fetchProducts">
          <option value="5">5</option>
          <option value="10">10</option>
        </select>
      </div>
    </div>
    <table>
      <thead>
        <tr>
          <th @click="toggleSort('id')">
            ID
            <span v-if="sortField === 'id'">{{
              sortDirection === "asc" ? "↑" : "↓"
            }}</span>
          </th>
          <th @click="toggleSort('title')">
            Наименование
            <span v-if="sortField === 'title'">{{
              sortDirection === "asc" ? "↑" : "↓"
            }}</span>
          </th>
          <th @click="toggleSort('price')">
            Цена
            <span v-if="sortField === 'price'">{{
              sortDirection === "asc" ? "↑" : "↓"
            }}</span>
          </th>
          <th @click="toggleSort('quantity')">
            Количество
            <span v-if="sortField === 'quantity'">{{
              sortDirection === "asc" ? "↑" : "↓"
            }}</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.title }}</td>
          <td>{{ product.price }}</td>
          <td>{{ product.quantity }}</td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button @click="previousPage" :disabled="currentPage <= 1">Назад</button>
      <button @click="nextPage" :disabled="currentPage >= maxPage">
        Вперед
      </button>
    </div>
  </div>
</template>


<script>
import ProductFilter from "./ProductFilter.vue";
import api from "@/api";
import Navbar from "@/components/Navbar.vue";

export default {
  components: {
    ProductFilter,
    Navbar
  },
  data() {
    return {
      products: [],
      currentPage: 1,
      perPage: 5,
      totalItems: 0,
      sortDirection: "desc",
      sortField: "id",
    };
  },
  methods: {
    toggleSort(field) {
      this.currentPage = 1;
      if (this.sortField === field) {
        this.sortDirection = this.sortDirection === "asc" ? "desc" : "asc";
      } else {
        this.sortField = field;
        this.sortDirection = "asc";
      }
      this.fetchProducts();
    },
    nextPage() {
      this.currentPage++;
      this.fetchProducts();
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchProducts();
      }
    },
    fetchProducts() {
      const apiUrl = `/products?limit=${this.perPage}&page=${
        this.currentPage
      }&sort=${this.sortField}&direction=${this.sortDirection}&search=${
        this.searchTerm || ""
      }`;

      api
        .get(apiUrl)
        .then((response) => {
          this.products = response.data.data;
          this.totalItems = response.data.total;
        })
        .catch((error) => {
          console.error("Ошибка при получении данных:", error);
          if (error.response && error.response.data) {
            console.error("Ошибка от сервера:", error.response.data.message);
          }
        });
    },
    debounceSearch() {
      clearTimeout(this.searchDebounce);
      this.searchDebounce = setTimeout(() => {
        this.onSearch();
      }, 300);
    },
    async handleSearch(searchTerm) {
      try {
        this.currentPage = 1;
        this.searchTerm = searchTerm;
        const response = await api.get("/products", {
          params: { search: searchTerm, limit: this.perPage },
        });
        this.products = response.data.data;
        this.totalItems = response.data.total;
        this.fetchProducts();
      } catch (error) {
        console.error("Ошибка при выполнении поиска:", error);
      }
    },
    onSearch() {
      this.$emit("search", this.searchTerm);
    },
  },
  mounted() {
    this.fetchProducts();
  },
  watch: {
    perPage(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.currentPage = 1;
      }
    },
  },
  computed: {
    maxPage() {
      return Math.ceil(this.totalItems / this.perPage);
    },
  },
};
</script>

<style scoped>
.product-table {
  margin: 20px auto;
  overflow-x: auto;
  border: 1px solid #e0e0e0;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.1);
  overflow-y: hidden;
  overflow-x: hidden;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th,
td {
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
}

th {
  background-color: #f5f5f5;
  text-align: left;
}

.pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  gap: 10px;
}

button {
  padding: 6px 12px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  transition: background-color 0.2s ease;
}

button:hover {
  background-color: #0056b3;
  cursor: pointer;
}

button:disabled {
  background-color: #c0c0c0;
  cursor: not-allowed;
}

label {
  margin-right: 10px;
}
.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.select-container {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

select {
  width: 100%;
  margin-top: 8px;
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

.add-product-button {
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border-radius: 4px;
  text-decoration: none;
}

.add-product-button:hover {
  background-color: #0056b3;
}
</style>
