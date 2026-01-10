/**
 * ECG Line Canvas
 * Біла кардіограма по центру екрану
 */

class ECGLine {
  constructor(canvasId, heartbeat) {
    this.canvas = document.getElementById(canvasId);
    if (!this.canvas) {
      console.error('ECG Canvas not found:', canvasId);
      return;
    }
    
    this.ctx = this.canvas.getContext('2d');
    this.heartbeat = heartbeat;
    this.points = [];
    this.maxPoints = 1000; // В 5 разів більше (400 * 2.5 = 1000)
    this.offset = 0;
    this.mouseY = 0.5; // 0-1, center екрану
    this.frameCounter = 0; // Лічильник для пропуску кадрів
    this.skipFrames = 5; // Пропускаємо 5 кадрів (було 2)
    
    this.setupCanvas();
    this.setupMouseTracking();
    
    console.log('📈 ECG Line initialized');
  }
  
  setupCanvas() {
    // Responsive canvas
    this.resize();
    window.addEventListener('resize', () => this.resize());
  }
  
  resize() {
    this.canvas.width = window.innerWidth;
    this.canvas.height = window.innerHeight;
  }
  
  setupMouseTracking() {
    document.addEventListener('mousemove', (e) => {
      this.mouseY = e.clientY / window.innerHeight;
    });
  }
  
  /**
   * Генерує точки ECG кривої
   */
  generateECGPoint(phase, amplitude = 1.0) {
    const centerY = this.canvas.height / 2;
    let y = centerY;
    
    // P-wave (0.0 - 0.15)
    if (phase < 0.15) {
      const t = phase / 0.15;
      y = centerY - Math.sin(t * Math.PI) * 20 * amplitude;
    }
    // QRS complex (0.15 - 0.35) - різкий пік
    else if (phase < 0.35) {
      const t = (phase - 0.15) / 0.2;
      if (t < 0.3) {
        // Q wave (down)
        y = centerY + 15 * amplitude;
      } else if (t < 0.6) {
        // R wave (sharp up) - ГОЛОВНИЙ ПІК
        const r = (t - 0.3) / 0.3;
        y = centerY - Math.sin(r * Math.PI) * 80 * amplitude;
      } else {
        // S wave (down)
        y = centerY + 20 * amplitude;
      }
    }
    // T-wave (0.35 - 0.6)
    else if (phase < 0.6) {
      const t = (phase - 0.35) / 0.25;
      y = centerY - Math.sin(t * Math.PI) * 30 * amplitude;
    }
    // Baseline (0.6 - 1.0)
    else {
      y = centerY;
    }
    
    return y;
  }
  
  /**
   * Малює ECG лінію
   */
  draw() {
    const ctx = this.ctx;
    const width = this.canvas.width;
    const height = this.canvas.height;
    
    // Очищаємо canvas
    ctx.clearRect(0, 0, width, height);
    
    // Mouse впливає на амплітуду
    const mouseInfluence = Math.abs(this.mouseY - 0.5) * 2; // 0-1
    const amplitude = 1.0 + mouseInfluence * 0.5; // 1.0 - 1.5
    
    // Додаємо нову точку лише кожні 5 кадрів для ДУЖЕ повільного руху
    this.frameCounter++;
    if (this.frameCounter >= this.skipFrames) {
      this.frameCounter = 0;
      const phase = this.heartbeat.phase;
      const y = this.generateECGPoint(phase, amplitude);
      
      this.points.push(y);
      if (this.points.length > this.maxPoints) {
        this.points.shift();
      }
    }
    
    // Малюємо лінію
    ctx.strokeStyle = '#ffffff';
    ctx.lineWidth = 3;
    ctx.shadowBlur = 15;
    ctx.shadowColor = 'rgba(255, 255, 255, 0.8)';
    
    ctx.beginPath();
    
    const spacing = width / this.maxPoints;
    
    for (let i = 0; i < this.points.length; i++) {
      const x = i * spacing;
      const y = this.points[i];
      
      if (i === 0) {
        ctx.moveTo(x, y);
      } else {
        ctx.lineTo(x, y);
      }
    }
    
    ctx.stroke();
    
    // Малюємо baseline (тонка лінія)
    ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
    ctx.lineWidth = 1;
    ctx.shadowBlur = 0;
    
    ctx.beginPath();
    ctx.moveTo(0, height / 2);
    ctx.lineTo(width, height / 2);
    ctx.stroke();
  }
  
  /**
   * Update loop
   */
  update() {
    this.draw();
  }
}

// Експорт
window.ECGLine = ECGLine;

