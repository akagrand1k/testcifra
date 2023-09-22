<template>
  <div class="error-notification" v-if="message">
    {{ message }}
  </div>
  <div class="error-notification" v-if="errors && errors.email">
    {{ errors.email[0] }}
  </div>
</template>

<script>
export default {
  props: ["message", "errors"],
};
</script>

<style scoped>
.error-notification {
  background-color: #f8d7da;
  border-color: #f5c6cb;
  color: #721c24;
  padding: 0.75rem 1.25rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: 0.25rem;
}
</style>
