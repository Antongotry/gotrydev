/**
 * Preloader - Простой и надежный
 */

(function() {
    'use strict';
    
    const preloader = document.getElementById('preloader');
    const mainGrid = document.getElementById('main-grid');
    const projectCards = document.querySelectorAll('.projects-grid .project-card');
    
    if (!preloader) {
        // Если прелоадера нет, сразу показываем контент
        if (mainGrid) {
            mainGrid.style.opacity = '1';
            mainGrid.style.pointerEvents = 'auto';
            mainGrid.style.visibility = 'visible';
        }
        document.body.classList.add('preloader-complete');
        return;
    }
    
    // Функция для скрытия прелоадера и показа контента
    function hidePreloader() {
        // Показываем основные карточки проектов
        projectCards.forEach((card) => {
            card.style.opacity = '1';
            card.style.visibility = 'visible';
        });
        
        // Показываем основной контент
        if (mainGrid) {
            mainGrid.style.opacity = '1';
            mainGrid.style.pointerEvents = 'auto';
            mainGrid.style.visibility = 'visible';
        }
        
        // Скрываем прелоадер
        preloader.classList.add('fade-out');
        document.body.classList.add('preloader-complete');
        
        // Удаляем прелоадер из DOM
        setTimeout(() => {
            if (preloader && preloader.parentNode) {
                preloader.remove();
            }
        }, 600);
    }
    
    // Анимация карточек
    const preloaderCards = document.querySelectorAll('.preloader-card');
    const cardsStack = document.getElementById('preloader-cards-stack');
    
    if (cardsStack && preloaderCards.length > 0) {
        // Рассчитываем позиции
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        const stackRect = cardsStack.getBoundingClientRect();
        const stackCenterX = stackRect.left + stackRect.width / 2;
        const stackCenterY = stackRect.top + stackRect.height / 2;
        
        const cardWidth = 339;
        const cardHeight = 530;
        const gap = 24;
        const totalWidth = (cardWidth * 3) + (gap * 2);
        const startX = viewportWidth / 2 - totalWidth / 2;
        const startY = viewportHeight * 0.6;
        
        preloaderCards.forEach((preloaderCard, index) => {
            const cardCenterX = startX + (cardWidth / 2) + (index * (cardWidth + gap));
            const cardCenterY = startY + (cardHeight / 2);
            
            const offsetX = cardCenterX - stackCenterX;
            const offsetY = cardCenterY - stackCenterY;
            
            preloaderCard.style.setProperty('--final-x', offsetX + 'px');
            preloaderCard.style.setProperty('--final-y', offsetY + 'px');
        });
        
        // Запускаем анимацию разлета через 0.8 секунды
        setTimeout(() => {
            preloaderCards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('spreading');
                }, index * 100);
            });
        }, 800);
    }
    
    // Гарантированно скрываем прелоадер максимум через 2 секунды
    const hideTimeout = setTimeout(() => {
        hidePreloader();
    }, 2000);
    
    // Также скрываем после завершения анимации
    setTimeout(() => {
        clearTimeout(hideTimeout);
        hidePreloader();
    }, 2500);
    
    // Если страница уже загружена, скрываем быстрее
    if (document.readyState === 'complete') {
        setTimeout(() => {
            clearTimeout(hideTimeout);
            hidePreloader();
        }, 1500);
    } else {
        window.addEventListener('load', () => {
            setTimeout(() => {
                clearTimeout(hideTimeout);
                hidePreloader();
            }, 1500);
        });
    }
    
})();
