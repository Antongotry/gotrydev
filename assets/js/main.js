/**
 * Main JavaScript for Gotry theme
 * Ініціалізація Lenis smooth scroll та інших функцій
 */

// Initialize Lenis smooth scroll
(function() {
    let lenis = null;
    
    function initLenis() {
        if (typeof Lenis === 'undefined') {
            setTimeout(initLenis, 200);
            return;
        }
        
        if (lenis) return; // Вже ініціалізований
        
        lenis = new Lenis({
            autoRaf: true,
            lerp: 0.08, // Плавність прокрутки (0.1 = швидше, 0.05 = повільніше)
            smoothWheel: true,
            smoothTouch: true,
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) // Easing функція
        });
        
        // Зберігаємо в глобальну змінну для доступу з інших функцій
        window.lenis = lenis;
        
        // Animation loop для Lenis
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
        
        console.log('✅ Lenis smooth scroll ініціалізовано');
    }
    
    // Ініціалізація після завантаження DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLenis);
    } else {
        initLenis();
    }
    
    // Fallback: якщо Lenis не завантажився, використовуємо стандартний scroll
    setTimeout(function() {
        if (!lenis && typeof Lenis !== 'undefined') {
            initLenis();
        }
    }, 1000);
})();

// Додаткові функції будуть додані тут
