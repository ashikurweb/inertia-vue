<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { LockOutlined, UserOutlined, EyeOutlined, EyeInvisibleOutlined } from '@ant-design/icons-vue'
import { Button, Form, FormItem, Input } from 'ant-design-vue'
import { useNotifications } from '@/Composable/useNotifications'

defineProps({
  status: String
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const { handleFormProcessing } = useNotifications()

// Apply notification handling to form
handleFormProcessing(
  form, 
  'Creating your account...', // Processing message
  'Account has been created successfully!', // Success message
  'Failed to create account' // Error fallback message
)

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const submit = () => {
  form.post(route('register.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Register"/>
    
    <div class="min-h-screen flex items-center py-12 px-4">
      <div class="max-w-[550px] w-full mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-8">
          <div class="text-center mb-8">
            <div class="text-2xl font-semibold text-default-700 mb-2">
              Hey, Welcome 👋
            </div>
            <h4 class="text-sm font-medium text-slate-500">
              Welcome! Please enter your details here...
            </h4>
          </div>

          <div
            v-if="status"
            class="relative mb-4 p-2 bg-green-100 rounded-md shadow-md font-medium text-sm text-green-600"
          >
            {{ status }}
          </div>

          <Form layout="vertical" @submit.prevent="submit" size="lg">
            <FormItem label="Name">
              <Input
                size="large"
                id="name"
                type="text"
                v-model:value="form.name"
                autofocus
                autocomplete="name"
                placeholder="Name"
                :status="form.errors.name ? 'error' : ''"
              >
                <template #prefix>
                  <UserOutlined class="opacity-30"/>
                </template>
              </Input>
              <InputError class="text-left pt-1" :message="form.errors.name"/>
            </FormItem>

            <FormItem label="Email">
              <Input
                size="large"
                id="email"
                type="email"
                v-model:value="form.email"
                autocomplete="email"
                placeholder="Email"
                :status="form.errors.email ? 'error' : ''"
              >
                <template #prefix>
                  <UserOutlined class="opacity-30"/>
                </template>
              </Input>
              <InputError class="text-left pt-1" :message="form.errors.email"/>
            </FormItem>

            <FormItem label="Password">
              <Input
                size="large"
                id="password"
                :type="showPassword ? 'text' : 'password'"
                v-model:value="form.password"
                autocomplete="new-password"
                placeholder="Password"
                :status="form.errors.password ? 'error' : ''"
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

            <FormItem label="Confirm Password">
              <Input
                size="large"
                id="password_confirmation"
                :type="showConfirmPassword ? 'text' : 'password'"
                v-model:value="form.password_confirmation"
                autocomplete="new-password"
                placeholder="Confirm Password"
                :status="form.errors.password_confirmation ? 'error' : ''"
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
              class="w-full"
              size="large"
            >
              {{ form.processing ? 'Creating Account...' : 'Register' }}
            </Button>
          </Form>

          <div class="mt-6 text-center text-sm">
            <span class="text-gray-600">Already have an account?</span>
            <Link :href="route('login')" class="font-medium text-blue-600 hover:text-blue-500 ml-1">
              Sign in
            </Link>
          </div>
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
</style>