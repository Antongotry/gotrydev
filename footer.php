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
});
</script>

<?php wp_footer(); ?>
</body>
</html>
