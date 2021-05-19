module.exports = {
  purge: ['./javascript/html/index.html', './javascript/**/*.{vue,js}'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#fdf8f8',
          100: '#fbf1f1',
          200: '#f6dcdc',
          300: '#f0c7c7',
          400: '#e49d9d',
          500: '#d97373',
          600: '#c36868',
          700: '#a35656',
          800: '#824545',
          900: '#6a3838',
          DEFAULT: '#d97373',
          dark: '#6a3838',
        },
        secondary: {
          50: '#fbf8f7',
          100: '#f6f0ef',
          200: '#e9dad7',
          300: '#dbc3be',
          400: '#c1978e',
          500: '#a66a5d',
          600: '#955f54',
          700: '#7d5046',
          800: '#644038',
          900: '#51342e',
          DEFAULT: '#a66a5d',
        },
        third: {
          50: '#f4f3f3',
          100: '#e9e7e7',
          200: '#c9c4c4',
          300: '#a8a0a0',
          400: '#675858',
          500: '#261111',
          600: '#220f0f',
          700: '#1d0d0d',
          800: '#170a0a',
          900: '#130808',
          DEFAULT: '#261111',
        },
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
