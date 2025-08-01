<script setup lang="ts">
import { type User } from '@/types';
import { usePage, Link, router } from '@inertiajs/vue3';
import {
    ChevronDown,
    Menu,
    X,
    User as UserIcon,
    Settings,
    LogOut,
    Sun,
    Moon,
    Monitor,
    Bell,
    Search,
    Sparkles,
    Zap
} from 'lucide-vue-next';
import { ref, onMounted, onUnmounted, computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user as User | null);
const isMobileMenuOpen = ref(false);
const isUserDropdownOpen = ref(false);
const isThemeDropdownOpen = ref(false);
const isSearchOpen = ref(false);
const currentTheme = ref('system');
const searchQuery = ref('');

// Theme management with enhanced animation
const themes = [
    { value: 'light', label: 'Light', icon: Sun, color: 'from-yellow-400 to-orange-500' },
    { value: 'dark', label: 'Dark', icon: Moon, color: 'from-purple-600 to-blue-600' },
    { value: 'system', label: 'Auto', icon: Monitor, color: 'from-gray-500 to-gray-700' }
];

const initializeTheme = () => {
    const savedTheme = localStorage.getItem('theme') || 'system';
    currentTheme.value = savedTheme;
    applyTheme(savedTheme);
};

const applyTheme = (theme: string) => {
    const html = document.documentElement;

    if (theme === 'system') {
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        html.setAttribute('data-theme', systemPrefersDark ? 'dark' : 'light');
    } else {
        html.setAttribute('data-theme', theme);
    }

    localStorage.setItem('theme', theme);
    currentTheme.value = theme;
};

const toggleTheme = (theme: string) => {
    applyTheme(theme);
    closeAllDropdowns();
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
    if (isMobileMenuOpen.value) {
        closeOtherDropdowns('mobile');
    }
};

const toggleUserDropdown = () => {
    isUserDropdownOpen.value = !isUserDropdownOpen.value;
    if (isUserDropdownOpen.value) {
        closeOtherDropdowns('user');
    }
};

const toggleThemeDropdown = () => {
    isThemeDropdownOpen.value = !isThemeDropdownOpen.value;
    if (isThemeDropdownOpen.value) {
        closeOtherDropdowns('theme');
    }
};

const toggleSearch = () => {
    isSearchOpen.value = !isSearchOpen.value;
    if (isSearchOpen.value) {
        closeOtherDropdowns('search');
        // Focus search input after animation
        setTimeout(() => {
            const searchInput = document.querySelector('#search-input') as HTMLInputElement;
            searchInput?.focus();
        }, 150);
    }
};

const closeOtherDropdowns = (except?: string) => {
    if (except !== 'mobile') isMobileMenuOpen.value = false;
    if (except !== 'user') isUserDropdownOpen.value = false;
    if (except !== 'theme') isThemeDropdownOpen.value = false;
    if (except !== 'search') isSearchOpen.value = false;
};

const closeAllDropdowns = () => {
    closeOtherDropdowns();
};

const handleLogout = () => {
    closeAllDropdowns();
    router.post(route('logout'), {}, {
        onSuccess: () => {
            router.visit('/', { replace: true });
        },
        onError: (errors) => {
            console.error('Logout error:', errors);
        }
    });
};

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        console.log('Searching for:', searchQuery.value);
        // Implement search logic here
        closeAllDropdowns();
    }
};

// Close dropdowns when clicking outside
const handleClickOutside = (event: Event) => {
    const target = event.target as HTMLElement;
    if (!target.closest('.navbar-dropdown') && !target.closest('.navbar-btn')) {
        closeAllDropdowns();
    }
};

// Handle system theme changes
const handleSystemThemeChange = (e: MediaQueryListEvent) => {
    if (currentTheme.value === 'system') {
        applyTheme('system');
    }
};

onMounted(() => {
    initializeTheme();
    document.addEventListener('click', handleClickOutside);

    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', handleSystemThemeChange);

    const handleEscape = (e: KeyboardEvent) => {
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    };
    document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.removeEventListener('change', handleSystemThemeChange);
});

// Navigation items with icons
const navigationItems = [
    { name: 'Home', href: '#', authOnly: false },
    { name: 'About', href: '#', authOnly: false },
    { name: 'Map', href: '#', authOnly: false, icon: Sparkles },
    { name: 'Statistik', href: '#', authOnly: true },
    { name: 'Laporan', href: '#', authOnly: true },
];

