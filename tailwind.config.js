/** @type {import('tailwindcss').Config} */

export default {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",

      './vendor/robsontenorio/mary/src/View/Components/**/*.php',

      './resources/views/filament/**/*.blade.php',
      './vendor/filament/**/*.blade.php',
      'App/Filament/**/*.php',
      './vendor/filament/**/*.blade.php'
  ],
  theme: {
    extend: {},
  },
  plugins: [
      require('daisyui'),
  ],
}

