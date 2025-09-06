<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { LockOutlined, EyeOutlined, EyeInvisibleOutlined } from '@ant-design/icons-vue'
import { Button, Form, FormItem, Input } from 'ant-design-vue'
import { useNotifications } from '@/Composable/useNotifications'

const props = defineProps({
  status: String,
  token: String,
  user: Object
})

const form = useForm({
  token: props.token,
  email: props.user?.email || '',
  password: '',
  password_confirmation: '',
})

const { handleFormProcessing } = useNotifications()

// Apply notification handling to form
handleFormProcessing(
  form, 
  'Resetting your password...', // Processing message
  'Password has been reset successfully!', // Success message
  'Failed to reset password' // Error fallback message
)

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password"/>
    
    <div class="min-h-screen flex items-center py-12 px-4">
      <div class="max-w-[550px] w-full mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-8">
          <div class="text-center mb-8">
            <div class="text-2xl font-semibold text-default-700 mb-2">
              Reset Your Password 🔐
            </div>
            <h4 class="text-sm font-medium text-slate-500">
              Please enter your new password below
            </h4>
          </div>

          <div
            v-if="status"
            class="relative mb-4 p-3 bg-green-100 border border-green-200 rounded-md shadow-sm font-medium text-sm text-green-700"
          >
            {{ status }}
          </div>

          <!-- Display user email for confirmation -->
          <div class="mb-6 p-3 bg-blue-50 border border-blue-200 rounded-md">
            <p class="text-sm text-blue-700">
              <strong>Resetting password for:</strong> {{ user?.email }}
            </p>
          </div>

          <Form layout="vertical" @submit.prevent="submit" size="lg">
            <FormItem 
              label="New Password"
              :help="form.errors.password ? '' : 'Password must be at least 8 characters long'"
            >
              <Input
                size="large"
                id="password"
                :type="showPassword ? 'text' : 'password'"
                v-model:value="form.password"
                autocomplete="new-password"
                placeholder="Enter new password"
                :status="form.errors.password ? 'error' : ''"
                required
              >
                <template #prefix>
                  <LockOutlined class="opacity-30"/>
                </template>
                <template #suffix>
                  <span @click="showPassword = !showPassword" class="cursor-pointer">
                    <EyeOutlined v-if="!showPassword" class="opacity-60 hover:opacity-100" />
                    <EyeInvisibleOutlined v-else class="opacity-60 hover:opacity-100" />
                  </span>
                </template>
              </Input>
              <InputError class="text-left pt-1" :message="form.errors.password"/>
            </FormItem>

            <FormItem 
              label="Confirm New Password"
              :help="form.errors.password_confirmation ? '' : 'Please confirm your new password'"
            >
              <Input
                size="large"
                id="password_confirmation"
                :type="showConfirmPassword ? 'text' : 'password'"
                v-model:value="form.password_confirmation"
                autocomplete="new-password"
                placeholder="Confirm new password"
                :status="form.errors.password_confirmation ? 'error' : ''"
                required
              >
                <template #prefix>
                  <LockOutlined class="opacity-30"/>
                </template>
                <template #suffix>
                  <span @click="showConfirmPassword = !showConfirmPassword" class="cursor-pointer">
                    <EyeOutlined v-if="!showConfirmPassword" class="opacity-60 hover:opacity-100" />
                    <EyeInvisibleOutlined v-else class="opacity-60 hover:opacity-100" />
                  </span>
                </template>
              </Input>
              <InputError class="text-left pt-1" :message="form.errors.password_confirmation"/>
            </FormItem>

            <Button
              :loading="form.processing"
              :disabled="form.processing"
              htmlType="submit"
              type="primary"
              class="w-full mb-4"
              size="large"
            >
              {{ form.processing ? 'Resetting Password...' : 'Reset Password' }}
            </Button>

            <div class="text-center">
              <Link 
                :href="route('login')" 
                class="text-sm text-blue-600 hover:text-blue-800 font-medium"
              >
                ← Back to Login
              </Link>
            </div>
          </Form>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<style scoped>
/* Custom button loading state */
:deep(.ant-btn-loading-icon) {
  display: none !important;
}

/* Custom input focus styles */
:deep(.ant-input:focus) {
  border-color: rgb(59 130 246);
  box-shadow: 0 0 0 2px rgb(59 130 246 / 0.1);
}

:deep(.ant-input-affix-wrapper:focus) {
  border-color: rgb(59 130 246);
  box-shadow: 0 0 0 2px rgb(59 130 246 / 0.1);
}

/* Custom form item spacing */
:deep(.ant-form-item) {
  margin-bottom: 1.5rem;
}

/* Enhanced status message styling */
.status-message {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>