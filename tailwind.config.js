/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.{vue,js,ts,jsx,tsx}', // Inclui arquivos Vue e JS
    './resources/views/**/*.blade.php', // Inclui arquivos Blade
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};