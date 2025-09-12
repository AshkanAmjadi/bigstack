/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./resources/html/*.html",
        "./resources/**/*.blade.php",
        "./resources/*.js",
        "./Modules/*/resources/**/*.blade.php",
    ],
    theme: {
        container: {
            center: true,
        },
        screens: {

            '3xl': {'max': '1780px'},
            // => @media (max-width: 1780px) { ... }

            '2xl': {'max': '1535px'},
            // => @media (max-width: 1535px) { ... }

            '1.5xl': {'max': '1445px'},
            // => @media (max-width: 1535px) { ... }

            'xl': {'max': '1285px'},
            // => @media (max-width: 1279px) { ... }

            'lg': {'max': '1023px'},
            // => @media (max-width: 1023px) { ... }

            'md': {'max': '767px'},
            // => @media (max-width: 767px) { ... }

            'sm': {'max': '639px'},
            // => @media (max-width: 639px) { ... }

            'fsm': {'max': '425px'},
            // => @media (max-width: 425px) { ... }

            'xsm': {'max': '375px'},
            // => @media (max-width: 425px) { ... }

            '3xl-r': {'min': '1780px'},
            // => @media (max-width: 1780px) { ... }

            '2xl-r': {'min': '1535px'},
            // => @media (max-width: 1535px) { ... }

            'xl-r': {'min': '1285px'},
            // => @media (max-width: 1279px) { ... }

            'lg-r': {'min': '1023px'},
            // => @media (max-width: 1023px) { ... }

            'md-r': {'min': '767px'},
            // => @media (max-width: 767px) { ... }

            'sm-r': {'min': '639px'},
            // => @media (max-width: 639px) { ... }

            'fsm-r': {'min': '425px'},
            // => @media (max-width: 425px) { ... }

            'xsm-r': {'min': '375px'},
            // => @media (max-width: 425px) { ... }

        },
        fontSize: {
            extr: 'calc(1.2vw + 14pt)',
            sextr: 'calc(.9vw + 14pt)',
            nextr: 'calc(.6vw + 14pt)',
            felg: 'calc(.4vw + 13pt)',
            elg: 'calc(.4vw + 12pt)',
            flg: 'calc(.4vw + 11pt)',
            lg: 'calc(.4vw + 10pt)',
            mid: 'calc(.4vw + 9pt)',
            nmid: 'calc(.4vw + 8.5pt)',
            nsmid: 'calc(.3vw + 8.5pt)',
            smid: 'calc(.3vw + 8pt)',
            sm: 'calc(.2vw + 8pt)',
            nsm: 'calc(.2vw + 7.5pt)',
            fsm: 'calc(.2vw + 7pt)',
            fnsm: 'calc(.2vw + 6.5pt)',
            fnesm: 'calc(.2vw + 6pt)',
            esm: 'calc(.2vw + 5.5pt)',
            fesm: 'calc(.2vw + 4.5pt)'
        },
        extend: {
            zIndex: {
                '65': '65',
                '70': '70',
                '75': '75',
                '80': '80',
                '85': '85',
            },
            colors: {
                brown: {
                    50: '#fdf8f6',
                    100: '#f2e8e5',
                    200: '#eaddd7',
                    300: '#e0cec7',
                    400: '#d2bab0',
                    500: '#bfa094',
                    600: '#a18072',
                    700: '#977669',
                    800: '#846358',
                    900: '#43302b',
                },

            },
            fontFamily : {
                YekanBakh : ['YekanBakh']
            },
            width:{
                '96p':'96%',
                '90p':'90%',
                '100':'25rem',
                '200':'50rem',
                '300':'75rem',
                '5.5':'22px',
                '4.5':'18px',
            },
            height:{
                '5.5':'22px',
                '4.5':'18px',
                '0p':'0px',
            },
            padding:{
                '0.75':'3px',

            },
            translate: {
                '1/2-': '-50%',
            },
            spacing : {
                'full-plus-2' : 'calc(100% + 0.5rem)',
                'full-plus-4' : 'calc(100% + 1rem)',
                'full-smaler-2' : 'calc(100% - 0.5rem)',
                'full-smaler-4' : 'calc(100% - 1rem)',
                'full-plus-1' : 'calc(100% + 0.25rem)',
                'full-smaler-1' : 'calc(100% - 0.25rem)',
            }
        },
    },
    plugins: [],
}

