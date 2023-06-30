<script setup lang="ts">
import { Head as iHead, Link as iLink, useForm } from '@inertiajs/vue3'
import Layout from '~/layouts/guest-layout.vue'

defineOptions({
  layout: Layout,
})

const { errors: _ } = defineProps<{
  errors: Object
}>()

// const form = ref<FormInst | null>()

const values = useForm({
  email: '',
})

function submit() {
  values.post(route('password.email'))
}
</script>

<template>
  <i-head :title="$t('auth.routes.forgot-password')" />

  <n-card :title="$t('auth.routes.forgot-password')" size="medium" style="width: 450px; border-radius: 10px">
    <div class="mb-4 text-sm text-gray-600">
      {{ $t('auth.notices.forgot-password') }}
    </div>

    <n-form :model="values" class="form-login" @submit.prevent="submit">
      <n-form-item :label="$t('auth.email.label')" path="email">
        <n-input
          v-model:value="values.email"
          :placeholder="$t('auth.email.placeholder')"
          :loading="values.processing"
          :disabled="values.processing"
          :autofocus="true"
          attr-type="email"
          style="padding: 3px 10px; border-radius: 5px"
        />
      </n-form-item>

      <n-form-item class="form-button">
        <n-button
          type="primary"
          attr-type="submit"
          :disabled="values.processing"
          :loading="values.processing"
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
