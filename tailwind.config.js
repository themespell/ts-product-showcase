/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    './src/**/*.jsx',
    './src/**/*.json',
    './templates/**/*.html',
    './includes/templates/**/*.php',
    './parts/**/*.html',
  ],
  theme: {
    screens: {
      'sm': '360px',
      // => @media (min-width: 640px) { ... }

      'md': '768px',
      // => @media (min-width: 768px) { ... }

      'lg': '1024px',
      // => @media (min-width: 1024px) { ... }

      'xl': '1280px',
      // => @media (min-width: 1280px) { ... }

      '2xl': '1536px',
      // => @media (min-width: 1536px) { ... }
    },
    extend: {},
  },
  plugins: [
    require('daisyui'),
  ],
    daisyui: {
        styled: false,      // ✅ Disable DaisyUI default styles
        themes: false,      // ✅ Disable DaisyUI themes
        base: false,        // ✅ Disable DaisyUI base styles
        utils: true,        // ✅ Keep utility classes if you need them
        logs: false,        // Disable logs
    },
}

