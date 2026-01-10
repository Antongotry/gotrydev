/**
 * Простий Glass Distortion без THREE.js
 * Використовує CSS gradient з затемненням
 */
(function(){
  console.log('🚀 Simple Glass Distortion initialized');
  
  const container = document.querySelector('#gradient-bg');
  if(!container) {
    console.error('Container not found');
    return;
  }
  
  // Створюємо gradient div
  const glassDiv = document.createElement('div');
  glassDiv.className = 'glass-overlay-simple';
  container.appendChild(glassDiv);
  
  // Додаємо інтерактивність з мишею
  let mouseX = 0.5;
  let mouseY = 0.5;
  
  document.addEventListener('mousemove', function(e) {
    mouseX = e.clientX / window.innerWidth;
    mouseY = e.clientY / window.innerHeight;
    
    glassDiv.style.setProperty('--mouse-x', mouseX);
    glassDiv.style.setProperty('--mouse-y', mouseY);
  });
  
  console.log('✅ Glass effect ready');
})();

