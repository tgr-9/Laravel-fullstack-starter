<script setup lang="ts">
import { Head as iHead, Link as iLink, useForm } from '@inertiajs/vue3'
import Layout from '~/layouts/guest-layout.vue'

defineOptions({
  layout: Layout,
})

const { errors: _ } = defineProps<{
  errors: Object
}>()

interface ForgotPasswordForm extends Record<string, unknown> {
  email: string
}

const model = useForm<ForgotPasswordForm>({
  email: '',
})

const validation = reactiveComputed<{ [k in keyof Partial<ForgotPasswordForm>]: 'error' | undefined }>(() => ({
  email: model.errors.email !== undefined ? 'error' : undefined,
}))

function submit() {
  model.post(route('password.email'))
}
</script>

<template>
  <i-head :title="$t('auth.routes.forgot-password')" />

  <n-card :title="$t('auth.routes.forgot-password')" size="medium">
    <div class="mb-4 text-sm text-gray-600">
      {{ $t('auth.notices.forgot-password') }}
    </div>

    <n-form :model="model" class="form-login" @submit.prevent="submit">
      <n-form-item
        :label="$t('auth.email.label')"
        :feedback="model.errors.email"
        :validation-status="validation.email"
        path="email"
      >
        <n-input
          id="email"
          v-model:value="model.email"
          :placeholder="$t('auth.email.placeholder')"
          :loading="model.processing"
          :disabled="model.processing"
          :autofocus="true"
        />
      </n-form-item>

      <n-form-item class="form-button">
        <n-button
          type="primary"
          attr-type="submit"
          :disabled="model.processing"
          :loading="model.processing"
          style="width: 100%;"
          @click="submit"
        >
          {{ $t('auth.actions.request') }}
        </n-button>
      </n-form-item>

      <i-link :href="$route('login')">
        {{ $t('auth.actions.login') }}
      </i-link>
    </n-form>
  </n-card>
</template>
