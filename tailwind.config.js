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
      fontFamily: {
        sans: ['Montserrat'],
        serif: ['Montserrat'],
        mono: ['Montserrat'],
        display: ['Montserrat'],
        body: ['Montserrat']
      },
      colors: {
        'endless_blue': '#000044',
        'widowmaker': '#99aaff',
        'icy_lilac': '#e6e9f9',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
}

