// tailwind.config.js
module.exports = {
  content: [
    './src/**/*.{html,js,php}', // Incluye todos los archivos HTML y JS dentro de la carpeta src
    './index.html' // Incluye el archivo index.html en la raíz del proyecto si lo tienes ahí
  ],
  theme: {
    extend: {
      fontFamily:{
        'roboto': ['Roboto', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
