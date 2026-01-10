/**
 * Heartbeat Initialization
 * Ініціалізує всі heartbeat компоненти та синхронізує їх
 */

(function() {
  console.log('💗 Initializing Heartbeat System...');
  
  // Чекаємо поки все завантажиться
  function init() {
    if (!window.HeartbeatController || !window.ECGLine) {
      console.log('⏳ Waiting for Heartbeat components...');
      setTimeout(init, 100);
      return;
    }
    
    console.log('✅ All components loaded!');
    
    // Створюємо Heartbeat Controller
    const BPM = 72;
    window.heartbeatController = new HeartbeatController(BPM);
    
    // Створюємо ECG Line
    const ecgLine = new ECGLine('ecg-canvas', window.heartbeatController);
    
    // Audio - sound-life.mp3
    const audio = new Audio();
    audio.src = 'https://antongotry.dev/wp-content/uploads/2025/10/sound-life.mp3';
    audio.loop = true; // Нескінченний loop
    audio.volume = 0.6;
    audio.preload = 'auto';
    
    // Event listeners для debug
    audio.addEventListener('canplay', () => {
      console.log('✅ Audio can play!');
    });
    
    audio.addEventListener('error', (e) => {
      console.error('❌ Audio error:', e);
    });
    
    console.log('🎵 Audio initialized:', audio.src);
    
    // Mute button logic
    const muteBtn = document.getElementById('mute-btn');
    const iconPath = document.getElementById('icon-path');
    let isPlaying = false;
    
    // SVG paths для іконок
    const PATH_MUTED = "M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z";
    
    const PATH_UNMUTED = "M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z";
    
    if (muteBtn && iconPath) {
      // ПОЧАТКОВО: muted класс + перекреслена іконка + БІЛИЙ бордер
      muteBtn.classList.add('muted');
      iconPath.setAttribute('d', PATH_MUTED);
      
      muteBtn.addEventListener('click', function() {
        console.log('🖱️ Button clicked! Current state:', isPlaying ? 'playing' : 'paused');
        
        if (!isPlaying) {
          // ПЕРЕМИКАЄМО НА PLAYING
          isPlaying = true;
          
          // Міняємо на НОРМАЛЬНУ іконку + ЧЕРВОНИЙ бордер
          muteBtn.classList.remove('muted');
          muteBtn.title = 'Вимкнути звук';
          iconPath.setAttribute('d', PATH_UNMUTED);
          
          console.log('🔊 Starting audio...');
          
          // ГРАТИ МУЗИКУ
          const playPromise = audio.play();
          
          if (playPromise !== undefined) {
            playPromise.then(() => {
              console.log('✅✅✅ MUSIC IS PLAYING IN LOOP! ✅✅✅');
            }).catch(err => {
              console.error('❌ Audio play failed:', err);
              // Fallback
              isPlaying = false;
              muteBtn.classList.add('muted');
              iconPath.setAttribute('d', PATH_MUTED);
            });
          }
        } else {
          // ПЕРЕМИКАЄМО НА PAUSED
          isPlaying = false;
          
          // Міняємо на ПЕРЕКРЕСЛЕНУ іконку + БІЛИЙ бордер
          muteBtn.classList.add('muted');
          muteBtn.title = 'Увімкнути звук';
          iconPath.setAttribute('d', PATH_MUTED);
          
          console.log('🔇 Stopping audio...');
          
          // ЗУПИНИТИ МУЗИКУ
          audio.pause();
          audio.currentTime = 0;
          console.log('✅ Audio stopped');
        }
      });
    }
    
    // Animation loop
    function animate() {
      window.heartbeatController.update();
      ecgLine.update();
      requestAnimationFrame(animate);
    }
    
    animate();
    
    console.log('💗 Heartbeat System ready! BPM:', BPM);
  }
  
  // Запускаємо після DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();

