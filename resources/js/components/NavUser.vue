<script setup lang="ts">
import { type User } from '@/types';
import { usePage, Link, router } from '@inertiajs/vue3';
import { ChevronDown, Menu, X, User as UserIcon } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted, computed } from 'vue';

const page = usePage();
// Gunakan computed untuk reactivity yang lebih baik
const user = computed(() => page.props.auth?.user as User | null);
const isMobileMenuOpen = ref(false);
const isUserDropdownOpen = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleUserDropdown = () => {
    isUserDropdownOpen.value = !isUserDropdownOpen.value;
};

// Handle logout dengan cara yang lebih eksplisit
const handleLogout = () => {
    // Tutup semua dropdown/menu
    isMobileMenuOpen.value = false;
    isUserDropdownOpen.value = false;

    // Lakukan logout dengan redirect eksplisit
    router.post(route('logout'), {}, {
        onSuccess: () => {
            // Redirect ke halaman home atau login setelah logout berhasil
            router.visit('/', { replace: true });
        },
        onError: (errors) => {
            console.error('Logout error:', errors);
        }
    });
};

// Close dropdowns when clicking outside
const handleClickOutside = (event: Event) => {
    const target = event.target as HTMLElement;
    if (!target.closest('.user-dropdown-container')) {
        isUserDropdownOpen.value = false;
    }
    if (!target.closest('.mobile-menu-container')) {
        isMobileMenuOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <!-- Universal Navbar - Clean & Modern -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 dark:bg-gray-900/90 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <Link :href="user ? route('user.dashboard') : '/'" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">L</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            Laravel App
                        </span>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Navigation Links (for authenticated users) -->
                    <nav v-if="user" class="flex items-center space-x-6">
                        <Link :href="route('user.dashboard')"
                            class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium transition-colors">
                            Dashboard
                        </Link>
                        <Link href="#"
                            class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium transition-colors">
                            Features
                        </Link>
                        <Link href="#"
                            class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium transition-colors">
                            About
                        </Link>
                    </nav>

                    <!-- User Profile Dropdown (Authenticated) -->
                    <div v-if="user" class="relative user-dropdown-container">
                        <button
                            @click="toggleUserDropdown"
                            class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </span>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 font-medium text-sm hidden lg:block">
                                {{ user.name }}
                            </span>
                            <ChevronDown class="w-4 h-4 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': isUserDropdownOpen }" />
                        </button>

                        <!-- User Dropdown Menu -->
                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-95"
                        >
                            <div
                                v-show="isUserDropdownOpen"
                                class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2">
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ user.name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                                    <span class="inline-block mt-1 px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full capitalize">
                                        {{ user.role }}
                                    </span>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                    <Link :href="route('profile.edit')"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <UserIcon class="w-4 h-4 mr-3" />
                                        Profile Settings
                                    </Link>
                                    <Link :href="route('user.dashboard')"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                        </svg>
                                        Dashboard
                                    </Link>
                                    <Link href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        </svg>
                                        Settings
                                    </Link>
                                </div>

                                <!-- Logout dengan handler khusus -->
                                <div class="border-t border-gray-100 dark:border-gray-700">
                                    <button
                                        @click="handleLogout"
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Sign Out
                                    </button>
                                </div>
                            </div>
                        </Transition>
                    </div>

                    <!-- Guest Navigation -->
                    <nav v-else class="flex items-center space-x-4">
                        <Link :href="route('login')"
                            class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white px-4 py-2 text-sm font-medium transition-colors">
                            Sign In
                        </Link>
                        <Link :href="route('register')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Get Started
                        </Link>
                    </nav>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden mobile-menu-container">
                    <button
                        @click="toggleMobileMenu"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <Menu v-if="!isMobileMenuOpen" class="w-6 h-6 text-gray-700 dark:text-gray-300" />
                        <X v-else class="w-6 h-6 text-gray-700 dark:text-gray-300" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 -translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-1"
        >
            <div v-show="isMobileMenuOpen" class="md:hidden border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                <div class="px-4 py-6 space-y-4">
                    <!-- Authenticated Mobile Menu -->
                    <template v-if="user">
                        <!-- User Info Section -->
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-100 dark:border-gray-700">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 font-semibold">
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">{{ user.name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</div>
                                <span class="inline-block mt-1 px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full capitalize">
                                    {{ user.role }}
                                </span>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="space-y-2">
                            <Link :href="route('user.dashboard')"
                                class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                Dashboard
                            </Link>
                            <Link href="#"
                                class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                Features
                            </Link>
                            <Link href="#"
                                class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                About
                            </Link>
                            <Link :href="route('profile.edit')"
                                class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                Profile Settings
                            </Link>
                            <!-- Mobile logout dengan handler khusus -->
                            <button
                                @click="handleLogout"
                                class="block w-full text-left px-3 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                Sign Out
                            </button>
                        </div>
                    </template>

                    <!-- Guest Mobile Menu -->
                    <template v-else>
                        <div class="space-y-4">
                            <Link :href="route('login')"
                                class="block w-full text-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                Sign In
                            </Link>
                            <Link :href="route('register')"
                                class="block w-full text-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                Get Started
                            </Link>
                        </div>
                    </template>
                </div>
            </div>
        </Transition>
    </header>
</template>
