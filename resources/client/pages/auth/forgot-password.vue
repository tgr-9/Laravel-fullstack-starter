<script setup lang="ts">
import { Link as iLink, useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

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
  model.post(route('password.email'), {
    onFinish: () => model.reset('email'),
  })
}
</script>

<template>
  <n-alert :title="$t('auth.routes.forgot-password')" type="info">
    {{ $t('auth.notices.forgot-password') }}
  </n-alert>

  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <n-form-item
      path="email"
      :label="$t('auth.email.label')"
      :feedback="model.errors.email"
      :validation-status="validation.email"
      :label-props="{ for: 'email' }"
    >
      <n-input
        v-model:value="model.email"
        :input-props="{ id: 'email', name: 'email', type: 'email', autocomplete: 'email' }"
        :placeholder="$t('auth.email.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
        :autofocus="true"
      />
    </n-form-item>

    <n-button
      attr-type="submit"
      class="w-full"
      type="primary"
      :disabled="model.processing"
      :loading="model.processing"
    >
      {{ $t('auth.actions.request') }}
    </n-button>
  </n-form>

  <i-link :href="$route('login')">
    {{ $t('auth.actions.login') }}
  </i-link>
</template>
