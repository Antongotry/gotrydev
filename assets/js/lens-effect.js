/**
 * Lens Effect: Code → Visual rendering
 * Курсор миші "рендерить" код у дизайн
 * Інтерактивний ефект для Hero-блока
 */

function initLensEffect() {
    const heroBackground = document.getElementById('heroBackground');
    const heroLens = document.getElementById('heroLens');
    
    if (!heroBackground || !heroLens) {
        console.warn('Lens effect: elements not found');
        return;
    }
    
    // Перевірка на мобільні пристрої (немає курсора)
    const isMobile = 'ontouchstart' in window || window.innerWidth <= 1100;
    
    if (isMobile) {
        // На мобільних відключаємо lens-effect
        heroLens.style.display = 'none';
        heroBackground.style.maskImage = 'none';
        heroBackground.style.webkitMaskImage = 'none';
        return;
    }
    
    // Позиція курсора
    let mouseX = window.innerWidth / 2;
    let mouseY = window.innerHeight / 2;
    let lensX = mouseX;
    let lensY = mouseY;
    
    // Трекінг курсора миші
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });
    
    // Плавна анімація лінзи (requestAnimationFrame для плавності)
    function animateLens() {
        // Easing для плавного руху (зменшуємо швидкість на 10% за кадр)
        lensX += (mouseX - lensX) * 0.1;
        lensY += (mouseY - lensY) * 0.1;
        
        // Позиція лінзи (центруємо через translate)
        heroLens.style.left = lensX + 'px';
        heroLens.style.top = lensY + 'px';
        
        // CSS mask для "рендерингу" коду в дизайн
        // Радіус лінзи: 200px на desktop, менше на tablet
        const lensRadius = window.innerWidth <= 1100 ? 150 : 200;
        const gradientSize = lensRadius * 2;
        
        // Створюємо radial gradient mask
        heroBackground.style.maskImage = 
            `radial-gradient(circle ${lensRadius}px at ${lensX}px ${lensY}px, black 0%, transparent 70%)`;
        heroBackground.style.webkitMaskImage = 
            `radial-gradient(circle ${lensRadius}px at ${lensX}px ${lensY}px, black 0%, transparent 70%)`;
        
        // Оновлюємо opacity lens overlay
        const distanceFromCenter = Math.sqrt(
            Math.pow(lensX - window.innerWidth / 2, 2) + 
            Math.pow(lensY - window.innerHeight / 2, 2)
        );
        const maxDistance = Math.sqrt(
            Math.pow(window.innerWidth / 2, 2) + 
            Math.pow(window.innerHeight / 2, 2)
        );
        const opacity = 1 - (distanceFromCenter / maxDistance) * 0.5;
        heroLens.style.opacity = Math.max(0.3, opacity);
        
        requestAnimationFrame(animateLens);
    }
    
    // Запускаємо анімацію
    animateLens();
    
    // Обробка resize (оновлюємо позицію при зміні розміру вікна)
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            // Перевіряємо чи не стали мобільним пристроєм
            if (window.innerWidth <= 1100) {
                heroLens.style.display = 'none';
                heroBackground.style.maskImage = 'none';
                heroBackground.style.webkitMaskImage = 'none';
            } else {
                heroLens.style.display = 'block';
            }
        }, 250);
    });
}

// Ініціалізація після завантаження DOM
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLensEffect);
} else {
    initLensEffect();
}
