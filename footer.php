<?php if (!is_front_page()): ?>
<footer class="site-footer">
    <!-- Нічого тут немає -->
</footer>
<?php endif; ?>

<script>
// Принудительно запускаем видео и убираем черный фон
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('bg-video');
    const videoContainer = document.getElementById('video-background');
    
    if (video && videoContainer) {
        // Убедимся что контейнер видим
        videoContainer.style.display = 'block';
        videoContainer.style.background = 'transparent';
        
        // Показываем видео сразу
        video.style.opacity = '1';
        video.style.display = 'block';
        
        // Убираем черный фон с body
        document.body.style.background = 'transparent';
        
        // Принудительно запускаем видео
        video.play().catch(function(error) {
            console.log('Video autoplay failed:', error);
            // Показываем видео даже если автозапуск не работает
            video.style.opacity = '1';
            // Повторная попытка после взаимодействия пользователя
            document.addEventListener('click', function() {
                video.play();
            }, { once: true });
        });
        
        // Событие когда видео загружено
        video.addEventListener('loadeddata', function() {
            video.style.opacity = '1';
            videoContainer.style.background = 'transparent';
        });
        
        // Событие когда видео начинает играть
        video.addEventListener('playing', function() {
            video.style.opacity = '1';
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
