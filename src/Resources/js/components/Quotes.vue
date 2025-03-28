<template>
  <div class="min-h-screen bg-gray-900 text-white p-6">
    <!-- Título -->
    <h1 class="text-center text-8xl font-bold my-8 text-purple-400">Quote API</h1>

    <!-- Buscar cita por ID -->
    <div class="mb-8">
      <input
        v-model="quoteId"
        type="number"
        placeholder="Enter the quote ID"
        min="1"
        class="w-full p-2 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500"
      />
      <button
        @click="fetchQuoteById"
        class="w-full mt-2 p-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
      >
        Search by ID
      </button>
    </div>

    <!-- Obtener cita aleatoria -->
    <div class="mb-8">
      <button
        @click="fetchRandomQuote"
        class="w-full p-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
      >
        Random Quote
      </button>
    </div>

    <!-- Mostrar cita seleccionada -->
    <div v-if="selectedQuote" class="mb-8 p-6 bg-gray-800 rounded-lg shadow-lg">
      <h2 class="text-2xl font-bold text-purple-400 mb-4">Selected quote</h2>
      <p class="text-gray-200">{{ selectedQuote.quote }}</p>
      <p class="mt-2 text-gray-400"><strong>Autor:</strong> {{ selectedQuote.author }}</p>
    </div>

    <!-- Mostrar todas las citas con paginación -->
    <div>
      <h2 class="text-2xl font-bold text-purple-400 mb-4">All quotes</h2>
      <ul class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <li
          v-for="quote in quotes.quotes"
          :key="quote.id"
          class="p-6 bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
        >
          <p class="text-gray-200">{{ quote.quote }}</p>
          <p class="mt-2 text-gray-400"><strong>Author:</strong> {{ quote.author }}</p>
        </li>
      </ul>

      <!-- Paginación -->
      <div class="flex justify-center items-center mt-8 space-x-4">
        <button
          @click="prevPage"
          :disabled="skip === 0"
          class="p-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Previous
        </button>
        <span class="text-gray-400">Página {{ currentPage }}</span>
        <button
          @click="nextPage"
          class="p-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
        >
          Next
        </button>
      </div>
    </div>
    <ErrorModal :isOpen="isModalOpen" :message="errorMessage" @close="closeModal" />
  </div>

</template>

<script setup>
import { ref } from "vue";
import ErrorModal from "./ErrorModal.vue";
import { useQuotes } from "./composables/useQuotes";

const {
  quotes,
  selectedQuote,
  quoteId,
  skip,
  limit,
  totalQuotes,
  errorMessage,
  isModalOpen,
  currentPage,
  isValidQuoteId,
  fetchQuotes,
  fetchRandomQuote,
  fetchQuoteById,
  prevPage,
  nextPage,
  setErrorMessage,
  closeModal,
} = useQuotes();


fetchQuotes();
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>