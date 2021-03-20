import Solution1Component from './vue/components/solution1/Solution1Component.js';
import Solution2Component from './vue/components/solution2/Solution2Component.js';

const App = {
    el: 'main',

    components: {
        'solution1': Solution1Component,
        'solution2': Solution2Component
    },

    mounted() {
        console.log('Application mounted.')
    }
}

window.addEventListener('load', () => {
    new Vue(App)
})