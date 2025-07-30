<script setup>
import { router, usePage } from '@inertiajs/vue3'

// Ambil user dari props inertia
const user = usePage().props.auth.user

// Fungsi logout
const logout = () => {
  router.post(route('logout'), {}, { preserveScroll: true })
}
</script>

<template>
  <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-800 dark:text-white flex flex-col items-center justify-center px-4">
    <h1 class="text-2xl font-semibold mb-4">Selamat Datang, {{ user.name }}</h1>
    <p class="mb-6">Anda login sebagai <strong>{{ user.role }}</strong></p>

    <button
      @click="logout"
      class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition"
    >
      Logout
    </button>
  </div>
</template>
