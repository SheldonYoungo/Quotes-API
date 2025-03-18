<template>
  <div>
    <h1>Citas</h1>

    <!-- Buscar cita por ID -->
    <div>
      <input v-model="quoteId" type="number" placeholder="Ingrese el ID de la cita" />
      <button @click="fetchQuoteById">Buscar por ID</button>
    </div>

    <!-- Obtener cita aleatoria -->
    <div>
      <button @click="fetchRandomQuote">Obtener cita aleatoria</button>
    </div>

    <!-- Mostrar cita seleccionada -->
    <div v-if="selectedQuote">
      <h2>Cita seleccionada</h2>
      <p>{{ selectedQuote.quote }}</p>
      <p><strong>Autor:</strong> {{ selectedQuote.author }}</p>
    </div>

    <!-- Mostrar todas las citas con paginación -->
    <div>
      <h2>Todas las citas</h2>
      <ul>
        <!-- Accede directamente a data.quotes -->
        <li v-for="quote in quotes.quotes" :key="quote.id">
          <p>{{ quote.quote }}</p>
          <p><strong>Autor:</strong> {{ quote.author }}</p>
          <br>
        </li>
      </ul>

      <!-- Paginación -->
      <div>
        <button @click="prevPage" :disabled="skip === 0">Anterior</button>
        <span>Página {{ currentPage }}</span>
        <button @click="nextPage">Siguiente</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      quotes: [], // Lista de citas paginadas
      selectedQuote: null, // Cita seleccionada (por ID o aleatoria)
      quoteId: null, // ID de la cita a buscar
      skip: 0, // Número de citas a saltar
      limit: 10, // Número de citas por página
      totalQuotes: 0, // Total de citas disponibles
    };
  },
  computed: {
    // Calcular la página actual
    currentPage() {
      return Math.floor(this.skip / this.limit) + 1;
    },
  },
  mounted() {
    // Cargar las citas al montar el componente
    this.fetchQuotes();
  },
  methods: {

    async fetchQuotes() {
      try {
        const response = await axios.get('/api/quote', {
          params: {
            skip: this.skip,
          },
        });
        this.quotes = response.data;
      } catch (error) {
        console.error('Error al obtener las citas:', error);
      }
    },

    async fetchRandomQuote() {
      try {
        const response = await axios.get('/api/quote/random');
        this.selectedQuote = response.data;
      } catch (error) {
        console.error('Error al obtener la cita aleatoria:', error);
      }
    },

    async fetchQuoteById() {
      if (!this.quoteId) return;

      try {
        const response = await axios.get(`/api/quote/${this.quoteId}`);
        this.selectedQuote = response.data;
      } catch (error) {
        console.error('Error al obtener la cita por ID:', error);
        this.selectedQuote = null;
      }
    },

    prevPage() {
      this.skip = Math.max(0, this.skip - this.limit);
      this.fetchQuotes();
    },

    nextPage() {
      this.skip += this.limit;
      this.fetchQuotes();
    },
  },
};
</script>

<style scoped>

ul {
  list-style-type: none;
  padding: 0;
}
li {
  margin-bottom: 20px;
  border-bottom: 1px solid #ccc;
  padding-bottom: 10px;
}
</style>