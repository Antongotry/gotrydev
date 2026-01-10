/**
 * Heartbeat Controller
 * Керує ритмом серця (BPM) та синхронізацією всіх ефектів
 */

class HeartbeatController {
  constructor(bpm = 72) {
    this.bpm = bpm;
    this.phase = 0; // 0-1 цикл серцебиття
    this.beatInterval = 60000 / bpm; // мілісекунди на один удар
    this.lastTime = performance.now();
    this.beatCallbacks = [];
    this.isRunning = true;
    
    console.log(`💗 Heartbeat Controller initialized: ${bpm} BPM (${this.beatInterval}ms per beat)`);
  }
  
  /**
   * Оновлення phase
   */
  update() {
    if (!this.isRunning) return;
    
    const currentTime = performance.now();
    const deltaTime = currentTime - this.lastTime;
    this.lastTime = currentTime;
    
    // Оновлюємо фазу (0-1)
    this.phase += deltaTime / this.beatInterval;
    
    // Коли досягаємо 1.0 - новий удар
    if (this.phase >= 1.0) {
      this.phase = this.phase % 1.0; // Reset фази
      this.triggerBeat();
    }
  }
  
  /**
   * Тригер події удару серця
   */
  triggerBeat() {
    this.beatCallbacks.forEach(callback => callback());
  }
  
  /**
   * Підписка на події удару
   */
  onBeat(callback) {
    this.beatCallbacks.push(callback);
  }
  
  /**
   * Отримати інтенсивність (0-1) для поточної фази
   * Використовує sin для плавної пульсації
   */
  getIntensity() {
    // Systole (скорочення) та diastole (розслаблення)
    // 0.0 → 1.0 → 0.0
    return Math.sin(this.phase * Math.PI);
  }
  
  /**
   * Отримати інтенсивність з різким піком (для ECG)
   * QRS complex має різкий пік
   */
  getECGIntensity() {
    // Різкий пік в момент удару (0.0-0.2 phase)
    if (this.phase < 0.2) {
      return Math.pow(Math.sin(this.phase * 5 * Math.PI), 2);
    }
    // Smooth затухання
    return Math.max(0, 1.0 - (this.phase - 0.2) / 0.8) * 0.3;
  }
  
  /**
   * Отримати scale для zoom ефекту
   */
  getScale() {
    const intensity = this.getIntensity();
    return 1.0 + intensity * 0.05; // 1.0 - 1.05
  }
  
  /**
   * Отримати distortion інтенсивність
   */
  getDistortion() {
    const intensity = this.getIntensity();
    return 0.9 + intensity * 0.3; // 0.9 - 1.2
  }
  
  /**
   * Пауза/продовження
   */
  toggle() {
    this.isRunning = !this.isRunning;
    if (this.isRunning) {
      this.lastTime = performance.now();
    }
  }
  
  /**
   * Отримати поточний BPM
   */
  getBPM() {
    return this.bpm;
  }
  
  /**
   * Змінити BPM
   */
  setBPM(newBPM) {
    this.bpm = newBPM;
    this.beatInterval = 60000 / newBPM;
    console.log(`💗 BPM changed to: ${newBPM}`);
  }
}

// Експорт для використання в інших файлах
window.HeartbeatController = HeartbeatController;

