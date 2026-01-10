<?php if (!is_front_page()): ?>
<footer class="site-footer">
    <!-- Нічого тут немає -->
</footer>
<?php endif; ?>

<script>
// Konpo-style greeting, menu toggle, and header scroll
document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('top-nav');
    const greetingText = document.getElementById('greeting-text');
    const mainGrid = document.getElementById('main-grid');
    
    // Dynamic greeting based on time of day
    if (greetingText) {
        const hour = new Date().getHours();
        let greeting;
        
        if (hour >= 5 && hour < 12) {
            greeting = 'Доброго ранку!';
        } else if (hour >= 12 && hour < 18) {
            greeting = 'Добрий день!';
        } else if (hour >= 18 && hour < 22) {
            greeting = 'Добрий вечір!';
        } else {
            greeting = 'Доброї ночі!';
        }
        
        greetingText.textContent = greeting;
    }
    
    // Animations removed - no loaded class needed
    
    // Header scroll behavior - DISABLED - header is always static, no changes on scroll
    
    // Hamburger menu click handler - toggle active state
    const hamburgerMenu = document.getElementById('hamburger-menu');
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }
    
    // Scroll Indicator - Dynamic dot movement based on scroll position
    const scrollIndicator = document.querySelector('.scroll-indicator');
    const scrollDot = document.querySelector('.scroll-dot-top');
    
    if (scrollIndicator && scrollDot) {
        function updateScrollIndicator() {
            // Get scroll position
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Calculate scroll percentage (0 to 1)
            const scrollableHeight = documentHeight - windowHeight;
            const scrollPercent = scrollableHeight > 0 ? Math.min(scrollTop / scrollableHeight, 1) : 0;
            
            // Move dot down along the line (0px to ~187px to keep dot visible within 220px line)
            const lineHeight = 220; // Height of scroll-line
            const dotSize = 19; // Size of scroll dot - inner circle (increased to 19px for better visibility)
            const dotBorder = 7.2; // Border size - outer circle (increased by 30% from 5.5px to 7.2px)
            const totalDotSize = dotSize + (dotBorder * 2); // Total size including border (19 + 7.2*2 = 33.4px)
            const maxMove = lineHeight - totalDotSize; // Maximum movement to keep dot visible (~187px)
            const dotPosition = scrollPercent * maxMove;
            
            // Update dot position (dot is absolutely positioned within scroll-indicator)
            scrollDot.style.top = dotPosition + 'px';
        }
        
        // Update on scroll with requestAnimationFrame for smooth performance
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateScrollIndicator();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true }); // Passive listener for better performance
        
        // Update on resize (content height might change)
        window.addEventListener('resize', function() {
            updateScrollIndicator();
        }, { passive: true });
        
        // Initial update
        updateScrollIndicator();
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
