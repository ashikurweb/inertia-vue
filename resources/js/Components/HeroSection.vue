<script setup>
import { ref } from 'vue'
import { 
  PlayCircleOutlined,
  RocketOutlined
} from '@ant-design/icons-vue'

// Props
const props = defineProps({
  user: {
    type: Object,
    default: null
  }
})

// Handle CTA clicks
const handleGetStarted = () => {
  if (props.user) {
    window.location.href = '/dashboard'
  } else {
    window.location.href = '/register'
  }
}

const handleWatchDemo = () => {
  // Handle demo modal or navigation
  console.log('Watch demo clicked')
}
</script>

<template>
  <!-- Main Hero Section -->
  <div class="min-h-screen w-full relative pt-18">
    
    <!-- Hero Content -->
    <div class="min-h-screen flex items-center justify-center px-4 pb-32">
      <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
        <!-- Left Content -->
        <div class="space-y-8 lg:text-left text-center">
          <!-- Badge -->
          <div class="text-reveal stagger-1 inline-flex items-center gap-3 px-5 py-2 bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200/60 rounded-full shadow-md">
            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
            <span class="text-yellow-700 font-medium text-sm">Innovation Meets Excellence</span>
          </div>
          
          <!-- Main Heading -->
          <div class="space-y-4">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-tight tracking-tight">
              <div class="text-reveal stagger-2 text-gray-900">
                Bright Ideas,
              </div>
              <div class="text-reveal stagger-3">
                <span class="bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 bg-clip-text text-transparent animate-gradient-x">
                  Brilliant Results
                </span>
              </div>
            </h1>
          </div>
          
          <!-- Subtitle -->
          <div class="text-reveal stagger-4 space-y-6">
            <p class="text-xl md:text-2xl text-gray-600 font-light leading-relaxed max-w-lg lg:max-w-none mx-auto lg:mx-0">
              We illuminate your path to success with creative solutions that spark growth and ignite possibilities.
            </p>
            
            <!-- Feature Points -->
            <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
              <div class="flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-gray-200/50">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">Creative Excellence</span>
              </div>
              <div class="flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-gray-200/50">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">Smart Solutions</span>
              </div>
              <div class="flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-gray-200/50">
                <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">Proven Impact</span>
              </div>
            </div>
          </div>
          
          <!-- CTA Buttons -->
          <div class="text-reveal stagger-5 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center">
          <!-- Primary CTA Button -->
          <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
            <button
              @click="handleGetStarted"
              class="relative px-8 py-4 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 text-white font-bold rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-xl border border-white/10 group overflow-hidden"
            >
              <span class="relative z-10 flex items-center gap-3 text-lg">
                <RocketOutlined class="text-xl group-hover:translate-x-1 transition-all duration-300" />
                <span>Light Up Your Brand</span>
              </span>
            </button>
          </div>
          
          <!-- Secondary CTA Button -->
          <button
            @click="handleWatchDemo"
            class="px-8 py-4 bg-white/90 backdrop-blur-xl text-gray-800 font-bold rounded-2xl border border-gray-200/50 hover:border-orange-300/50 transition-all duration-300 hover:scale-105 hover:shadow-xl group"
          >
            <span class="flex items-center gap-3 text-lg group-hover:text-orange-700 transition-colors duration-300">
              <PlayCircleOutlined class="text-xl" />
              <span>See Our Work</span>
            </span>
          </button>
        </div>
      </div>

      <!-- Right Side - Animated Bulb -->
      <div class="hidden lg:flex items-center justify-center">
        <div class="relative">
          <!-- Main Bulb Container -->
          <div class="bulb-container">
            <!-- Bulb Base -->
            <div class="bulb-base"></div>
            
            <!-- Bulb Glass -->
            <div class="bulb-glass">
              <!-- Inner Glow -->
              <div class="bulb-glow"></div>
              <!-- Filament -->
              <div class="bulb-filament"></div>
            </div>
            
            <!-- Light Rays -->
            <div class="light-rays">
              <div class="ray ray-1"></div>
              <div class="ray ray-2"></div>
              <div class="ray ray-3"></div>
              <div class="ray ray-4"></div>
              <div class="ray ray-5"></div>
              <div class="ray ray-6"></div>
            </div>
            
            <!-- Floating Sparkles -->
            <div class="sparkles">
              <div class="sparkle sparkle-1"></div>
              <div class="sparkle sparkle-2"></div>
              <div class="sparkle sparkle-3"></div>
              <div class="sparkle sparkle-4"></div>
              <div class="sparkle sparkle-5"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</template>

<style scoped>
/* Grid Background Animation */
@keyframes grid-pulse {
  0%, 100% {
    opacity: 0.4;
    transform: scale(1);
  }
  50% {
    opacity: 0.6;
    transform: scale(1.01);
  }
}

