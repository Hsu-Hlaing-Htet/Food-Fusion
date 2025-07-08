/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./view/**/*.php",      // Corrected glob pattern for PHP files
    "./layouts/**/*.php",   // Corrected glob pattern for PHP files
    "./admin/**/*.php",     // Corrected glob pattern for PHP files
    "./assets/**/*.php"     // Corrected glob pattern for PHP files
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
