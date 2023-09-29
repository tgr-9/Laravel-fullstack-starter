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

function submit(e: Event) {
  const target = e.target as HTMLFormElement
  model.post(target.action, {
    onFinish: () => model.reset('email'),
  })
}
</script>

<template>
  <n-alert :title="$t('auth.routes.forgot-password')" type="info">
    {{ $t('auth.notices.forgot-password') }}
  </n-alert>

  <n-form :action="$route('password.email')" :model="model" class="form-login" @submit.prevent="submit">
    <n-form-item
      :label="$t('auth.email.label')"
      :feedback="model.errors.email"
      :validation-status="validation.email"
      :label-props="{ for: 'email' }"
      path="email"
    >
      <n-input
        v-model:value="model.email"
        :input-props="{ id: 'email', name: 'email', type: 'email' }"
        :placeholder="$t('auth.email.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
        :autofocus="true"
      />
    </n-form-item>

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
  </n-form>

  <i-link :href="$route('login')">
    {{ $t('auth.actions.login') }}
  </i-link>
</template>
