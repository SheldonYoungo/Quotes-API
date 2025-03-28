import { ref, computed } from "vue";
import axios from "axios";

export function useQuotes() {
  const quotes = ref([]); // Lista de citas paginadas
  const selectedQuote = ref(null); // Cita seleccionada (por ID o aleatoria)
  const quoteId = ref(null); // ID de la cita a buscar
  const skip = ref(0); // Número de citas a saltar
  const limit = ref(10); // Número de citas por página
  const totalQuotes = ref(0); // Total de citas disponibles
  const errorMessage = ref(""); // Mensaje de error
  const isModalOpen = ref(false); // Estado del modal

  // Calcular la página actual
  const currentPage = computed(() => Math.floor(skip.value / limit.value) + 1);

  // Validar si el ID de la cita es válido
  const isValidQuoteId = computed(() => quoteId.value !== null && quoteId.value >= 1);

  // Cargar las citas
  const fetchQuotes = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/quote", {
        params: {
          skip: skip.value,
        },
      });
      quotes.value = response.data;
    } catch (error) {
      handleError(error);
    }
  };

  // Obtener una cita aleatoria
  const fetchRandomQuote = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/quote/random");
      selectedQuote.value = response.data;
      clearErrorMessage(); 
    } catch (error) {
      handleError(error);
    }
  };

  // Buscar una cita por ID
  const fetchQuoteById = async () => {
    if (!isValidQuoteId.value) {
      setErrorMessage("The ID must be a positive integer.");
      return;
    }

    try {
      const response = await axios.get(`http://localhost:8000/api/quote/${quoteId.value}`);
      if (response.data) {
        selectedQuote.value = response.data;
        clearErrorMessage(); 
      } else {
        selectedQuote.value = null;
        setErrorMessage("Quote not found.");
      }
    } catch (error) {
      handleError(error);
    }
  };

 
  const prevPage = () => {
    skip.value = Math.max(0, skip.value - limit.value);
    fetchQuotes();
  };

 
  const nextPage = () => {
    skip.value += limit.value;
    fetchQuotes();
  };

  // Establecerel mensaje de error y abre el modal
  const setErrorMessage = (message) => {
    errorMessage.value = message;
    isModalOpen.value = true; 
  };

  // Cerrar el modal y limpiar el mensaje de error
  const closeModal = () => {
    isModalOpen.value = false; 
    errorMessage.value = ""; 
  };

  // Manejar errores
  const handleError = (error) => {
    if (error.response && error.response.status === 429) {
      setErrorMessage("You have made too many requests. Please try again later.");
    } else {
      setErrorMessage(error.response.data.error || "There was an error fetching the quotes.");
    }
  };

  return {
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
  };
}