const userMenuItems = [
    { name: 'Profile Settings', href: 'profile.edit', icon: UserIcon, desc: 'Manage your account' }
];
</script>

<template>
    <!-- Ultra Modern Glassmorphic Navbar -->
    <div class="navbar bg-base-100/60 backdrop-blur-xl border-b border-base-content/10 fixed top-0 z-50 shadow-2xl shadow-base-content/5">
        <div class="navbar-start">
            <!-- Mobile menu button with enhanced animation -->
            <div class="lg:hidden">
                <button
                    @click="toggleMobileMenu"
                    class="navbar-btn btn btn-ghost btn-circle hover:bg-base-content/10 transition-all duration-300 hover:scale-110 active:scale-95"
                    :class="{ 'bg-base-content/10': isMobileMenuOpen }"
                >
                    <Menu v-if="!isMobileMenuOpen" class="w-5 h-5 transition-transform duration-300" />
                    <X v-else class="w-5 h-5 transition-transform duration-300 rotate-90" />
                </button>

                <!-- Enhanced Mobile Sliding Menu -->
                <div
                    v-if="isMobileMenuOpen"
                    class="navbar-dropdown fixed inset-0 top-16 bg-base-100/95 backdrop-blur-xl z-40 animate-slide-in-left"
                >
                    <div class="p-6 space-y-6 max-w-sm">
                        <!-- User profile card for mobile -->
                        <div v-if="user" class="card bg-gradient-to-br from-primary/20 to-secondary/20 backdrop-blur-sm border border-base-content/10">
                            <div class="card-body p-4">
                                <div class="flex items-center gap-4">
                                    <div class="avatar">
                                        <div class="w-16 rounded-full bg-gradient-to-br from-primary to-secondary p-0.5">
                                            <div class="w-full h-full bg-base-100 rounded-full flex items-center justify-center">
                                                <span class="text-xl font-bold bg-gradient-to-br from-primary to-secondary bg-clip-text text-transparent">
                                                    {{ user.name.charAt(0).toUpperCase() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg">{{ user.name }}</h3>
                                        <p class="text-sm opacity-70">{{ user.email }}</p>
                                        <div class="badge badge-primary badge-sm mt-1 capitalize">{{ user.role }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation items -->
                        <div class="space-y-2">
                            <template v-for="item in navigationItems" :key="item.name">
                                <Link
                                    v-if="!item.authOnly || user"
                                    :href="item.href.startsWith('#') ? item.href : route(item.href)"
                                    class="btn btn-ghost w-full justify-start gap-3 text-lg hover:bg-base-content/10 transition-all duration-300"
                                    @click="closeAllDropdowns"
                                >
                                    <component v-if="item.icon" :is="item.icon" class="w-5 h-5" />
                                    {{ item.name }}
                                </Link>
                            </template>
                        </div>

                        <!-- Theme selector -->
                        <div class="space-y-2">
                            <p class="text-sm font-medium opacity-70">Theme</p>
                            <div class="grid grid-cols-3 gap-2">
                                <button
                                    v-for="theme in themes"
                                    :key="theme.value"
                                    @click="toggleTheme(theme.value)"
                                    class="btn btn-sm gap-2 transition-all duration-300"
                                    :class="currentTheme === theme.value
                                        ? 'btn-primary'
                                        : 'btn-ghost hover:bg-base-content/10'"
                                >
                                    <component :is="theme.icon" class="w-4 h-4" />
                                    {{ theme.label }}
                                </button>
                            </div>
                        </div>

                        <!-- Auth actions -->
                        <div class="space-y-2 pt-4 border-t border-base-content/10">
                            <template v-if="user">
                                <Link
                                    v-for="item in userMenuItems"
                                    :key="item.name"
                                    :href="route(item.href)"
                                    class="btn btn-ghost w-full justify-start gap-3"
                                    @click="closeAllDropdowns"
                                >
                                    <component :is="item.icon" class="w-5 h-5" />
                                    {{ item.name }}
                                </Link>
                                <button
                                    @click="handleLogout"
                                    class="btn btn-error btn-outline w-full gap-3"
                                >
                                    <LogOut class="w-5 h-5" />
                                    Sign Out
                                </button>
                            </template>
                            <template v-else>
                                <Link :href="route('login')" class="btn btn-ghost w-full" @click="closeAllDropdowns">
                                    Sign In
                                </Link>
                                <Link :href="route('register')" class="btn btn-primary w-full" @click="closeAllDropdowns">
                                    Get Started
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Brand/Logo -->
            <Link
                :href="user ? route('user.dashboard') : '/'"
                class="btn btn-ghost hover:bg-transparent group transition-all duration-300 px-2"
            >
            <div class="ml-2 px-2 py-1 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full group-hover:from-primary/30 group-hover:to-secondary/30 transition-all duration-300">
                    <span class="text-lg font-bold text-primary  transition-colors duration-300">
                        Go
                    </span>
                </div>
                <span class="text-2xl font-black bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text  group-hover:scale-105 transition-all duration-300 tracking-tight">
                    Tracking
                </span>
            </Link>
        </div>

        <!-- Desktop Navigation with enhanced styling -->
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal gap-1">
                <template v-for="item in navigationItems" :key="item.name">
                    <li v-if="!item.authOnly || user">
                        <Link
                            :href="item.href.startsWith('#') ? item.href : route(item.href)"
                            class="font-medium hover:bg-base-content/10 transition-all duration-300 rounded-xl gap-2 hover:scale-105 active:scale-95"
                        >
                            <component v-if="item.icon" :is="item.icon" class="w-4 h-4" />
                            {{ item.name }}
                        </Link>
                    </li>
                </template>
            </ul>
        </div>

        <div class="navbar-end gap-2">
            <!-- Enhanced Search -->
            <div class="relative">
                <!-- Search toggle button -->
                <button
                    @click="toggleSearch"
                    class="navbar-btn btn btn-ghost btn-circle hover:bg-base-content/10 transition-all duration-300 hover:scale-110 active:scale-95 lg:hidden"
                    :class="{ 'bg-base-content/10': isSearchOpen }"
                >
                    <Search class="w-5 h-5" />
                </button>

                <!-- Desktop search bar (always visible) -->
                <div class="hidden lg:flex items-center">
                    <div class="form-control">
                        <div class="input-group">
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search..."
                                class="input input-sm w-32 bg-base-100/50 backdrop-blur-sm border-base-content/20 focus:border-primary focus:w-64 transition-all duration-300 mr-5"
                                @keyup.enter="handleSearch"
                            />
                            <button
                                @click="handleSearch"
                                class="btn btn-sm btn-primary"
                            >
                                <Search class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile search dropdown -->
                <div
                    v-if="isSearchOpen"
                    class="navbar-dropdown absolute right-0 top-full mt-2 w-80 bg-base-100/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-base-content/10 p-4 animate-scale-in lg:hidden"
                >
                    <div class="form-control">
                        <div class="input-group">
                            <input
                                id="search-input"
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search anything..."
                                class="input input-bordered w-full bg-base-100/50 backdrop-blur-sm border-base-content/20 focus:border-primary"
                                @keyup.enter="handleSearch"
                            />
                            <button
                                @click="handleSearch"
                                class="btn btn-primary"
                            >
                                <Search class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications (if user is authenticated) -->
            <button
                v-if="user"
                class="navbar-btn btn btn-ghost btn-circle hover:bg-base-content/10 transition-all duration-300 hover:scale-110 active:scale-95 indicator"
            >
                <span class="indicator-item badge badge-secondary badge-xs"></span>
                <Bell class="w-5 h-5" />
            </button>

            <!-- Enhanced Theme Toggle -->
            <div class="relative">
                <button
                    @click="toggleThemeDropdown"
                    class="navbar-btn btn btn-ghost btn-circle hover:bg-base-content/10 transition-all duration-300 hover:scale-110 active:scale-95"
                    :class="{ 'bg-base-content/10': isThemeDropdownOpen }"
                >
                    <component :is="themes.find(t => t.value === currentTheme)?.icon || Monitor" class="w-5 h-5" />
                </button>

                <div
                    v-if="isThemeDropdownOpen"
                    class="navbar-dropdown absolute right-0 top-full mt-2 w-48 bg-base-100/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-base-content/10 p-2 animate-scale-in"
                >
                    <button
                        v-for="theme in themes"
                        :key="theme.value"
                        @click="toggleTheme(theme.value)"
                        class="w-full flex items-center gap-3 p-3 rounded-xl transition-all duration-300 hover:bg-base-content/10"
                        :class="currentTheme === theme.value ? 'bg-primary text-primary-content' : ''"
                    >
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             :class="currentTheme === theme.value ? 'bg-primary-content/20' : 'bg-base-content/10'">
                            <component :is="theme.icon" class="w-4 h-4" />
                        </div>
                        <span class="font-medium">{{ theme.label }}</span>
                    </button>
                </div>
            </div>

            <!-- Enhanced User Menu -->
            <div v-if="user" class="relative">
                <button
                    @click="toggleUserDropdown"
                    class="navbar-btn btn btn-ghost btn-circle avatar hover:bg-base-content/10 transition-all duration-300 hover:scale-110 active:scale-95 p-1"
                    :class="{ 'bg-base-content/10': isUserDropdownOpen }"
                >
                    <div class="w-10 rounded-full bg-gradient-to-br from-primary to-secondary p-0.5">
                        <div class="w-full h-full bg-base-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold bg-gradient-to-br from-primary to-secondary bg-clip-text text-transparent">
                                {{ user.name.charAt(0).toUpperCase() }}
                            </span>
                        </div>
                    </div>
                </button>

                <div
                    v-if="isUserDropdownOpen"
                    class="navbar-dropdown absolute right-0 top-full mt-2 w-80 bg-base-100/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-base-content/10 p-4 animate-scale-in"
                >
                    <!-- User info header -->
                    <div class="flex items-center gap-4 p-3 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-xl mb-4">
                        <div class="avatar">
                            <div class="w-12 rounded-full bg-gradient-to-br from-primary to-secondary p-0.5">
                                <div class="w-full h-full bg-base-100 rounded-full flex items-center justify-center">
                                    <span class="font-bold bg-gradient-to-br from-primary to-secondary bg-clip-text text-transparent">
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold">{{ user.name }}</h3>
                            <p class="text-sm opacity-70">{{ user.email }}</p>
                            <div class="badge badge-primary badge-sm mt-1 capitalize">{{ user.role }}</div>
                        </div>
                    </div>

                    <!-- Menu items -->
                    <div class="space-y-1">
                        <Link
                            v-for="item in userMenuItems"
                            :key="item.name"
                            :href="route(item.href)"
                            class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 hover:bg-base-content/10 group"
                            @click="closeAllDropdowns"
                        >
                            <div class="w-8 h-8 rounded-lg bg-base-content/10 flex items-center justify-center group-hover:bg-primary group-hover:text-primary-content transition-all duration-300">
                                <component :is="item.icon" class="w-4 h-4" />
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ item.name }}</p>
                                <p class="text-xs opacity-60">{{ item.desc }}</p>
                            </div>
                        </Link>
                    </div>

                    <div class="divider my-2"></div>

                    <!-- Logout -->
                    <button
                        @click="handleLogout"
                        class="w-full flex items-center gap-3 p-3 rounded-xl transition-all duration-300 hover:bg-error/10 text-error group"
                    >
                        <div class="w-8 h-8 rounded-lg bg-error/10 flex items-center justify-center group-hover:bg-error group-hover:text-error-content transition-all duration-300">
                            <LogOut class="w-4 h-4" />
                        </div>
                        <span class="font-medium">Sign Out</span>
                    </button>
                </div>
            </div>

            <!-- Enhanced Guest Actions -->
            <template v-else>
                <Link :href="route('login')" class="btn btn-sm btn-ghost font-medium hover:bg-base-content/10 transition-all duration-300 hover:scale-105 active:scale-95">
                    Sign In
                </Link>
                <Link :href="route('register')" class="btn btn-sm btn-primary hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Get Started
                </Link>
            </template>
        </div>
    </div>

    <!-- Spacer -->
    <div class="h-16"></div>
</template>

<style scoped>
/* Enhanced animations */
@keyframes slide-in-left {
    from {
        opacity: 0;
        transform: translateX(-100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slide-in-top {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scale-in {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(-10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.animate-slide-in-left {
    animation: slide-in-left 0.3s ease-out;
}

.animate-slide-in-top {
    animation: slide-in-top 0.2s ease-out;
}

.animate-scale-in {
    animation: scale-in 0.2s ease-out;
}

/* Enhanced backdrop blur */
.navbar {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

/* Custom scrollbar */
.navbar-dropdown {
    scrollbar-width: thin;
    scrollbar-color: oklch(var(--bc) / 0.2) transparent;
}

.navbar-dropdown::-webkit-scrollbar {
    width: 4px;
}

.navbar-dropdown::-webkit-scrollbar-track {
    background: transparent;
}

.navbar-dropdown::-webkit-scrollbar-thumb {
    background: oklch(var(--bc) / 0.2);
    border-radius: 2px;
}

/* Gradient text support */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}

/* Enhanced focus states */
.navbar-btn:focus-visible {
    outline: 2px solid oklch(var(--p));
    outline-offset: 2px;
}
</style>
