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
/* Layout specific styles only */
</style>