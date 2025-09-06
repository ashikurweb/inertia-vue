<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

// Reactive data
const sidebarOpen = ref(false)
const currentLang = ref('en')

const submenus = reactive({
    analytics: false,
    content: false
})

const dropdowns = reactive({
    notifications: false,
    language: false,
    profile: false
})

const notification = reactive({
    show: false,
    message: '',
    type: 'info' // success, error, warning, info
})

const languages = reactive({
    'en': { name: 'English', flag: 'us.png' },
    'es': { name: 'Español', flag: 'es.png' },
    'fr': { name: 'Français', flag: 'fr.png' },
    'de': { name: 'Deutsch', flag: 'de.png' },
    'it': { name: 'Italiano', flag: 'it.png' },
    'pt': { name: 'Português', flag: 'pt.png' },
    'ru': { name: 'Русский', flag: 'ru.png' },
    'cn': { name: '中文', flag: 'cn.png' },
    'hi': { name: 'हिन्दी', flag: 'in.png' },
    'bn': { name: 'বাংলা', flag: 'bd.png' },
    'ar': { name: 'العربية', flag: 'sa.png' },
})

// Methods
const toggleSubmenu = (menu) => {
    submenus[menu] = !submenus[menu]
    // Close other submenus
    Object.keys(submenus).forEach(key => {
        if (key !== menu) {
            submenus[key] = false
        }
    })
}

const toggleDropdown = (dropdown) => {
    dropdowns[dropdown] = !dropdowns[dropdown]
    // Close other dropdowns
    Object.keys(dropdowns).forEach(key => {
        if (key !== dropdown) {
            dropdowns[key] = false
        }
    })
}

const closeDropdown = (dropdown) => {
    dropdowns[dropdown] = false
}

const switchLanguage = (code) => {
    currentLang.value = code
    closeDropdown('language')
    window.location.href = `/lang/${code}`
}

const getUserInitials = (name) => {
    if (!name) return 'G'
    return name.split(' ').map(n => n[0]).join('').toUpperCase()
}

const showNotification = (message, type = 'info') => {
    notification.message = message
    notification.type = type
    notification.show = true

    setTimeout(() => {
        hideNotification()
    }, 5000)
}

const hideNotification = () => {
    notification.show = false
}

const logout = () => {
    router.post('/logout')
}

// Handle window resize
const handleResize = () => {
    if (window.innerWidth >= 1024) {
        sidebarOpen.value = false
    }
}

