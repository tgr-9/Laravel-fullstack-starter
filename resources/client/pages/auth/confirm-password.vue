<script setup lang="ts">
import { Head as iHead, useForm } from '@inertiajs/vue3'
import Layout from '~/layouts/guest-layout.vue'

defineOptions({
  layout: Layout,
  inheritAttrs: false,
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
    onFinish: () => model.reset('password'),
  })
}
</script>

<template>
  <i-head :title="$t('auth.routes.confirm-password')" />

  <div class="mb-4 text-sm text-gray-600">
    {{ $t('auth.notices.confirm-password') }}
  </div>

  <n-form :model="model" class="form-login" @submit.prevent="submit">
    <n-form-item
      :label="$t('auth.password.label')"
      :feedback="model.errors.password"
      :validation-status="validation.password"
      path="password"
    >
      <n-input
        id="password"
        v-model:value="model.password"
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
