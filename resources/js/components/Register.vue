<template>
  <div class="register-container">
    <ErrorNotification :message="errorMessage" :errors="errors" />

    <form @submit.prevent="handleRegister" class="register-form">
      <input
        class="input-field"
        v-model="registerData.name"
        type="text"
        placeholder="Имя"
        @blur="validateName"
      />
      <div v-if="validationErrors.name" class="error-message">
        {{ validationErrors.name }}
      </div>
      <input
        class="input-field"
        v-model="registerData.email"
        type="email"
        placeholder="Email"
        @blur="validateEmail"
      />
      <div v-if="validationErrors.email" class="error-message">
        {{ validationErrors.email }}
      </div>

      <input
        class="input-field"
        v-model="registerData.password"
        type="password"
        placeholder="Пароль"
        @blur="validatePassword"
      />
      <div v-if="validationErrors.password" class="error-message">
        {{ validationErrors.password }}
      </div>

      <button type="submit" class="submit-button">Регистрироваться</button>
    </form>
  </div>
</template>

<script>
import api from "@/api";
import ErrorNotification from "@/components/ErrorNotification.vue";

export default {
  components: {
    ErrorNotification,
  },
  data() {
    return {
      registerData: {
        name: "",
        email: "",
        password: "",
      },
      validationErrors: {
        name: null,
        email: null,
        password: null,
      },
      errorMessage: "",
      errors: [],
    };
  },
  methods: {
    validateName() {
      if (!this.registerData.name) {
        this.validationErrors.name = "Имя обязательно";
      } else {
        this.validationErrors.name = null;
      }
    },
    validateEmail() {
      const pattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
      if (!this.registerData.email) {
        this.validationErrors.email = "Email обязателен";
      } else if (!pattern.test(this.registerData.email)) {
        this.validationErrors.email = "Неверный формат email";
      } else {
        this.validationErrors.email = null;
      }
    },
    validatePassword() {
      if (!this.registerData.password) {
        this.validationErrors.password = "Пароль обязателен";
      } else if (this.registerData.password.length < 6) {
        this.validationErrors.password =
          "Пароль должен содержать не меньше 6 символов";
      } else {
        this.validationErrors.password = null;
      }
    },
    async handleRegister() {
      try {
        this.validateName();
        this.validateEmail();
        this.validatePassword();

        if (Object.values(this.validationErrors).every((x) => !x)) {
          let response = await api.post("/register", this.registerData);

          if (response.data && response.data.access_token) {
            console.log(response.data);

            localStorage.setItem("authToken", response.data.access_token);
            this.$router.push({ name: "Product" });
          }
        }
      } catch (error) {
        console.log(error);
        if (error.response && error.response.data) {
          this.errorMessage =
            error.response.data.message || "Произошла ошибка.";
          this.errors = error.response.data.errors;
        } else {
          this.errorMessage = "Произошла ошибка при обращении к серверу.";
        }
      }
    },
  },
};
</script>

<style scoped>
.register-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 40px;
  border-radius: 8px;
}

.register-form {
  display: flex;
  flex-direction: column;
  width: 300px;
  gap: 20px;
}

.input-field {
  padding: 12px 15px;
  border-radius: 4px;
  border: 1px solid #ccc;
  outline: none;
  transition: border-color 0.3s;

  &:focus {
    border-color: #007bff;
  }
}

.submit-button {
  padding: 12px 15px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;

  &:hover {
    background-color: #0056b3;
  }
}

.error-message {
  color: #e3342f;
  font-size: 12px;
  margin-top: 4px;
}
</style>
