<template>
    <transition name="fade">
      <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-gray-800 rounded-lg p-6 w-11/12 md:w-1/2 lg:w-1/3">
          <div class="text-white">
            <p>{{ message }}</p>
          </div>
          <div class="mt-4 text-right">
            <button
              @click="closeModal"
              class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </transition>
  </template>
  
  <script>
  export default {
    props: {
      isOpen: {
        type: Boolean,
        required: true,
      },
      message: {
        type: String,
        required: true,
      },
    },
    methods: {
      closeModal() {
        this.$emit("close"); // Emitir evento para cerrar el modal
      },
    },
  };
  </script>
  
  <style scoped>
  /* Animación de desvanecimiento */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s;
  }
  
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>