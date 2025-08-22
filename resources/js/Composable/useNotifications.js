import { ref, readonly } from 'vue'
import { usePage } from '@inertiajs/vue3'

// Global notification state
const notifications = ref([])
let notificationId = 0

export const useNotifications = () => {
  const page = usePage()

  // Add a new notification
  const addNotification = (notification) => {
    const id = ++notificationId
    const newNotification = {
      id,
      type: 'success',
      title: 'Success',
      message: '',
      duration: 5000,
      persistent: false,
      ...notification
    }

    notifications.value.push(newNotification)
    return id
  }

  // Remove a notification by id
  const removeNotification = (id) => {
    const index = notifications.value.findIndex(n => n.id === id)
    if (index > -1) {
      notifications.value.splice(index, 1)
    }
  }

  // Update an existing notification
  const updateNotification = (id, updates) => {
    const notification = notifications.value.find(n => n.id === id)
    if (notification) {
      Object.assign(notification, updates)
    }
  }

  // Clear all notifications
  const clearAll = () => {
    notifications.value = []
  }

  // Show success notification
  const notifySuccess = (title, message = '', options = {}) => {
    return addNotification({
      type: 'success',
      title,
      message,
      ...options
    })
  }

  // Show error notification
  const notifyError = (title, message = '', options = {}) => {
    return addNotification({
      type: 'error',
      title,
      message,
      ...options
    })
  }

  // Show processing notification
  const notifyProcessing = (title, message = '', options = {}) => {
    return addNotification({
      type: 'processing',
      title,
      message,
      persistent: true,
      ...options
    })
  }

  // Handle form processing states
  const handleFormProcessing = (form, processingMessage = 'Processing...', successMessage = null, errorMessage = null) => {
    let processingNotificationId = null

    // Start processing notification when form starts processing
    if (form.processing && !processingNotificationId) {
      processingNotificationId = notifyProcessing(processingMessage)
    }

    // Handle form completion
    const originalPost = form.post
    const originalPut = form.put
    const originalPatch = form.patch
    const originalDelete = form.delete

    const wrapFormMethod = (originalMethod) => {
      return (...args) => {
        // Show processing notification
        processingNotificationId = notifyProcessing(processingMessage)

        // Get the options object (last argument)
        const options = args[args.length - 1] || {}
        const originalOnSuccess = options.onSuccess
        const originalOnError = options.onError
        const originalOnFinish = options.onFinish

        // Wrap onSuccess
        options.onSuccess = (page) => {
          if (processingNotificationId) {
            removeNotification(processingNotificationId)
            processingNotificationId = null
          }

          // Show success message from controller or default
          const controllerMessage = page.props?.flash?.success
          if (controllerMessage || successMessage) {
            notifySuccess('Success', controllerMessage || successMessage)
          }

          if (originalOnSuccess) {
            originalOnSuccess(page)
          }
        }

        // Wrap onError
        options.onError = (errors) => {
          if (processingNotificationId) {
            removeNotification(processingNotificationId)
            processingNotificationId = null
          }

          // Show error message
          const firstErrorMessage = Object.values(errors)[0]
          notifyError('Error', errorMessage || firstErrorMessage || 'An error occurred')

          if (originalOnError) {
            originalOnError(errors)
          }
        }

        // Wrap onFinish to cleanup if needed
        options.onFinish = (visit) => {
          if (processingNotificationId) {
            removeNotification(processingNotificationId)
            processingNotificationId = null
          }

          if (originalOnFinish) {
            originalOnFinish(visit)
          }
        }

        // Update the options in args
        args[args.length - 1] = options

        return originalMethod.apply(form, args)
      }
    }

    // Wrap form methods
    form.post = wrapFormMethod(originalPost)
    form.put = wrapFormMethod(originalPut)
    form.patch = wrapFormMethod(originalPatch)
    form.delete = wrapFormMethod(originalDelete)

    return form
  }

  // Check for flash messages from Laravel and show notifications
  const checkFlashMessages = () => {
    const flash = page.props.flash || {}
    
    if (flash.success) {
      notifySuccess('Success', flash.success)
    }
    
    if (flash.error) {
      notifyError('Error', flash.error)
    }

    if (flash.info) {
      addNotification({
        type: 'info',
        title: 'Info',
        message: flash.info
      })
    }
  }

  return {
    notifications: readonly(notifications),
    addNotification,
    removeNotification,
    updateNotification,
    clearAll,
    notifySuccess,
    notifyError,
    notifyProcessing,
    handleFormProcessing,
    checkFlashMessages
  }
}