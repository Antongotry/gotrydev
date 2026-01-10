<?php if (!is_front_page()): ?>
<footer class="site-footer">
    <!-- Нічого тут немає -->
</footer>
<?php endif; ?>

<script>
// Принудительно запускаем видео на мобильных устройствах
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('bg-video');
    if (video) {
        video.play().catch(function(error) {
            console.log('Video autoplay failed:', error);
            // Повторная попытка после взаимодействия пользователя
            document.addEventListener('click', function() {
                video.play();
            }, { once: true });
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
