<template>
  <div class="product-filter">
    <div class="search-container">
      <input
        type="text"
        v-model="searchTerm"
        @input="debounceSearch"
        placeholder="Поиск по продуктам..."
        class="search-input"
      />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: "",
      searchDebounce: null,
    };
  },
  methods: {
    debounceSearch() {
      clearTimeout(this.searchDebounce);
      this.searchDebounce = setTimeout(() => {
        this.onSearch();
      }, 300);
    },
    onSearch() {
      this.$emit("search", this.searchTerm);
    },
  },
};
</script>

<style scoped>
.product-filter {
  width: 100%;
  margin-top: auto;
  max-width: 400px;
  position: relative;
}

.search-container {
  position: relative;
}

.search-input {
  width: 100%;
  padding: 8px 12px;
  padding-right: 35px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.3s;
}

.search-input:focus {
  border-color: #007bff;
  outline: none;
}

.search-icon {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  font-size: 16px;
  cursor: pointer;
}
</style>
