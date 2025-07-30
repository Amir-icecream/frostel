 /** @type {import('tailwindcss').Config} */
 export default {
  content: [
    "./resourse/**/**/*.{html,js,php}",
    "./storage/**/**/*.{html,js,php}",
  ],
  theme: {
    extend: {
      borderWidth:{
        '1' : '1px'
      },
      width:{
        '1/10' : '10%',
        '2/10' : '20%',
        '3/10' : '30%',
        '4/10' : '40%'
      },
      maxWidth:{
        '110' : '60rem',
        '105' : '30rem'
      },
      minWidth:{
        '105' : '30rem'
      },
      maxHeight:{
        '50' : '12.5rem'
      },
      animation:{
        bounce_low : 'bounce 1500ms infinite',
        bounce_mid : 'bounce 1s infinite',
        bounce_hight : 'bounce 500ms infinite',
      },
      height:{
        '11/12' : '91.666667%'
      }
    },
  },
  plugins: [],
}