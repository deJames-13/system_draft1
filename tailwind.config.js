/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './components/*.{html,js,php}',
    './account/*.{html,js,php}',
    './admin/**/*.{html,js,php}',
    './home/*.{html,js,php}',
    './shop/*.{html,js,php}',
  ],
  screens: {
    sm: '480px',
    md: '768px',
    lg: '976px',
    xl: '1440px',
  },
  theme: {
    extend: {
      fontFamily: {
        sans: ['Lexend', 'sans-serif'],
      },
      colors: {
        primary: '#46FBAD',
        primary50: '#A3FDD6',
        primary30: '#C7FEE6', //ECFFF7
        primary10: '#ECFFF7', //ECFFF7
        secondary: '#FF8E52',
        secondary75: '#FFAA7D',
        secondary50: '#FFC7A8',
        secondary30: '#FFDDCB',
        accent: '#0B292D',
        accent50: '#859496',
        accent30: '#B6BFC0',
      },
    },
  },
  plugins: [],
};
