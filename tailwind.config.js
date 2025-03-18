/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
      "./resources/**/*.blade.php", // Escanea archivos de Blade
      "./resources/**/*.js",        // Escanea archivos de JavaScript
      "./resources/**/*.vue",       // Escanea archivos de Vue
    ],
    theme: {
      extend: {},
    },
    plugins: [],
  };