/**
 * Preloader - Карточки как колода с объёмным эффектом
 * Карточки складываются в колоду, затем красиво разлетаются на свои места
 */

(function() {
    'use strict';
    
    const preloader = document.getElementById('preloader');
    const cardsStack = document.getElementById('preloader-cards-stack');
    const preloaderCards = document.querySelectorAll('.preloader-card');
    const mainGrid = document.getElementById('main-grid');
    const projectCards = document.querySelectorAll('.projects-grid .project-card');
    
    if (!preloader || !cardsStack || preloaderCards.length === 0) {
        // Если прелоадера нет, сразу показываем контент
        if (mainGrid) {
            mainGrid.style.opacity = '1';
        }
        if (projectCards.length > 0) {
            projectCards.forEach(card => {
                card.style.opacity = '1';
                card.style.visibility = 'visible';
            });
        }
        return;
    }
    
    // Функция для расчета позиций карточек
    function calculateCardPositions() {
        if (projectCards.length === 0) {
            // Fallback позиции, если основные карточки еще не загружены
            setFallbackPositions();
            return;
        }
        
        // Ждем, пока layout будет готов
        setTimeout(() => {
            const stackRect = cardsStack.getBoundingClientRect();
            const stackCenterX = stackRect.left + stackRect.width / 2;
            const stackCenterY = stackRect.top + stackRect.height / 2;
            
            preloaderCards.forEach((preloaderCard, index) => {
                if (projectCards[index]) {
                    const cardRect = projectCards[index].getBoundingClientRect();
                    const cardCenterX = cardRect.left + cardRect.width / 2;
                    const cardCenterY = cardRect.top + cardRect.height / 2;
                    
                    // Вычисляем смещение от центра стека к центру карточки
                    const offsetX = cardCenterX - stackCenterX;
                    const offsetY = cardCenterY - stackCenterY;
                    
                    // Обновляем CSS переменные для позиционирования
                    preloaderCard.style.setProperty('--final-x', offsetX + 'px');
                    preloaderCard.style.setProperty('--final-y', offsetY + 'px');
                }
            });
        }, 100);
    }
    
    // Fallback позиции
    function setFallbackPositions() {
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        const stackRect = cardsStack.getBoundingClientRect();
        const stackCenterX = stackRect.left + stackRect.width / 2;
        const stackCenterY = stackRect.top + stackRect.height / 2;
        
        // Примерные позиции для 3 карточек в grid
        const cardWidth = 339;
        const cardHeight = 530;
        const gap = 24;
        const totalWidth = (cardWidth * 3) + (gap * 2);
        const startX = viewportWidth / 2 - totalWidth / 2;
        const startY = viewportHeight * 0.6; // Примерная позиция проектов
        
        preloaderCards.forEach((preloaderCard, index) => {
            const cardCenterX = startX + (cardWidth / 2) + (index * (cardWidth + gap));
            const cardCenterY = startY + (cardHeight / 2);
            
            const offsetX = cardCenterX - stackCenterX;
            const offsetY = cardCenterY - stackCenterY;
            
            preloaderCard.style.setProperty('--final-x', offsetX + 'px');
            preloaderCard.style.setProperty('--final-y', offsetY + 'px');
        });
    }
    
    // Функция для раскладывания карточек
    function spreadCards() {
        console.log('Preloader: Spreading cards...');
        
        // Добавляем класс spreading для анимации
        preloaderCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('spreading');
            }, index * 50); // Небольшая задержка для каскадного эффекта
        });
        
        // После завершения анимации, скрываем прелоадер и показываем основной контент
        setTimeout(() => {
            hidePreloader();
        }, 1200);
    }
    
    // Функция для скрытия прелоадера
    function hidePreloader() {
        // Показываем основные карточки проектов
        projectCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.visibility = 'visible';
            }, index * 100);
        });
        
        // Показываем основной контент
        if (mainGrid) {
            mainGrid.style.opacity = '1';
            mainGrid.style.pointerEvents = 'auto';
        }
        
        // Скрываем прелоадер
        preloader.classList.add('fade-out');
        
        // Добавляем класс на body
        document.body.classList.add('preloader-complete');
        
        // Удаляем прелоадер из DOM после анимации
        setTimeout(() => {
            if (preloader.parentNode) {
                preloader.remove();
            }
        }, 600);
    }
    
    // Функция инициализации
    function initPreloader() {
        // Рассчитываем позиции карточек
        calculateCardPositions();
        
        // Небольшая задержка, чтобы карточки были видны как колода
        setTimeout(() => {
            spreadCards();
        }, 500);
    }
    
    // Запускаем прелоадер при загрузке
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initPreloader, 200);
        });
    } else {
        // DOM уже готов
        setTimeout(initPreloader, 200);
    }
    
    // Обновляем позиции при изменении размера окна
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            if (!preloader.classList.contains('fade-out')) {
                calculateCardPositions();
            }
        }, 250);
    });
    
})();
