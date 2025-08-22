<template>
    <Teleport to="body">
      <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 translate-y-4 scale-95"
        enter-to-class="opacity-100 translate-y-0 scale-100"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="opacity-100 translate-y-0 scale-100"
        leave-to-class="opacity-0 translate-y-4 scale-95"
      >
        <div
          v-if="visible"
          class="fixed top-6 right-6 z-50 w-full max-w-md pointer-events-auto"
        >
          <div
            class="relative flex items-center gap-4 p-4 rounded-xl backdrop-blur-md border shadow-2xl"
            :class="[
              type === 'success' 
                ? 'bg-white/90 border-emerald-200 shadow-emerald-500/10' 
                : type === 'error'
                ? 'bg-white/90 border-red-200 shadow-red-500/10'
                : 'bg-white/90 border-blue-200 shadow-blue-500/10'
            ]"
          >
            <!-- Left side icon/spinner -->
            <div class="flex-shrink-0 relative w-8 h-8 flex items-center justify-center">
              <!-- Processing Spinner -->
              <div
                v-if="type === 'processing'"
                class="w-6 h-6 border-2 border-blue-200 border-t-blue-500 rounded-full animate-spin"
              ></div>
              
              <!-- Success Icon -->
              <div
                v-else-if="type === 'success'"
                class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center animate-bounce-in"
              >
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
              
              <!-- Error Icon -->
              <div
                v-else-if="type === 'error'"
                class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center animate-bounce-in"
              >
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </div>
            </div>
  
            <!-- Message Content -->
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between">
                <div>
                  <p
                    class="font-semibold text-sm leading-5"
                    :class="[
                      type === 'success' ? 'text-emerald-700' :
                      type === 'error' ? 'text-red-700' :
                      'text-blue-700'
                    ]"
                  >
                    {{ title }}
                  </p>
                  <p
                    v-if="message"
                    class="text-sm leading-4 mt-1"
                    :class="[
                      type === 'success' ? 'text-emerald-600' :
                      type === 'error' ? 'text-red-600' :
                      'text-blue-600'
                    ]"
                  >
                    {{ message }}
                  </p>
                </div>
                
                <!-- Close button -->
                <button
                  v-if="type !== 'processing'"
                  @click="close"
                  class="ml-4 p-1 rounded-full transition-colors duration-200"
                  :class="[
                    type === 'success' 
                      ? 'text-emerald-500 hover:bg-emerald-100' 
                      : type === 'error'
                      ? 'text-red-500 hover:bg-red-100'
                      : 'text-blue-500 hover:bg-blue-100'
                  ]"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                  </svg>
                </button>
              </div>
            </div>
  
            <!-- Progress bar for processing -->
            <div
              v-if="type === 'processing'"
              class="absolute bottom-0 left-0 w-full h-1 bg-blue-100 rounded-b-xl overflow-hidden"
            >
              <div class="h-full bg-blue-500 animate-pulse rounded-b-xl"></div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </template>
  
  <script setup>
  import { ref, onMounted, watch, nextTick } from 'vue'
  
  const props = defineProps({
    type: {
      type: String,
      default: 'success', // 'success', 'error', 'processing'
      validator: (value) => ['success', 'error', 'processing'].includes(value)
    },
    title: {
      type: String,
      required: true
    },
    message: {
      type: String,
      default: ''
    },
    duration: {
      type: Number,
      default: 5000
    },
    persistent: {
      type: Boolean,
      default: false
    }
  })
  
  const emit = defineEmits(['close'])
  
  const visible = ref(false)
  let timeoutId = null
  
  const show = () => {
    visible.value = true
    
    // Auto hide for non-processing notifications
    if (props.type !== 'processing' && !props.persistent && props.duration > 0) {
      clearTimeout(timeoutId)
      timeoutId = setTimeout(() => {
        close()
      }, props.duration)
    }
  }
  
  const close = () => {
    visible.value = false
    clearTimeout(timeoutId)
    
    // Wait for transition to complete before emitting
    setTimeout(() => {
      emit('close')
    }, 300)
  }
  
  // Watch for type changes to handle processing -> success/error transition
  watch(() => props.type, (newType, oldType) => {
    if (oldType === 'processing' && newType !== 'processing') {
      // Clear any existing timeout and set new auto-hide for success/error
      clearTimeout(timeoutId)
      if (!props.persistent && props.duration > 0) {
        timeoutId = setTimeout(() => {
          close()
        }, props.duration)
      }
    }
  })
  
  onMounted(() => {
    nextTick(() => {
      show()
    })
  })
  
  // Expose methods for parent component
  defineExpose({
    show,
    close
  })
  </script>
  
  <style scoped>
  @keyframes bounce-in {
    0% { transform: scale(0) }
    50% { transform: scale(1.2) }
    100% { transform: scale(1) }
  }
  
  .animate-bounce-in {
    animation: bounce-in 0.6s ease-out;
  }
  </style>