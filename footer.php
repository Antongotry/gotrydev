<?php if (!is_front_page()): ?>
<footer class="site-footer">
    <!-- Нічого тут немає -->
</footer>
<?php endif; ?>

<script>
// Video background and header scroll
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('bg-video');
    const videoContainer = document.getElementById('video-background');
    const header = document.getElementById('top-nav');
    
    // Video setup
    if (video && videoContainer) {
        videoContainer.style.display = 'block';
        videoContainer.style.background = 'transparent';
        video.style.opacity = '1';
        video.style.display = 'block';
        document.body.style.background = 'transparent';
        
        video.preload = 'auto';
        video.playsInline = true;
        video.muted = true;
        video.playbackRate = 1.0;
        
        video.play().catch(function(error) {
            console.log('Video autoplay failed:', error);
            video.style.opacity = '1';
            document.addEventListener('click', function() {
                video.play();
            }, { once: true });
        });
        
        video.addEventListener('loadeddata', function() {
            video.playbackRate = 1.0;
            video.style.opacity = '1';
            videoContainer.style.background = 'transparent';
        });
        
        video.addEventListener('playing', function() {
            video.playbackRate = 1.0;
            video.style.opacity = '1';
        });
        
        if (video.readyState >= 2) {
            video.playbackRate = 1.0;
        }
    }
    
    // Header scroll behavior
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            if (currentScroll > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScroll = currentScroll;
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
