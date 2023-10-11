<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

defineOptions({
  layoutName: 'guest-layout',
})

interface ConfirmPasswordForm extends Record<string, unknown> {
  password: string
}

const model = useForm<ConfirmPasswordForm>({
  password: '',
})

const validation = reactiveComputed<{ [k in keyof Partial<ConfirmPasswordForm>]: 'error' | undefined }>(() => ({
  password: model.errors.password !== undefined ? 'error' : undefined,
}))

function submit() {
  model.post(route('password.confirm'), {
    onFinish: () => model.reset('email'),
  })
}
</script>

<template>
  <n-alert type="info">
    {{ $t('auth.notices.confirm-password') }}
  </n-alert>

  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <n-form-item
      path="password"
      :label="$t('auth.password.label')"
      :feedback="model.errors.password"
      :validation-status="validation.password"
      :label-props="{ for: 'password' }"
    >
      <n-input
        v-model:value="model.password"
        show-password-on="mousedown"
        type="password"
        :input-props="{ id: 'password', name: 'password' }"
        :placeholder="$t('auth.password.placeholder')"
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
      {{ $t('auth.actions.confirm') }}
    </n-button>
  </n-form>
</template>
