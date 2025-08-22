<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Form/InputError.vue'
import {Head, Link, useForm} from '@inertiajs/vue3'
import { ref } from 'vue'
import {LockOutlined, UserOutlined, EyeOutlined, EyeInvisibleOutlined} from '@ant-design/icons-vue'
import {Button, Form, FormItem, Input, Checkbox} from 'ant-design-vue'

defineProps({
  canResetPassword: Boolean,
  status: String
})

const form = useForm({
  email: '',
  password: '',
  remember: false
})

const showPassword = ref(false)

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password')
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
              Welcome back! Please enter your details here...
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

      <FormItem label="Password">
        <Input
            size="large"
            id="password"
            :type="showPassword ? 'text' : 'password'"
            v-model:value="form.password"
            autocomplete="current-password"
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

      <div class="flex items-center justify-between mb-3 text-start">
        <Checkbox name="remember" v-model:checked="form.remember"
        >Remember me
        </Checkbox>
        <Link href="#">
          <Button type="link"  class="text-primary">
            Forgot your password?
          </Button>
        </Link>
      </div>

      <Button
          :loading="form.processing"
          htmlType="submit"
          type="primary"
          class="w-full"
          size="large"
      >
        Log in
          </Button>
        </Form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">OR</span>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-2 gap-3">
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
              <span class="sr-only">Sign in with Google</span>
              <img class="h-5 w-5 mr-2" src="https://www.google.com/favicon.ico" alt="Google">
              Google
            </a>
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
              <span class="sr-only">Sign in with GitHub</span>
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.14 18.196 20 14.44 20 10.017 20 4.484 15.522 0 10 0z" clip-rule="evenodd" />
              </svg>
              GitHub
            </a>
          </div>
        </div>

        <div class="mt-6 text-center text-sm">
          <span class="text-gray-600">Don't have an account?</span>
          <Link :href="route('register')" class="font-medium text-blue-600 hover:text-blue-500 ml-1">
            Sign up
          </Link>
        </div>
      </div>
    </div>
    </div>
  </GuestLayout>
</template>