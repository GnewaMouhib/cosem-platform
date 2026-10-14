/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                forest: {
                    50: '#F0FDF4',
                    500: '#22C55E',
                    600: '#15803D',
                    700: '#166534',
                    800: '#14532D',
                    900: '#052E16',
                },
                harvest: {
                    50: '#FEFCE8',
                    200: '#FEF08A',
                    400: '#EAB308',
                    500: '#CA8A04',
                    600: '#A16207',
                    700: '#854D0E',
                },
                ink: '#0F172A',
            },
            fontFamily: {
                display: ['"Playfair Display"', 'serif'],
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.55s ease-out both',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            boxShadow: {
                'soft': '0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 6px 20px -6px rgba(15, 23, 42, 0.08)',
                'lift': '0 8px 30px -8px rgba(15, 23, 42, 0.12)',
            },
        },
    },
    plugins: [],
};
