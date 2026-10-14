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
                    100: '#DCFCE7',
                    200: '#BBF7D0',
                    300: '#86EFAC',
                    400: '#4ADE80',
                    500: '#22C55E',
                    600: '#15803D',
                    700: '#166534',
                    800: '#14532D',
                    900: '#052E16',
                    DEFAULT: '#166534',
                },
                harvest: {
                    50: '#FEFCE8',
                    100: '#FEF9C3',
                    200: '#FEF08A',
                    300: '#FDE047',
                    400: '#EAB308',
                    500: '#CA8A04',
                    600: '#A16207',
                    700: '#854D0E',
                    800: '#713F12',
                    900: '#422006',
                    DEFAULT: '#CA8A04',
                },
                ink: '#0F172A',
            },
            fontFamily: {
                display: ['"Playfair Display"', 'serif'],
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.55s ease-out both',
                'fade-in': 'fadeIn 0.7s ease-out both',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
            boxShadow: {
                'soft': '0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 6px 20px -6px rgba(15, 23, 42, 0.08)',
                'lift': '0 8px 30px -8px rgba(15, 23, 42, 0.12)',
                'gold': '0 6px 24px -6px rgba(202, 138, 4, 0.4)',
            },
        },
    },
    plugins: [],
};
