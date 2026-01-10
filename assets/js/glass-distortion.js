/**
 * THREE.js Fractal Glass Distortion Effect
 * Based on secure-file-access plugin, adapted for phonegotry.webp
 * БЕЗ складних анімацій появи - просто показується одразу
 */

// Чекаємо поки THREE.js завантажиться (з максимальною кількістю спроб)
let retryCount = 0;
const maxRetries = 50; // 5 секунд максимум

function initGlassDistortion() {
  console.log('🚀 Initializing Glass Distortion... (retry ' + retryCount + ')');
  
  const container = document.querySelector('#gradient-bg');
  if(!container) {
    console.error('❌ Container #gradient-bg not found');
    return;
  }
  
  if(!window.THREE) {
    retryCount++;
    if(retryCount < maxRetries) {
      console.log('⏳ Waiting for THREE.js... attempt ' + retryCount);
      setTimeout(initGlassDistortion, 100);
    } else {
      console.error('❌ THREE.js failed to load after ' + maxRetries + ' attempts');
      console.log('Check if THREE.js CDN is accessible');
    }
    return;
  }
  
  console.log('✅ Container and THREE.js found!');

  const scene = new THREE.Scene();
  const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
  const renderer = new THREE.WebGLRenderer({ 
    antialias: true, 
    alpha: true, 
    powerPreference: "high-performance" 
  });
  
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setClearColor(0x000000, 0);
  container.appendChild(renderer.domElement);

  // PHONEGOTRY.WEBP - ваше зображення
  const IMAGE_URL = "https://antongotry.dev/wp-content/uploads/2025/10/phonegotry.webp";
  const loader = new THREE.TextureLoader();
  const tex = loader.load(IMAGE_URL);
  tex.wrapS = tex.wrapT = THREE.ClampToEdgeWrapping;
  tex.minFilter = THREE.LinearMipMapLinearFilter;
  tex.magFilter = THREE.LinearFilter;
  tex.anisotropy = renderer.capabilities.getMaxAnisotropy?.() || 1;

  const uniforms = {
    u_time: { value: 0 },
    u_mouse: { value: new THREE.Vector2(0.5, 0.5) },
    u_resolution: { value: new THREE.Vector2(window.innerWidth, window.innerHeight) },
    u_tex: { value: tex },
    u_pitchBasePx: { value: 20.0 },
    u_pitchMinPx: { value: 14.0 },
    u_pitchMaxPx: { value: 24.0 },
    u_waveAmp: { value: 0.38 },
    u_waveSpeed: { value: 0.65 },
    u_warpStrength: { value: 0.12 },
    u_glassDisp: { value: 0.9 },
    u_glassBlur: { value: 1.5 },
    u_lineSoftness: { value: 0.55 },
    u_lineOpacity: { value: 0.85 },
    u_imgBaseScale: { value: 1.22 },
    u_imgHoverZoom: { value: 0.18 },
    u_imgHoverTilt: { value: 0.10 },
    u_vertFeatherPx: { value: 6.0 },
    u_flagAmpPx: { value: 10.0 },
    u_flagFreq: { value: 1.6 },
    u_flagSpeed: { value: 0.65 }
  };

  const vertexShader = `
    precision highp float;
    void main(){
      gl_Position = vec4(position, 1.0);
    }
  `;

  const fragmentShader = `
    precision highp float;
    uniform vec2 u_resolution;
    uniform float u_time;
    uniform vec2 u_mouse;
    uniform sampler2D u_tex;
    uniform float u_pitchBasePx, u_pitchMinPx, u_pitchMaxPx;
    uniform float u_waveAmp, u_waveSpeed, u_warpStrength;
    uniform float u_glassDisp, u_glassBlur, u_lineSoftness, u_lineOpacity;
    uniform float u_imgBaseScale, u_imgHoverZoom, u_imgHoverTilt;
    uniform float u_vertFeatherPx;
    uniform float u_flagAmpPx, u_flagFreq, u_flagSpeed;

    const float GAP_PX = 3.0;
    const vec2 LIGHT2D = vec2(0.55, 0.85);

    float hash(vec2 p){ p = fract(p*vec2(123.34, 345.45)); p += dot(p, p+34.345); return fract(p.x*p.y); }
    float noise(vec2 p){ vec2 i=floor(p), f=fract(p); float a=hash(i), b=hash(i+vec2(1,0)); float c=hash(i+vec2(0,1)), d=hash(i+vec2(1,1)); vec2 u=f*f*(3.0-2.0*f); return mix(mix(a,b,u.x), mix(c,d,u.x), u.y);} 
    float fbm(vec2 p){ float s=0.0,a=0.5; for(int i=0;i<5;i++){ s+=a*noise(p); p=p*2.0+13.57; a*=0.5;} return s; }

    vec4 sampleImage(vec2 uvN, float scale, float rot){
      float aspect = u_resolution.x / u_resolution.y;
      vec2 p = (uvN - 0.5) * vec2(aspect, 1.0);
      float cs = cos(rot), sn = sin(rot);
      p = mat2(cs,-sn,sn,cs) * p;
      p /= scale;
      vec2 uv = p / vec2(aspect, 1.0) + 0.5;
      return texture2D(u_tex, uv);
    }

    float halfRound(float u){
      float x = clamp(u*2.0 - 1.0, -1.0, 1.0);
      return sqrt(max(0.0, 1.0 - x*x));
    }

    void main(){
      vec2 R = u_resolution; 
      vec2 uv = gl_FragCoord.xy / R;
      float t = u_time;

      float d = distance(uv, u_mouse);
      float hover = exp(-6.0 * d*d);
      
      float scale = u_imgBaseScale * (1.0 + u_imgHoverZoom * hover);
      float rot   = u_imgHoverTilt * (hover * 2.0 - 1.0) * 0.5;
      float flagPhase = uv.y * u_flagFreq + t * u_flagSpeed;
      float flagDisp = (u_flagAmpPx / R.x) * (sin(6.28318*flagPhase) + 0.45*sin(6.28318*(flagPhase*1.73 + 1.2)));
      vec2 uvFlag = uv + vec2(flagDisp, 0.0);
      float pad = 1.0 + (u_flagAmpPx / R.x) * 1.8;
      float scalePadded = scale * pad;
      vec4 imgCol = sampleImage(uvFlag, scalePadded, rot);

      float yN = uv.y;
      float baseBendPx = (u_waveAmp * 26.0) * sin(3.14159*1.10*yN + t*u_waveSpeed)
                       + (u_waveAmp * 12.0) * sin(3.14159*2.0*yN - t*u_waveSpeed*0.6);
      float mouseBendPx = 18.0 * u_waveAmp * hover * (uv.x - u_mouse.x) * 0.2;
      float bendPx = baseBendPx + mouseBendPx;

      float organic = (fbm(uv*vec2(R.x/R.y,1.0)*0.8 + t*0.02) - 0.5) * u_warpStrength * 2.0;

      float thickPx = mix(u_pitchMinPx, u_pitchMaxPx, hover);
      thickPx = mix(thickPx, u_pitchBasePx, 0.5);
      float periodPx = thickPx + GAP_PX;

      float xPx = gl_FragCoord.x + bendPx + organic;
      float xMod = mod(xPx, periodPx);

      float aa = fwidth(xPx);
      float inStrip = 1.0 - smoothstep(thickPx - aa, thickPx + aa, xMod);

      float u = clamp(xMod / max(1.0, thickPx), 0.0, 1.0);
      float profile = halfRound(u);

      vec2 n2 = normalize(vec2(0.5 - u, 0.10));

      vec2 texel = 1.0 / R;
      float dispAmt = u_glassDisp * (0.85*profile + 0.15) * 0.010;
      vec2 o = n2 * dispAmt;
      float br = u_glassBlur;
      vec4 u0 = texture2D(u_tex, uv + o);
      vec4 u1 = texture2D(u_tex, uv + o + texel*vec2( br, 0.0));
      vec4 u2 = texture2D(u_tex, uv + o + texel*vec2(-br, 0.0));
      vec4 u3 = texture2D(u_tex, uv + o + texel*vec2( 0.0, br));
      vec4 u4 = texture2D(u_tex, uv + o + texel*vec2( 0.0,-br));
      vec3 under = (u0*0.42 + (u1+u2+u3+u4)*0.145).rgb;

      vec2 L = normalize(LIGHT2D);
      float ldot = clamp(dot(L, n2), -1.0, 1.0);
      float spec = pow(max(0.0, ldot), 6.0) * 0.45 * profile;
      float shade = (1.0 - max(0.0, ldot)) * 0.22 * profile;

      vec3 glass = under * (1.0 - shade) + spec;

      float band = clamp(profile, 0.0, 1.0);
      float alpha = u_lineOpacity * (0.55 + 0.45*band);
      vec3 base = imgCol.rgb;
      vec3 col  = mix(base, glass, inStrip * alpha);
      
      // ЗАТЕМНЕННЯ 20%
      col *= 0.8;

      gl_FragColor = vec4(col, 1.0);
    }
  `;

  const material = new THREE.ShaderMaterial({
    uniforms,
    vertexShader,
    fragmentShader,
    depthTest: false,
    depthWrite: false,
    transparent: true,
  });

  const mesh = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), material);
  scene.add(mesh);

  let mouseTarget = new THREE.Vector2(0.5, 0.5);
  
  function onPointerMove(e){ 
    mouseTarget.set(e.clientX / window.innerWidth, 1.0 - e.clientY / window.innerHeight); 
  }
  
  function onPointerLeave(){ 
    mouseTarget.set(-0.5, -0.5);
  }
  
  function onResize(){
    renderer.setSize(window.innerWidth, window.innerHeight);
    uniforms.u_resolution.value.set(window.innerWidth, window.innerHeight);
  }
  
  container.addEventListener("pointermove", onPointerMove);
  container.addEventListener("pointerleave", onPointerLeave);
  window.addEventListener("resize", onResize);

  // Animation loop з плавними хвилями
  function animate(){
    uniforms.u_mouse.value.lerp(mouseTarget, 0.08);
    uniforms.u_time.value += 0.016; // Плавна анимация (~60fps)
    
    renderer.render(scene, camera);
    requestAnimationFrame(animate);
  }
  animate();
  
  console.log('✅ Glass Distortion initialized - волновой эффект без heartbeat');
}

// Запускаємо після завантаження DOM
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initGlassDistortion);
} else {
  initGlassDistortion();
}

