<template>
  <div class="login-container">
    <div class="login-form-wrapper">
      <h2>Вход</h2>
      <ErrorNotification :message="errorMessage" />

      <form @submit.prevent="handleLogin" class="login-form">
        <div class="input-wrapper">
          <input v-model="loginData.email" type="email" placeholder="Email" />
          <div class="error-message" v-if="emailError">{{ emailError }}</div>
        </div>

        <div class="input-wrapper">
          <input
            v-model="loginData.password"
            type="password"
            placeholder="Password"
          />
          <div class="error-message" v-if="passwordError">
            {{ passwordError }}
          </div>
        </div>

        <div class="submit-wrapper">
          <button type="submit">Войти</button>
          <div class="register-link">
            Нет аккаунта?
            <router-link to="/register">Зарегистрируйтесь</router-link>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

  <script>
import api from "@/api";
import ErrorNotification from "@/components/ErrorNotification.vue";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
  components: {
    ErrorNotification,
  },
  setup() {
    const loginData = ref({
      email: "",
      password: "",
    });

    const emailError = ref("");
    const passwordError = ref("");
    const errorMessage = ref("");
    const router = useRouter();
    const handleLogin = async () => {
      if (!validateForm()) {
        return;
      }

      try {
        let response = await api.post("/login", loginData.value);

        console.log(response);
        if (response.data && response.data.access_token) {
          localStorage.setItem("authToken", response.data.access_token);
        }

        router.push({ name: "Product" });
      } catch (error) {
        console.log(error);
        if (error.response && error.response.data) {
          if (error.response.data.message === "Неверный email или пароль") {
            errorMessage.value = "Неверный email или пароль";
          } else {
            errorMessage.value =
              error.response.data.message || "Произошла ошибка.";
          }
        } else {
          errorMessage.value = "Произошла ошибка при обращении к серверу.";
        }

        if (error.response && error.response.data) {
          errorMessage.value =
            error.response.data.message || "Произошла ошибка.";
        } else {
          errorMessage.value = "Произошла ошибка при обращении к серверу.";
        }
      }
    };

    const validateForm = () => {
      let isValid = true;

      if (!loginData.value.email) {
        emailError.value = "Email обязателен.";
        isValid = false;
      } else {
        emailError.value = "";
      }

      if (!loginData.value.password) {
        passwordError.value = "Пароль обязателен.";
        isValid = false;
      } else {
        passwordError.value = "";
      }

      return isValid;
    };

    return {
      loginData,
      errorMessage,
      handleLogin,
      emailError,
      passwordError,
    };
  },
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f7f7f7;
}

.login-form-wrapper {
  background-color: #ffffff;
  padding: 40px 60px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

h2 {
  text-align: center;
  margin-bottom: 30px;
}

.login-form .input-wrapper {
  margin-bottom: 20px;
}

input {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #e0e0e0;
  border-radius: 5px;
  font-size: 14px;
}

button {
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.2s;
}

button:hover {
  background-color: #0056b3;
}
.register-link {
  margin-top: 9px;
  text-align: center;
  text-align: center;
  margin-left: 20px;
}

.submit-wrapper {
  display: flex;
}
router-link {
  color: #007bff;
  text-decoration: none;
  transition: color 0.2s;
}

router-link:hover {
  color: #0056b3;
}

.error-message {
  color: #e3342f;
  font-size: 12px;
  margin-top: 5px;
}
</style>
