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

function submit(e: Event) {
  const target = e.target as HTMLFormElement
  model.post(target.action, {
    onFinish: () => model.reset('email'),
  })
}
</script>

<template>
  <n-alert type="info">
    {{ $t('auth.notices.confirm-password') }}
  </n-alert>

  <n-form :action="$route('password.confirm')" :model="model" class="form-login" @submit.prevent="submit">
    <n-form-item
      :label="$t('auth.password.label')"
      :feedback="model.errors.password"
      :validation-status="validation.password"
      :label-props="{ for: 'password' }"
      path="password"
    >
      <n-input
        v-model:value="model.password"
        :input-props="{ id: 'password', name: 'password' }"
        :placeholder="$t('auth.password.placeholder')"
        :loading="model.processing"
        :disabled="model.processing"
        :autofocus="true"
        show-password-on="mousedown"
        type="password"
        autocomplete="current-password"
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
      {{ $t('auth.actions.confirm') }}
    </n-button>
  </n-form>
</template>
