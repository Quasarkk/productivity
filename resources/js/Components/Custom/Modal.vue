<template>
    <div v-if="isOpen" class="fixed top-0 bg-black/20 w-full h-full justify-center flex backdrop-blur-md overflow-auto">
      <div class="w-full max-w-md p-6 my-8 mx-auto bg-white rounded-lg">
        <header class="flex justify-between items-center mb-4">
          <h2>{{ title }}</h2>
          <button @click="$emit('close')">✖️</button>
        </header>
        <section>
          <!-- Utilise un slot pour le contenu -->
          <slot></slot>
        </section>
        <footer class="flex justify-end mt-4">
          <!-- Utilise un slot pour les actions, ou des props/events -->
          <slot name="footer"></slot>
        </footer>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      isOpen: Boolean,
      title: String,
    }
  };
  </script>
