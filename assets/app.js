import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.querySelectorAll('.card').forEach((card) => {
        const link = card.querySelector('.js-checkout-link');
        const radios = card.querySelectorAll('input[type="radio"]');

        const updateLink = () => {
            const selected = card.querySelector('input[type="radio"]:checked');
            if (!selected || !link) return;
            const separator = link.dataset.baseHref.includes('?') ? '&' : '?';
            link.href = `${link.dataset.baseHref}${separator}period=${encodeURIComponent(selected.value)}`;
        };

        radios.forEach((radio) => radio.addEventListener('change', updateLink));
        updateLink();
    });