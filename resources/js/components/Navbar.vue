<template>
  <nav class="navbar">
    <router-link class="navbar-item" to="/">Главная</router-link>
    <button class="navbar-button" @click="logout">Выход</button>
  </nav>
</template>


  <script>
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
  setup() {
    const router = useRouter();

    function logout() {
      localStorage.removeItem("authToken");
      router.push({ name: "Login" });
    }

    const isAuthenticated = ref(checkAuthentication());

    function checkAuthentication() {
      return !!localStorage.getItem("authToken");
    }

    return {
      isAuthenticated,
      logout,
    };
  },
};
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f5f5f5;
  padding: 10px 20px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar-item {
  margin: 0 10px;
  color: #333;
  text-decoration: none;
  transition: color 0.3s;
}

.navbar-item:hover {
  color: #007bff;
}

.navbar-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.navbar-button:hover {
  background-color: #0056b3;
}
</style>
