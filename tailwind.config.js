/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./views/**/*.twig'],
  important: true,
  theme: {
    container: {
      center: true,
      padding: {
        DEFAULT: '1rem',
        lg: '0',
      },
    },
    extend: {
      colors: {
        'c-brown': '#D9A464',
        'c-blue': '#3B82F6',
        'c-orange': '#FFBF72',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
}

