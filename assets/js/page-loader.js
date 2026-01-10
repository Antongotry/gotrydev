/**
 * Preloader - Карточки разлетаются на свои реальные позиции
 */

(function() {
    'use strict';
    
    const preloader = document.getElementById('preloader');
    const mainGrid = document.getElementById('main-grid');
    
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
    
    const preloaderCards = document.querySelectorAll('.preloader-card');
    const cardsStack = document.getElementById('preloader-cards-stack');
    let projectCards = [];
    let isInitialized = false;
    
    // Функция для скрытия прелоадера и показа контента
    function hidePreloader() {
        projectCards = document.querySelectorAll('.projects-grid .project-card');
        
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
    
    // Функция для расчета позиций карточек из реального DOM
    function calculateCardPositions() {
        if (!cardsStack || preloaderCards.length === 0) {
            return false;
        }
        
        // Ищем реальные карточки проектов
        projectCards = document.querySelectorAll('.projects-grid .project-card');
        
        if (projectCards.length === 0) {
            console.log('Preloader: Project cards not found yet');
            return false;
        }
        
        // Ждем, пока layout будет готов
        requestAnimationFrame(() => {
            const stackRect = cardsStack.getBoundingClientRect();
            const stackCenterX = stackRect.left + stackRect.width / 2;
            const stackCenterY = stackRect.top + stackRect.height / 2;
            
            // Временно показываем карточки проектов для расчета позиций
            projectCards.forEach((card) => {
                const originalStyle = {
                    opacity: card.style.opacity,
                    visibility: card.style.visibility,
                    display: card.style.display
                };
                card.style.opacity = '0';
                card.style.visibility = 'visible';
                card.style.display = ''; // Убираем display: none если есть
            });
            
            // Ждем рефлоу
            requestAnimationFrame(() => {
                preloaderCards.forEach((preloaderCard, index) => {
                    if (projectCards[index]) {
                        const cardRect = projectCards[index].getBoundingClientRect();
                        
                        // Проверяем, что позиция валидна
                        if (cardRect.width > 0 && cardRect.height > 0) {
                            const cardCenterX = cardRect.left + cardRect.width / 2;
                            const cardCenterY = cardRect.top + cardRect.height / 2;
                            
                            // Вычисляем смещение от центра стека к центру карточки
                            const offsetX = cardCenterX - stackCenterX;
                            const offsetY = cardCenterY - stackCenterY;
                            
                            console.log(`Preloader: Card ${index} position:`, {
                                cardCenter: { x: cardCenterX, y: cardCenterY },
                                stackCenter: { x: stackCenterX, y: stackCenterY },
                                offset: { x: offsetX, y: offsetY }
                            });
                            
                            // Обновляем CSS переменные для позиционирования
                            preloaderCard.style.setProperty('--final-x', offsetX + 'px');
                            preloaderCard.style.setProperty('--final-y', offsetY + 'px');
                        }
                    }
                });
                
                // Снова скрываем карточки проектов
                projectCards.forEach((card) => {
                    card.style.opacity = '0';
                    card.style.visibility = 'hidden';
                });
            });
        });
        
        return true;
    }
    
    // Функция для запуска анимации разлета
    function startSpreadAnimation() {
        if (preloaderCards.length === 0) {
            hidePreloader();
            return;
        }
        
        console.log('Preloader: Starting spread animation');
        
        // Добавляем класс spreading для анимации
        preloaderCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('spreading');
            }, index * 100); // Каскадный эффект
        });
        
        // Скрываем прелоадер после завершения анимации
        setTimeout(() => {
            hidePreloader();
        }, 2000); // 1.5 сек анимация + 0.5 сек запас
    }
    
    // Функция инициализации
    function initPreloader() {
        if (isInitialized) return;
        isInitialized = true;
        
        console.log('Preloader: Initializing...');
        
        // Пытаемся рассчитать позиции сразу
        let positionsCalculated = calculateCardPositions();
        
        // Если позиции не рассчитаны, пробуем еще раз через небольшую задержку
        if (!positionsCalculated) {
            setTimeout(() => {
                positionsCalculated = calculateCardPositions();
                
                // Если все еще не получилось, используем fallback
                if (!positionsCalculated) {
                    console.log('Preloader: Using fallback positions');
                    // Fallback позиции
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
                }
                
                // Запускаем анимацию через 0.8 секунды после загрузки
                setTimeout(() => {
                    startSpreadAnimation();
                }, 800);
            }, 300);
        } else {
            // Если позиции рассчитаны, запускаем анимацию
            setTimeout(() => {
                startSpreadAnimation();
            }, 1000);
        }
        
        // Гарантированно скрываем прелоадер максимум через 3 секунды
        setTimeout(() => {
            if (!document.body.classList.contains('preloader-complete')) {
                console.log('Preloader: Force hiding after timeout');
                hidePreloader();
            }
        }, 3000);
    }
    
    // Запускаем инициализацию
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initPreloader, 200);
        });
    } else {
        setTimeout(initPreloader, 200);
    }
    
    // Также пробуем после полной загрузки страницы
    window.addEventListener('load', () => {
        if (!isInitialized) {
            setTimeout(initPreloader, 100);
        } else {
            // Пересчитываем позиции на случай, если они изменились
            calculateCardPositions();
        }
    });
    
})();