onMounted(() => {
    window.addEventListener('resize', handleResize)

    // Set current language from app locale if available
    if (window.Laravel && window.Laravel.locale) {
        currentLang.value = window.Laravel.locale
    }
})
</script>
<template>
    <div>
        <!-- Notification Component -->
        <div v-if="notification.show" :class="[
            'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg border transition-all duration-500',
            notification.type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
                notification.type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
                    notification.type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' :
                        'bg-blue-50 border-blue-200 text-blue-800'
        ]">
            <div class="flex items-center justify-between">
                <span class="font-medium">{{ notification.message }}</span>
                <button @click="hideNotification" class="ml-4 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div v-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black bg-opacity-50 backdrop-blur-sm lg:hidden"
            style="transition: opacity 0.3s ease;">
        </div>

        <!-- Sidebar -->
        <div :class="[
            'fixed top-0 left-0 z-50 w-64 h-full bg-white border-r border-gray-200 shadow-2xl sidebar overflow-y-auto lg:translate-x-0 transition-transform duration-300',
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]">

            <!-- Logo Area -->
            <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center relative">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <div class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                    </div>
                    <span class="text-xl font-bold text-gray-900 tracking-wide">Dashboard</span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-8 px-4 space-y-2">
                <!-- Dashboard -->
                <Link :href="route('dashboard')" :class="[
                    'menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-200',
                    route().current('dashboard')
                        ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-500 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                ]">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
                </Link>

                <!-- Analytics with Dropdown -->
                <div>
                    <button @click="toggleSubmenu('analytics')" :class="[
                        'menu-item w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200',
                        route().current('analytics.*')
                            ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-500 shadow-sm'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                    ]">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span class="font-medium">Analytics</span>
                        </div>
                        <svg :class="[
                            'w-5 h-5 transition-transform duration-300',
                            submenus.analytics ? 'rotate-180' : ''
                        ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div v-show="submenus.analytics" class="ml-4 mt-2 space-y-1" style="transition: all 0.3s ease;">
                        <Link href="#" :class="[
                            'submenu-item flex items-center px-4 py-2 rounded-lg transition-all duration-200',
                            route().current('analytics.reports')
                                ? 'text-blue-600 font-medium'
                                : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700'
                        ]">
                        <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium">Reports</span>
                        </Link>
                        <Link href="#" :class="[
                            'submenu-item flex items-center px-4 py-2 rounded-lg transition-all duration-200',
                            route().current('analytics.insights')
                                ? 'text-blue-600 font-medium'
                                : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700'
                        ]">
                        <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="text-sm font-medium">Insights</span>
                        </Link>
                        <Link href="#" :class="[
                            'submenu-item flex items-center px-4 py-2 rounded-lg transition-all duration-200',
                            route().current('analytics.realtime')
                                ? 'text-blue-600 font-medium'
                                : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700'
                        ]">
                        <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="text-sm font-medium">Real-time Data</span>
                        </Link>
                    </div>
                </div>

                <!-- Users -->
                <Link href="#" :class="[
                    'menu-item flex items-center px-4 py-3 rounded-xl relative transition-all duration-200',
                    route().current()
                        ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-500 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                ]">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                    </path>
                </svg>
                <span class="font-medium">Users</span>
                </Link>

                <!-- Content with Dropdown -->
                <div>
                    <button @click="toggleSubmenu('content')" :class="[
                        'menu-item w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200',
                        route().current('blog.*', 'categories.*')
                            ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-500 shadow-sm'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                    ]">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <span class="font-medium">Content</span>
                        </div>
                        <svg :class="[
                            'w-5 h-5 transition-transform duration-300',
                            submenus.content ? 'rotate-180' : ''
                        ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div v-show="submenus.content" class="ml-4 mt-2 space-y-1" style="transition: all 0.3s ease;">
                        <Link href="#" :class="[
                            'submenu-item flex items-center px-4 py-2 rounded-lg transition-all duration-200',
                            route().current()
                                ? 'text-blue-600 font-medium'
                                : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700'
                        ]">
                        <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium">Blog</span>
                        </Link>
                        <Link href="#" :class="[
                            'submenu-item flex items-center px-4 py-2 rounded-lg transition-all duration-200',
                            route().current()
                                ? 'text-blue-600 font-medium'
                                : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700'
                        ]">
                        <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium">Categories</span>
                        </Link>
                    </div>
                </div>

                <!-- Orders -->
                <Link href="#"
                    class="menu-item flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="font-medium">Orders</span>
                </Link>

                <!-- Messages -->
                <Link href="#"
                    class="menu-item flex items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <span class="font-medium">Messages</span>
                </Link>

                <!-- Profile -->
                <Link href="" :class="[
                    'menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-200',
                    route().current()
                        ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-500 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                ]">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-medium">Profile</span>
                </Link>

                <!-- Settings -->
                <Link href="" :class="[
                    'menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-200',
                    route().current()
                        ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-500 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                ]">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="font-medium">Settings</span>
                </Link>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:ml-64 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
                <div class="flex items-center justify-between px-4 py-2">
                    <!-- Mobile Menu Button & Search -->
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Search Bar -->
                        <div class="hidden md:flex relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" placeholder="Search anything..."
                                class="pl-12 pr-4 py-2 w-50 border border-gray-300 outline-none bg-gray-50 text-gray-900 shadow-sm rounded-full transition-all duration-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:shadow-md">
                        </div>
                    </div>

                    <!-- Right Side Items -->
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button @click="toggleDropdown('notifications')"
                                class="p-2 text-gray-500 hover:text-gray-700 rounded-full h-10 w-10 border border-gray-300 shadow-sm transition-all duration-200 hover:shadow-md relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-3.5-7.5M12 17V7l-3 3.5L12 17zM12 7v10m0-10V3.5a.5.5 0 01.5-.5h7a.5.5 0 01.5.5V7M12 7l3.5-3.5">
                                    </path>
                                </svg>
                                <span class="absolute top-0.5 right-0.5 flex h-3 w-3">
                                    <span
                                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex h-3 w-3 rounded-full bg-blue-500"></span>
                                </span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div v-show="dropdowns.notifications" @click.away="closeDropdown('notifications')"
                                class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                                style="transition: all 0.2s ease;">

                                <div class="px-4 py-2 border-b border-gray-100">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                </div>

                                <div class="max-h-64 overflow-y-auto">
                                    <a href="#"
                                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">New order received</p>
                                            <p class="text-xs text-gray-500">2 minutes ago</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Payment successful</p>
                                            <p class="text-xs text-gray-500">5 minutes ago</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Low stock alert</p>
                                            <p class="text-xs text-gray-500">10 minutes ago</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <a href="#"
                                        class="flex items-center px-4 py-3 text-blue-600 hover:bg-blue-50 transition-colors">
                                        <span class="text-sm font-medium">View all notifications</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Language Selector -->
                        <div class="relative hidden sm:block">
                            <button @click="toggleDropdown('language')"
                                class="flex items-center space-x-2 p-2 text-gray-700 hover:bg-gray-100 rounded-xl border border-gray-300 shadow-sm transition-all duration-200 hover:shadow-md">
                                <img :src="`/assets/flags/${languages[currentLang].flag}`"
                                    :alt="languages[currentLang].name" class="w-6 h-4 object-cover rounded-sm">
                                <span class="text-sm font-medium">{{ languages[currentLang].name }}</span>
                                <svg :class="[
                                    'w-5 h-5 text-gray-400 transition-transform duration-300',
                                    dropdowns.language ? 'rotate-180' : ''
                                ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Language Dropdown Menu -->
                            <div v-show="dropdowns.language" @click.away="closeDropdown('language')"
                                class="absolute right-0 mt-2 w-48 md:w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50 max-w-[800px]"
                                style="transition: all 0.2s ease;">

                                <div class="px-4 py-2 border-b border-gray-100">
                                    <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                            </path>
                                        </svg>
                                        Select Language
                                    </h3>
                                </div>

                                <button v-for="(lang, code) in languages" :key="code" @click="switchLanguage(code)"
                                    :class="[
                                        'flex items-center w-full px-4 py-3 text-gray-700 hover:bg-gray-50 transition-all duration-200 group',
                                        currentLang === code ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-500' : ''
                                    ]">
                                    <img :src="`/assets/flags/${lang.flag}`" :alt="lang.name"
                                        class="w-6 h-4 object-cover rounded-sm mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <span class="font-medium">{{ lang.name }}</span>
                                    <svg v-if="currentLang === code" class="w-4 h-4 ml-auto text-blue-500"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="toggleDropdown('profile')"
                                class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-100 transition-all duration-200 border border-gray-300 shadow-sm hover:shadow-md">
                                <img v-if="$page.props.auth.user.profile_image"
                                    :src="`/storage/${$page.props.auth.user.profile_image}`" alt="Profile"
                                    class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-200">
                                <div v-else
                                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full ring-2 ring-blue-200 flex items-center justify-center text-white text-sm font-bold">
                                    {{ getUserInitials($page.props.auth.user.name) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-gray-900">{{ $page.props.auth.user.name ||
                                        'Guest' }}</p>
                                    <p class="text-xs text-gray-500">{{ $page.props.auth.user.email ||
                                        'guest@example.com' }}</p>
                                </div>
                                <svg :class="[
                                    'w-4 h-4 text-gray-400 transition-transform duration-200',
                                    dropdowns.profile ? 'rotate-180' : ''
                                ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Profile Dropdown Menu -->
                            <div v-show="dropdowns.profile" @click.away="closeDropdown('profile')"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                                style="transition: all 0.2s ease;">

                                <Link :href="route('')"
                                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>My Profile</span>
                                </Link>

                                <Link href="#"
                                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Account Settings</span>
                                </Link>

                                <Link href="#"
                                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                    </path>
                                </svg>
                                <span>Lock Screen</span>
                                </Link>

                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form @submit.prevent="logout">
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            <span>Sign Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 container mx-auto mt-5 px-4 py-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
.sidebar {
    transition: transform 0.3s ease;
}

.menu-item {
    transition: all 0.2s ease;
}

.menu-item:hover {
    transform: translateX(2px);
}

.submenu-item {
    transition: all 0.2s ease;
}

.glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Scrollbar styling */
.sidebar::-webkit-scrollbar {
    width: 4px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 2px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.5);
}

/* Custom animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile responsiveness */
@media (max-width: 1024px) {
    .sidebar {
        z-index: 50;
    }
}
</style>