.grid-background {
  background-image: 
    linear-gradient(to right, #e2e8f0 1px, transparent 1px),
    linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
  background-size: 30px 30px;
  -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, #000 40%, transparent 100%);
  mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, #000 40%, transparent 100%);
  animation: grid-pulse 4s ease-in-out infinite;
}

/* Particle Animations */
@keyframes particle-float {
  0%, 100% {
    transform: translateY(0px) translateX(0px);
  }
  25% {
    transform: translateY(-15px) translateX(8px);
  }
  50% {
    transform: translateY(-30px) translateX(-4px);
  }
  75% {
    transform: translateY(-15px) translateX(-8px);
  }
}

.particle {
  animation: particle-float 6s ease-in-out infinite;
}

.particle-1 { left: 15%; top: 25%; animation-delay: 0s; }
.particle-2 { left: 25%; top: 65%; animation-delay: 1s; }
.particle-3 { left: 75%; top: 35%; animation-delay: 2s; }
.particle-4 { left: 85%; top: 75%; animation-delay: 3s; }
.particle-5 { left: 55%; top: 15%; animation-delay: 4s; }
.particle-6 { left: 95%; top: 55%; animation-delay: 5s; }

/* Morphing Blob Animation */
@keyframes morphing-blob {
  0%, 100% {
    transform: translate(0px, 0px) scale(1);
    border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
  }
  25% {
    transform: translate(20px, -30px) scale(1.05);
    border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%;
  }
  50% {
    transform: translate(-15px, 15px) scale(0.95);
    border-radius: 50% 60% 30% 60% / 30% 60% 70% 40%;
  }
  75% {
    transform: translate(-20px, -15px) scale(1.02);
    border-radius: 60% 40% 60% 30% / 70% 30% 60% 40%;
  }
}

.morphing-blob {
  animation: morphing-blob 8s ease-in-out infinite;
}

.morphing-blob-delay {
  animation-delay: 2s;
}

.morphing-blob-delay-2 {
  animation-delay: 4s;
}

/* Text Reveal Animation */
@keyframes text-reveal {
  from {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
    filter: blur(5px);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
    filter: blur(0px);
  }
}

.text-reveal {
  opacity: 0;
  animation: text-reveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Stagger Delays */
.stagger-1 { animation-delay: 0.1s; }
.stagger-2 { animation-delay: 0.2s; }
.stagger-3 { animation-delay: 0.4s; }
.stagger-4 { animation-delay: 0.6s; }
.stagger-5 { animation-delay: 0.8s; }
.stagger-6 { animation-delay: 1.0s; }
.stagger-7 { animation-delay: 1.2s; }

/* Gradient Animation */
@keyframes gradient-x {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 3s ease infinite;
}

/* Animated Light Bulb Styles */
.bulb-container {
  position: relative;
  width: 300px;
  height: 400px;
  animation: float 3s ease-in-out infinite;
}

/* Bulb Base (Metal part) */
.bulb-base {
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 60px;
  background: linear-gradient(135deg, #d1d5db, #9ca3af);
  border-radius: 8px;
  box-shadow: 
    0 4px 8px rgba(0, 0, 0, 0.2),
    inset 0 2px 4px rgba(255, 255, 255, 0.3);
}

/* Bulb Base ridges */
.bulb-base::before {
  content: '';
  position: absolute;
  top: 10px;
  left: 10%;
  right: 10%;
  height: 2px;
  background: repeating-linear-gradient(
    90deg,
    #9ca3af 0px,
    #9ca3af 3px,
    #d1d5db 3px,
    #d1d5db 6px
  );
}

/* Main Glass Bulb */
.bulb-glass {
  position: absolute;
  bottom: 50px;
  left: 50%;
  transform: translateX(-50%);
  width: 150px;
  height: 200px;
  background: radial-gradient(
    ellipse at center,
    rgba(255, 255, 255, 0.9) 0%,
    rgba(255, 255, 255, 0.7) 40%,
    rgba(255, 255, 255, 0.4) 70%,
    rgba(255, 255, 255, 0.1) 100%
  );
  border-radius: 75px 75px 40px 40px;
  box-shadow: 
    0 0 30px rgba(255, 200, 0, 0.3),
    inset 0 10px 20px rgba(255, 255, 255, 0.2);
  animation: bulb-glow 2s ease-in-out infinite alternate;
}

/* Inner Glow */
.bulb-glow {
  position: absolute;
  top: 20%;
  left: 20%;
  right: 20%;
  bottom: 20%;
  background: radial-gradient(
    ellipse at center,
    rgba(255, 193, 7, 0.8) 0%,
    rgba(255, 152, 0, 0.6) 40%,
    rgba(255, 87, 34, 0.3) 70%,
    transparent 100%
  );
  border-radius: 50%;
  animation: inner-glow 1.5s ease-in-out infinite alternate;
}

/* Filament */
.bulb-filament {
  position: absolute;
  top: 30%;
  left: 50%;
  transform: translateX(-50%);
  width: 2px;
  height: 80px;
  background: linear-gradient(
    to bottom,
    rgba(255, 193, 7, 1) 0%,
    rgba(255, 152, 0, 0.8) 50%,
    rgba(255, 87, 34, 0.6) 100%
  );
  border-radius: 1px;
  box-shadow: 0 0 10px rgba(255, 193, 7, 0.8);
  animation: filament-flicker 0.1s ease-in-out infinite alternate;
}

/* Filament zigzag pattern */
.bulb-filament::before,
.bulb-filament::after {
  content: '';
  position: absolute;
  width: 1px;
  height: 25px;
  background: inherit;
  border-radius: inherit;
}

.bulb-filament::before {
  top: 15px;
  left: -8px;
  transform: rotate(15deg);
}

.bulb-filament::after {
  top: 40px;
  right: -8px;
  transform: rotate(-15deg);
}

/* Light Rays */
.light-rays {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 400px;
  height: 400px;
  pointer-events: none;
}

.ray {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 4px;
  height: 80px;
  background: linear-gradient(
    to bottom,
    rgba(255, 193, 7, 0.8) 0%,
    rgba(255, 193, 7, 0.4) 50%,
    transparent 100%
  );
  border-radius: 2px;
  transform-origin: center bottom;
  animation: rays-rotate 4s linear infinite;
}

.ray-1 { transform: translate(-50%, -100%) rotate(0deg); }
.ray-2 { transform: translate(-50%, -100%) rotate(60deg); }
.ray-3 { transform: translate(-50%, -100%) rotate(120deg); }
.ray-4 { transform: translate(-50%, -100%) rotate(180deg); }
.ray-5 { transform: translate(-50%, -100%) rotate(240deg); }
.ray-6 { transform: translate(-50%, -100%) rotate(300deg); }

/* Sparkles */
.sparkles {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  pointer-events: none;
}

.sparkle {
  position: absolute;
  width: 6px;
  height: 6px;
  background: radial-gradient(circle, rgba(255, 193, 7, 1) 0%, rgba(255, 193, 7, 0) 70%);
  border-radius: 50%;
  animation: sparkle-twinkle 2s ease-in-out infinite;
}

.sparkle-1 { top: 20%; left: 15%; animation-delay: 0s; }
.sparkle-2 { top: 35%; right: 20%; animation-delay: 0.4s; }
.sparkle-3 { bottom: 40%; left: 25%; animation-delay: 0.8s; }
.sparkle-4 { top: 50%; right: 15%; animation-delay: 1.2s; }
.sparkle-5 { bottom: 25%; right: 30%; animation-delay: 1.6s; }

/* Bulb Animations */
@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}

@keyframes bulb-glow {
  0% {
    box-shadow: 
      0 0 30px rgba(255, 200, 0, 0.3),
      inset 0 10px 20px rgba(255, 255, 255, 0.2);
  }
  100% {
    box-shadow: 
      0 0 60px rgba(255, 200, 0, 0.6),
      0 0 100px rgba(255, 200, 0, 0.3),
      inset 0 10px 20px rgba(255, 255, 255, 0.3);
  }
}

@keyframes inner-glow {
  0% {
    opacity: 0.6;
    transform: scale(0.8);
  }
  100% {
    opacity: 1;
    transform: scale(1.1);
  }
}

@keyframes filament-flicker {
  0%, 98%, 100% {
    opacity: 1;
    filter: brightness(1);
  }
  99% {
    opacity: 0.8;
    filter: brightness(0.8);
  }
}

@keyframes rays-rotate {
  0% {
    transform: translate(-50%, -100%) rotate(var(--rotation, 0deg)) scale(0.8);
    opacity: 0.3;
  }
  50% {
    opacity: 0.8;
    transform: translate(-50%, -100%) rotate(calc(var(--rotation, 0deg) + 180deg)) scale(1);
  }
  100% {
    transform: translate(-50%, -100%) rotate(calc(var(--rotation, 0deg) + 360deg)) scale(0.8);
    opacity: 0.3;
  }
}

@keyframes sparkle-twinkle {
  0%, 100% {
    opacity: 0;
    transform: scale(0.5);
  }
  50% {
    opacity: 1;
    transform: scale(1.2);
  }
}

/* Smooth Transitions */
* {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}

/* Mobile Responsive Adjustments */
@media (max-width: 768px) {
  .morphing-blob {
    width: 150px;
    height: 150px;
  }
  
  .particle {
    display: none;
  }
  
  .bulb-container {
    display: none;
  }
}

/* Performance Optimizations */
.morphing-blob,
.particle,
.grid-background {
  will-change: transform;
  transform: translate3d(0, 0, 0);
}
</style>
