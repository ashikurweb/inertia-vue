<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import {useForm} from '@inertiajs/vue3'
import {UserOutlined} from '@ant-design/icons-vue'
import {Button, Form, FormItem, Input} from 'ant-design-vue'
import {useNotifications} from '@/Composable/useNotifications'

defineProps({
  status: String
})

const form = useForm({
  email: '',
})


const {handleFormProcessing} = useNotifications()

// Apply notification handling to form
handleFormProcessing(
  form,
  'Processing your password reset...', 
  null, 
  'Failed to send reset link.', 
)

const submit = () => {
    form.post(route('password.email'), {
        onFinish: () => {
        form.reset('email')
        }
    })
}
</script>

<template>
  <GuestLayout>
    <Head title="Log in"/>
    
    <div class="min-h-screen flex items-center py-12 px-4">
      <div class="max-w-[550px] w-full mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-8">
          <div class="text-center mb-8">
            <div class="text-2xl font-semibold text-default-700 mb-2">
              Hey, Welcome back 👋
            </div>
            <h4 class="text-sm font-medium text-slate-500">
                Enter your email to reset your password
            </h4>
          </div>

    <div
        v-if="status"
        class="relative mb-4 p-2 bg-green-100 rounded-md shadow-md font-medium text-sm text-green-600"
    >
      {{ status }}
    </div>

    <Form layout="vertical" @submit.prevent="submit" size="lg">
      <FormItem label="Email">
        <Input
            size="large"
            id="email"
            type="email"
            v-model:value="form.email"
            autofocus
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

      <Button
          :loading="form.processing"
          htmlType="submit"
          type="primary"
          class="w-full"
          size="large"
      >
        Send Reset Link
          </Button>
        </Form>

        <div class="mt-6 text-center text-sm">
          <span class="text-gray-600">Remember your password?</span>
          <Link :href="route('login')" class="font-medium text-blue-600 hover:text-blue-500 ml-1">
            Sign in
          </Link>
        </div>
      </div>
    </div>
    </div>
  </GuestLayout>
</template>