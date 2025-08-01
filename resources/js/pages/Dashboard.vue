<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import NavUser from '../components/NavUser.vue';

</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <!-- Background dengan pattern atau gradient -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">

        <!-- Universal Navbar -->
        <NavUser />

        <!-- Main Content -->
        <main class="pt-16">

            <!-- Hero Section -->
            <div class="relative overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
                    <div class="text-center">
                        <!-- Welcome Message -->
                        <h1 class="text-4xl sm:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                            Welcome to
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                Laravel App
                            </span>
                        </h1>

                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                            Build something amazing with modern web technologies.
                            Get started with our powerful and intuitive platform.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <template v-if="$page.props.auth?.user">
                                <!-- Authenticated User Actions -->
                                <Link
                                    :href="$page.props.auth.user.role === 'admin' ? route('admin.dashboard') : route('user.dashboard')"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                                    Go to Dashboard
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </Link>
                            </template>
                            <template v-else>
                                <!-- Guest User Actions -->
                                <Link :href="route('register')"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                                    Get Started Free
                                </Link>
                                <Link :href="route('login')"
                                    class="border border-gray-300 hover:border-gray-400 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:border-gray-500 px-8 py-3 rounded-lg font-semibold transition-colors">
                                    Sign In
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Background Decoration -->
                <div class="absolute inset-0 -z-10">
                    <div class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-blue-600/10 ring-1 ring-blue-50 dark:bg-gray-900 dark:ring-gray-800 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"></div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-24 sm:py-32 bg-white dark:bg-gray-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            Why Choose Us?
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                            Experience the power of modern web development with our feature-rich platform.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="text-center p-6">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Fast & Secure</h3>
                            <p class="text-gray-600 dark:text-gray-300">Built with performance and security in mind.</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="text-center p-6">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">User Friendly</h3>
                            <p class="text-gray-600 dark:text-gray-300">Intuitive interface designed for everyone.</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="text-center p-6">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Reliable</h3>
                            <p class="text-gray-600 dark:text-gray-300">99.9% uptime with enterprise-grade infrastructure.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-gray-600 dark:text-gray-300">
                    <p>&copy; 2025 Laravel App. All rights reserved.</p>
                </div>
            </div>
        </footer>



    </div>
</template>
