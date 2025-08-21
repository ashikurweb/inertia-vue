<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import { 
  MenuOutlined, 
  UserOutlined, 
  DownOutlined,
} from '@ant-design/icons-vue'
import { Button, Drawer } from 'ant-design-vue'

// Props
const props = defineProps({
  user: {
    type: Object,
    default: null
  }
})

// Reactive state
const mobileMenuVisible = ref(false)
const isScrolled = ref(false)
const userDropdownOpen = ref(false)

// Navigation items
const navItems = [
  { label: 'Home', href: '/', active: true },
  { label: 'Blog', href: '/blog' },
  { label: 'About', href: '/about' },
  { label: 'Contact', href: '/contact' }
]

// Account dropdown menu items
const accountMenuItems = props.user ? [
  { key: 'dashboard', label: 'Dashboard', icon: 'fas fa-tachometer-alt' },
  { key: 'profile', label: 'Profile', icon: 'fas fa-user' },
  { key: 'settings', label: 'Settings', icon: 'fas fa-cog' },
  { key: 'logout', label: 'Logout', icon: 'fas fa-sign-out-alt' }
] : [
  { key: 'login', label: 'Login', icon: 'fas fa-sign-in-alt' },
  { key: 'register', label: 'Register', icon: 'fas fa-user-plus' }
]

// Handle scroll effect for header
const handleScroll = () => {
  isScrolled.value = window.scrollY > 10
}

// Toggle mobile menu
const toggleMobileMenu = () => {
  mobileMenuVisible.value = !mobileMenuVisible.value
}

// Toggle user dropdown
const toggleUserDropdown = () => {
  userDropdownOpen.value = !userDropdownOpen.value
}

// Close dropdown when clicking outside
const closeUserDropdown = () => {
  userDropdownOpen.value = false
}

// Handle account menu click
const handleAccountClick = (key) => {
  if (key === 'logout') {
    // Handle logout logic
    window.location.href = '/logout'
  } else if (key === 'login') {
    window.location.href = '/login'
  } else if (key === 'register') {
    window.location.href = '/register'
  } else {
    window.location.href = `/${key}`
  }
  userDropdownOpen.value = false
}

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

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  
  // Add click outside listener for dropdown
  const handleClickOutside = (event) => {
    if (userDropdownOpen.value && !event.target.closest('.user-dropdown-container')) {
      closeUserDropdown()
    }
  }
  
  document.addEventListener('click', handleClickOutside)
  
  return () => {
    window.removeEventListener('scroll', handleScroll)
    document.removeEventListener('click', handleClickOutside)
  }
})
</script>

<template>
  <div class="relative">
    <!-- Head for SEO -->
    <Head title="Transform Your Digital Vision - BrandLogo" />
    
    <!-- Improved Header -->
    <header 
      :class="[
        'fixed top-0 left-0 right-0 z-50 transition-all duration-500 ease-out',
        isScrolled 
          ? 'backdrop-blur-2xl shadow-lg' 
          : 'bg-transparent'
      ]"
    >
      <!-- Header Border (only visible when scrolled) -->
      <div 
        v-if="isScrolled"
        class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"
      ></div>
      
      <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-18">
          <!-- Logo -->
          <div class="flex-shrink-0">
            <Link href="/" class="block">
              <h1 class="text-2xl font-black bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent hover:scale-105 transition-all duration-300 tracking-tight">
                BrandLogo
              </h1>
            </Link>
          </div>

          <!-- Desktop Navigation -->
          <div class="hidden lg:block">
            <div class="flex items-center space-x-1">
              <Link 
                v-for="item in navItems" 
                :key="item.label"
                :href="item.href" 
                :class="[
                  'px-4 py-2 text-sm font-medium transition-all duration-300 rounded-xl relative group',
                  item.active 
                    ? 'text-blue-600 bg-blue-50' 
                    : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50/50'
                ]"
              >
                {{ item.label }}
                <span 
                  v-if="!item.active"
                  class="absolute inset-x-2 bottom-1 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"
                ></span>
              </Link>
            </div>
          </div>

          <!-- Custom Account Section -->
          <div class="hidden lg:flex items-center space-x-4">
            <div class="relative user-dropdown-container">
              <button 
                @click="toggleUserDropdown"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200/60 text-gray-700 hover:border-blue-500 hover:text-blue-600 font-medium transition-all duration-300"
              >
                <div class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center">
                  <i class="fas fa-user text-gray-600"></i>
                </div>
                <span>{{ user ? user.name : 'My Account' }}</span>
                <svg 
                  class="w-4 h-4 transition-transform duration-200" 
                  :class="{ 'rotate-180': userDropdownOpen }" 
                  fill="none" 
                  stroke="currentColor" 
                  viewBox="0 0 24 24"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </button>
              
              <!-- Custom Account Dropdown Menu -->
              <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 scale-95 translate-y-2"
                enter-to-class="opacity-100 scale-100 translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 scale-100 translate-y-0"
                leave-to-class="opacity-0 scale-95 translate-y-2"
              >
                <div 
                  v-show="userDropdownOpen" 
                  class="absolute right-0 mt-3 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 py-2"
                >
                  <a 
                    v-for="item in accountMenuItems" 
                    :key="item.key"
                    href="#"
                    @click.prevent="handleAccountClick(item.key)"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50/80 transition-colors group rounded-lg mx-2"
                  >
                    <i :class="[item.icon, 'w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors']"></i>
                    {{ item.label }}
                  </a>
                </div>
              </transition>
            </div>
          </div>

          <!-- Mobile menu button -->
          <div class="lg:hidden">
            <Button 
              type="text" 
              size="large"
              @click="toggleMobileMenu"
              class="hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 rounded-xl"
            >
              <MenuOutlined class="text-xl" />
            </Button>
          </div>
        </div>
      </nav>

      <!-- Mobile Navigation Drawer -->
      <Drawer
        v-model:open="mobileMenuVisible"
        title="Navigation"
        placement="right"
        :width="320"
        class="lg:hidden"
        :body-style="{ padding: '24px' }"
      >
        <div class="flex flex-col space-y-6">
          <!-- Navigation Links -->
          <div class="space-y-2">
            <Link 
              v-for="item in navItems" 
              :key="item.label"
              :href="item.href" 
              :class="[
                'block px-4 py-3 text-lg font-medium transition-all duration-300 rounded-xl',
                item.active 
                  ? 'text-blue-600 bg-blue-50' 
                  : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50'
              ]"
              @click="mobileMenuVisible = false"
            >
              {{ item.label }}
            </Link>
          </div>
          
          <!-- Divider -->
          <div class="border-t border-gray-200"></div>
          
          <!-- Mobile Account Actions -->
          <div class="space-y-2">
            <button 
              v-for="item in accountMenuItems" 
              :key="item.key"
              type="button"
              class="w-full text-left flex items-center gap-3 px-4 py-3 text-gray-700 hover:border-l-4 hover:border-l-blue-500 hover:text-blue-600 font-medium transition-colors"
              @click="() => { handleAccountClick(item.key); mobileMenuVisible = false }"
            >
              <i :class="[item.icon, 'w-5 h-5']"></i>
              {{ item.label }}
            </button>
          </div>
        </div>
      </Drawer>
    </header>

    <!-- Main Content Area -->
    <main class="pt-18">
      <slot />
    </main>
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