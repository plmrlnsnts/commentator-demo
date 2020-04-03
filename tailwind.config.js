const { colors } = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      colors: {
        gray: {
          ...colors.gray,
          900: '#1c1e23',
        },
      },
      fontFamily: {
        body: ['Inter', 'sans-serif'],
        mono: ['Fira Mono', 'monospace']
      },
    },
  },
  variants: {},
  plugins: [],
}
