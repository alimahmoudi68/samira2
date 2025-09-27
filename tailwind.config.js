const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  content:  [
    "./**/*.{php,js}"],
    theme: {
      screens: {
        'xxxsm': '380px',
        'xxsm': '450px',
        'xsm': '550px' ,
        ...defaultTheme.screens
    },
      extend: {
        colors: {
          primary: {
            100: 'rgba(216, 146, 22, 1)',
            50: 'rgba(216, 146, 22, 0.5)',
            30: 'rgba(216, 146, 22, 0.3)'
          },
          textPrimary: {
            100: 'rgba(23, 23, 23, 1)'
          },
          white: {
            50: 'rgba(252, 255, 255, 0.8)',
            70: 'rgba(252, 255, 255, 0.7)',
            100: 'rgba(252, 255, 255, 1)'
          },
          black: {
            20: 'rgba(0, 0, 0, 0.2)',
            70: 'rgba(0, 0, 0, 0.7)',
            100: 'rgba(0, 0, 0, 1)'
          },
          border: {
            100: 'rgba(28, 29, 34, 1)'
          },
          background: {
            100: 'rgba(244, 246, 248, 1)'
          },
          modalBackground: {
            100: 'rgb(30, 41, 59 ,0.7)'
          },
          darkBack: {
            100: 'rgba(34, 40, 49, 1)',
          },
          darkCard: {
            100: 'rgba(49, 54, 63, 1)',
          },
          loadingDark: {
            100: 'rgb(51, 65, 85 , 0.7)'
          },
          backgroundInput: {
            100: 'rgba(236, 240, 241, 1)'
          },
          loadingCourses : {
            100: 'rgba(252, 66, 123, 0.2)'
          }
        },
        width: {
          'auto': 'auto',
          'fit': 'fit-content',
          'max': 'max-content',
          'full-260': 'calc(100% - 260px )',
          'full-78': 'calc(100% - 78px )',
        },
        height: {
          'auto': 'auto',
          'fit': 'fit-content',
        },
        zIndex: {
          '60': '60',
          '70': '70',
        },
        fontFamily: {
          dana: ['Dana'],
        },
        keyframes: {
          'fade-in': {
            '0%': { opacity: '0' },
            '100%': { opacity: '1' }
          },
          'zoomIn': {
            '0%': {
              opacity: '0',
              transform: 'scale3d(.3, .3, .3)',
            },
            '100%': {
              opacity: '1',
              transform: 'scale3d(1, 1 , 1)',
            }
          },
          'zoomInRtate': {
            '0%': {
              opacity: '0',
              transform: 'scale3d(.3, .3, .3)',
            },
            '100%': {
              opacity: '1',
              transform: 'scale3d(1, 1 , 1)',
              rotate: '140deg'
            }
          },
          'moveLeft': {
            '0%': {
              opacity : '0' ,
              transform: 'translateX(40px)',
            },
            '50%': {
              opacity : '0.5',
            },
            '100%': {
              opacity: '1',
              transform: 'translateX(0px)',
            }
          },
          'shake1': {
            '0%': {
              rotate: '0deg'
            },
            '40%': {
              rotate: '-20deg'
            },
            '80%': {
              rotate: '20deg'
            },
            '100%': {
              rotate: '0deg'
            }
          },
          'my-ping-key' :{
            '0%' :  
            {
                scale : '1',
                opacity: 100,
            },
            '50%' : {
                scale : '5',
                opacity: 0,
            },
            '100%' : {
                scale : '1',
                opacity: 0,
            }
          },
          loading : {
            "0%": {  transform: 'rotate(0deg)' },
            "100%": { transform: 'rotate(360deg)'},
          },
        },
        animation: {
          'fade-in': 'fade-in 0.2s ease-in',
          'zoom-in': 'zoomIn 0.2s ease-in' ,
          'move-left-1s' : 'moveLeft 0.5s linear 1s forwards',
          'move-left-2s' : 'moveLeft 0.5s linear 2s forwards',
          'move-left-3s' : 'moveLeft 0.5s linear 3s forwards',
          'zoom-in-rotate-4s' :'zoomInRtate 0.7s linear 4s forwards',
          'zoom-in-3s': 'zoomIn 0.7s linear 3s forwards' ,
          'shake1': 'shake1 4s infinite linear' ,
          'my-ping' : 'my-ping-key 2s ease-in infinite' ,
          "loading": "loading 1s linear infinite",
        },
        boxShadow: {
          'top-header': 'rgba(33, 35, 38, 0.1) 0px 10px 10px -10px',
          'top-header-dark': 'rgba(213 , 220 ,229, 0.3) 0px 10px 10px -10px',
          'footer': 'rgba(33, 35, 38, 0.1)  0px 19px 22px 20px',
          'footer-dark': 'rgba(213 , 220 ,229, 0.3)  0px 19px 22px 20px',
          'side-header': 'rgba(213 , 220 ,229, 0.3) 0px 10px 10px 4px',
          'side-header-dark': 'rgba(213 , 220 ,229, 0.3) 0px 10px 10px 4px',
          'card': 'rgba(17, 17, 26, 0.1) 0px 0px 16px',
          'loading' : "0 -5px 5px rgba(168, 127, 13, 0.3)" ,
        }
      },
    },
  plugins: [],
}
