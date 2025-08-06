<script setup lang="ts">
import { type User } from '@/types';
import { usePage, Link, router } from '@inertiajs/vue3';
import {
    ChevronDown,
    Menu,
    X,
    User as UserIcon,
    LogOut,
    Sun,
    Moon,
    Monitor,
    Bell,
    Search,
    MapPin,
    Info,
    AlertTriangle,
    Check,
    Clock
} from 'lucide-vue-next';
import { ref, onMounted, onUnmounted, computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user as User | null);
const isMobileMenuOpen = ref(false);
const isUserDropdownOpen = ref(false);
const isThemeDropdownOpen = ref(false);
const isSearchOpen = ref(false);
const isNotificationOpen = ref(false);
const currentTheme = ref('system');
const searchQuery = ref('');

// Navbar scroll effect
const isScrolled = ref(false);
const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};

// Notification system
const notifications = ref([
    {
        id: 1,
        type: 'success',
        title: 'Map Updated',
        message: 'New location data has been added to the tracking map',
        time: '2 minutes ago',
        read: false,
        icon: MapPin,
        color: 'text-success'
    },
    {
        id: 2,
        type: 'info',
        title: 'System Maintenance',
        message: 'Scheduled maintenance will occur tonight at 2 AM',
        time: '1 hour ago',
        read: false,
        icon: Info,
        color: 'text-info'
    },
    {
        id: 3,
        type: 'warning',
        title: 'Data Sync Alert',
        message: 'Some tracking data may be delayed due to network issues',
        time: '3 hours ago',
        read: true,
        icon: AlertTriangle,
        color: 'text-warning'
    }
]);

const unreadCount = computed(() =>
    notifications.value.filter(n => !n.read).length
);

const markAsRead = (id: number) => {
    const notification = notifications.value.find(n => n.id === id);
    if (notification) {
        notification.read = true;
    }
};

const markAllAsRead = () => {
    notifications.value.forEach(n => n.read = true);
};

const removeNotification = (id: number) => {
    const index = notifications.value.findIndex(n => n.id === id);
    if (index > -1) {
        notifications.value.splice(index, 1);
    }
};

const clearAllNotifications = () => {
    notifications.value = [];
};

// Theme management
const themes = [
    { value: 'light', label: 'Light', icon: Sun },
    { value: 'dark', label: 'Dark', icon: Moon },
    { value: 'system', label: 'Auto', icon: Monitor }
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

const toggleNotificationDropdown = () => {
    isNotificationOpen.value = !isNotificationOpen.value;
    if (isNotificationOpen.value) {
        closeOtherDropdowns('notification');
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
    if (except !== 'notification') isNotificationOpen.value = false;
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
    window.addEventListener('scroll', handleScroll);

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
    window.removeEventListener('scroll', handleScroll);

    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.removeEventListener('change', handleSystemThemeChange);
});

// Navigation items
const navigationItems = [
    {
        name: 'Home',
        getHref: () => user.value ? route('user.dashboard') : '/',
        authOnly: false
    },
    {
        name: 'About',
        getHref: () => route('user.about'),
        authOnly: false
    },
    {
        name: 'Map',
        getHref: () => route('user.map'),
        authOnly: false
    },
    {
        name: 'Statistik',
        getHref: () => route('user.statistic'),
        authOnly: true
    },
    {
        name: 'Laporan',
        getHref: () => route('user.report'),
        authOnly: true
    },
];

const userMenuItems = [
    { name: 'Profile Settings', href: 'profile.edit', icon: UserIcon, desc: 'Manage your account' }
];
</script>

<template>
    <!-- Full Screen Background Image Container -->
    <div class="hero-background">
        <!-- Ultra Modern Glassmorphic Navbar (Fixed Position with Enhanced Transparency) -->
        <div class="navbar-glass fixed top-0 z-50 w-full transition-all duration-500"
             :class="isScrolled ? 'bg-black/70 backdrop-blur-xl border-b border-white/20 shadow-2xl' : 'bg-transparent backdrop-blur-sm'">
            <div class="container mx-auto px-4">
                <div class="navbar">
                    <div class="navbar-start">
                        <!-- Mobile menu button with enhanced animation (only show if user exists) -->
                        <div class="lg:hidden" v-if="user">
                            <button
                                @click="toggleMobileMenu"
                                class="navbar-btn btn btn-ghost btn-circle hover:bg-white/20 transition-all duration-300 hover:scale-110 active:scale-95 text-white border-white/20"
                                :class="{ 'bg-white/20': isMobileMenuOpen }"
                            >
                                <Menu v-if="!isMobileMenuOpen" class="w-5 h-5 transition-transform duration-300 text-white" />
                                <X v-else class="w-5 h-5 transition-transform duration-300 rotate-90 text-white" />
                            </button>

                            <!-- Enhanced Mobile Sliding Menu -->
                            <div
                                v-if="isMobileMenuOpen"
                                class="navbar-dropdown fixed inset-0 top-16 bg-black/95 backdrop-blur-xl z-40 animate-slide-in-left"
                            >
                                <div class="p-6 space-y-6 max-w-sm">
                                    <!-- User profile card for mobile -->
                                    <div v-if="user" class="card bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/20">
                                        <div class="card-body p-4">
                                            <div class="flex items-center gap-4">
                                                <div class="avatar">
                                                    <div class="w-16 rounded-full bg-gradient-to-br from-primary to-secondary p-0.5">
                                                        <div class="w-full h-full bg-white rounded-full flex items-center justify-center">
                                                            <span class="text-xl font-bold bg-gradient-to-br from-primary to-secondary bg-clip-text text-transparent">
                                                                {{ user.name.charAt(0).toUpperCase() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-lg text-white">{{ user.name }}</h3>
                                                    <p class="text-sm text-white/70">{{ user.email }}</p>
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
                                                :href="item.getHref()"
                                                class="btn btn-ghost w-full justify-start gap-3 text-lg hover:bg-white/20 transition-all duration-300 text-white border-white/10"
                                                @click="closeAllDropdowns"
                                            >
                                                {{ item.name }}
                                            </Link>
                                        </template>
                                    </div>

                                    <!-- Theme selector (only if user exists) -->
                                    <div class="space-y-2" v-if="user">
                                        <p class="text-sm font-medium text-white/70">Theme</p>
                                        <div class="grid grid-cols-3 gap-2">
                                            <button
                                                v-for="theme in themes"
                                                :key="theme.value"
                                                @click="toggleTheme(theme.value)"
                                                class="btn btn-sm gap-2 transition-all duration-300 text-white border-white/20"
                                                :class="currentTheme === theme.value
                                                    ? 'btn-primary'
                                                    : 'btn-ghost hover:bg-white/20'"
                                            >
                                                <component :is="theme.icon" class="w-4 h-4" />
                                                {{ theme.label }}
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Auth actions -->
                                    <div class="space-y-2 pt-4 border-t border-white/20">
                                        <template v-if="user">
                                            <Link
                                                v-for="item in userMenuItems"
                                                :key="item.name"
                                                :href="route(item.href)"
                                                class="btn btn-ghost w-full justify-start gap-3 text-white hover:bg-white/20"
                                                @click="closeAllDropdowns"
                                            >
                                                <component :is="item.icon" class="w-5 h-5" />
                                                {{ item.name }}
                                            </Link>
                                            <button
                                                @click="handleLogout"
                                                class="btn btn-error btn-outline w-full gap-3 border-red-400 text-red-400 hover:bg-red-400 hover:text-white"
                                            >
                                                <LogOut class="w-5 h-5" />
                                                Sign Out
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Brand/Logo with Glass Effect -->
                        <Link
                            :href="user ? route('user.dashboard') : '/'"
                            class="btn btn-ghost hover:bg-white/10 group transition-all duration-300 px-2"
                        >
                            <div class="ml-2 px-2 py-1 bg-white/10 backdrop-blur-sm rounded-full group-hover:bg-white/20 transition-all duration-300 border border-white/20">
                                <span class="text-lg font-bold text-white transition-colors duration-300">
                                    Go
                                </span>
                            </div>
                            <span class="text-2xl font-black bg-gradient-to-r from-white via-blue-200 to-purple-200 bg-clip-text text-transparent group-hover:scale-105 transition-all duration-300 tracking-tight">
                                Tracking
                            </span>
                        </Link>
                    </div>

                    <!-- Desktop Navigation with enhanced glass styling -->
                    <div class="navbar-center hidden lg:flex ">
                        <ul class="menu menu-horizontal gap-2">
                            <template v-for="item in navigationItems" :key="item.name">
                                <li v-if="!item.authOnly || user">
                                    <Link
                                        :href="item.getHref()"
                                        class="font-medium hover:bg-white/20 transition-all duration-300 rounded-xl hover:scale-105 active:scale-95 px-4 text-white hover:text-white  border border-transparent hover:border-white/20 "
                                    >
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="navbar-end gap-2">
                        <!-- Enhanced Search (only show if user exists) -->
                        <div class="relative" v-if="user">
                            <!-- Search toggle button -->
                            <button
                                @click="toggleSearch"
                                class="navbar-btn btn btn-ghost btn-circle hover:bg-white/20 transition-all duration-300 hover:scale-110 active:scale-95 lg:hidden text-white border-white/20"
                                :class="{ 'bg-white/20': isSearchOpen }"
                            >
                                <Search class="w-5 h-5" />
                            </button>

                            <!-- Desktop search bar with glass effect -->
                            <div class="hidden lg:flex items-center">
                                <div class="form-control">
                                    <div class="input-group">
                                        <input
                                            v-model="searchQuery"
                                            type="text"
                                            placeholder="Search..."
                                            class="input input-sm w-32 bg-white/10 backdrop-blur-sm border-white/30 focus:border-white focus:w-64 transition-all duration-300 mr-5 text-white placeholder:text-white/70"
                                            @keyup.enter="handleSearch"
                                        />
                                        <button
                                            @click="handleSearch"
                                            class="btn btn-sm btn-primary bg-white/20 border-white/30 text-white hover:bg-white/30"
                                        >
                                            <Search class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile search dropdown with glass effect -->
                            <div
                                v-if="isSearchOpen"
                                class="navbar-dropdown absolute right-0 top-full mt-2 w-80 bg-black/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-4 animate-scale-in lg:hidden"
                            >
                                <div class="form-control">
                                    <div class="input-group">
                                        <input
                                            id="search-input"
                                            v-model="searchQuery"
                                            type="text"
                                            placeholder="Search anything..."
                                            class="input input-bordered w-full bg-white/10 backdrop-blur-sm border-white/30 focus:border-white text-white placeholder:text-white/70"
                                            @keyup.enter="handleSearch"
                                        />
                                        <button
                                            @click="handleSearch"
                                            class="btn btn-primary bg-white/20 border-white/30 text-white hover:bg-white/30"
                                        >
                                            <Search class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Notifications with Glass Dropdown -->
                        <div class="relative" v-if="user">
                            <button
                                @click="toggleNotificationDropdown"
                                class="navbar-btn btn btn-ghost btn-circle hover:bg-white/20 transition-all duration-300 hover:scale-110 active:scale-95 indicator text-white border-white/20"
                                :class="{ 'bg-white/20': isNotificationOpen }"
                            >
                                <span
                                    v-if="unreadCount > 0"
                                    class="indicator-item badge badge-secondary badge-xs animate-pulse bg-red-500 border-none"
                                >
                                    {{ unreadCount > 9 ? '9+' : unreadCount }}
                                </span>
                                <Bell class="w-5 h-5" :class="{ 'animate-bounce': unreadCount > 0 }" />
                            </button>

                            <!-- Notification Dropdown with Glass Effect -->
                            <div
                                v-if="isNotificationOpen"
                                class="navbar-dropdown absolute right-0 top-full mt-2 w-96 bg-black/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 animate-scale-in max-h-96 overflow-hidden"
                            >
                                <!-- Header -->
                                <div class="flex items-center justify-between p-4 border-b border-white/20">
                                    <div class="flex items-center gap-2">
                                        <Bell class="w-5 h-5 text-white" />
                                        <h3 class="font-bold text-lg text-white">Notifications</h3>
                                        <span v-if="unreadCount > 0" class="badge badge-secondary badge-sm bg-red-500 border-none text-white">
                                            {{ unreadCount }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button
                                            v-if="unreadCount > 0"
                                            @click="markAllAsRead"
                                            class="btn btn-ghost btn-xs hover:bg-white/20 text-white"
                                            title="Mark all as read"
                                        >
                                            <Check class="w-4 h-4" />
                                        </button>
                                        <button
                                            v-if="notifications.length > 0"
                                            @click="clearAllNotifications"
                                            class="btn btn-ghost btn-xs hover:bg-red-500/20 text-red-400"
                                            title="Clear all"
                                        >
                                            <X class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>

                                <!-- Notifications List -->
                                <div class="max-h-80 overflow-y-auto custom-scrollbar">
                                    <template v-if="notifications.length > 0">
                                        <div
                                            v-for="notification in notifications"
                                            :key="notification.id"
                                            class="p-4 border-b border-white/10 hover:bg-white/10 transition-all duration-200 group"
                                            :class="{ 'bg-white/5': !notification.read }"
                                        >
                                            <div class="flex items-start gap-3">
                                                <!-- Icon -->
                                                <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center mt-1"
                                                     :class="notification.read ? 'bg-white/20' : 'bg-white/30'">
                                                    <component
                                                        :is="notification.icon"
                                                        class="w-4 h-4"
                                                        :class="notification.read ? 'text-white/60' : 'text-white'"
                                                    />
                                                </div>

                                                <!-- Content -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <h4 class="font-semibold text-sm truncate"
                                                            :class="notification.read ? 'text-white/80' : 'text-white'">
                                                            {{ notification.title }}
                                                        </h4>
                                                        <div class="flex items-center gap-1 flex-shrink-0">
                                                            <div v-if="!notification.read" class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                            <button
                                                                @click="removeNotification(notification.id)"
                                                                class="btn btn-ghost btn-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-500/20 text-red-400"
                                                            >
                                                                <X class="w-3 h-3" />
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <p class="text-sm mt-1 line-clamp-2"
                                                       :class="notification.read ? 'text-white/60' : 'text-white/80'">
                                                        {{ notification.message }}
                                                    </p>
                                                    <div class="flex items-center justify-between mt-2">
                                                        <div class="flex items-center gap-1 text-xs text-white/50">
                                                            <Clock class="w-3 h-3" />
                                                            {{ notification.time }}
                                                        </div>
                                                        <button
                                                            v-if="!notification.read"
                                                            @click="markAsRead(notification.id)"
                                                            class="btn btn-ghost btn-xs hover:bg-white/20 text-white/70 hover:text-white"
                                                        >
                                                            Mark as read
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Empty state -->
                                    <div v-else class="p-8 text-center">
                                        <Bell class="w-12 h-12 mx-auto text-white/30 mb-4" />
                                        <h3 class="font-semibold text-white/60 mb-2">No notifications</h3>
                                        <p class="text-sm text-white/50">You're all caught up! Check back later for updates.</p>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div v-if="notifications.length > 0" class="p-3 border-t border-white/20">
                                    <button class="btn btn-ghost btn-sm w-full hover:bg-white/20 text-white">
                                        View All Notifications
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Theme Toggle with Glass Effect -->
                        <div class="relative" v-if="user">
                            <button
                                @click="toggleThemeDropdown"
                                class="navbar-btn btn btn-ghost btn-circle hover:bg-white/20 transition-all duration-300 hover:scale-110 active:scale-95 text-white border-white/20"
                                :class="{ 'bg-white/20': isThemeDropdownOpen }"
                            >
                                <component :is="themes.find(t => t.value === currentTheme)?.icon || Monitor" class="w-5 h-5" />
                            </button>

                            <div
                                v-if="isThemeDropdownOpen"
                                class="navbar-dropdown absolute right-0 top-full mt-2 w-48 bg-black/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-2 animate-scale-in"
                            >
                                <button
                                    v-for="theme in themes"
                                    :key="theme.value"
                                    @click="toggleTheme(theme.value)"
                                    class="w-full flex items-center gap-3 p-3 rounded-xl transition-all duration-300 hover:bg-white/20 text-white"
                                    :class="currentTheme === theme.value ? 'bg-white/30 text-white' : ''"
                                >
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                         :class="currentTheme === theme.value ? 'bg-white/30' : 'bg-white/10'">
                                        <component :is="theme.icon" class="w-4 h-4" />
                                    </div>
                                    <span class="font-medium">{{ theme.label }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Enhanced User Menu with Glass Effect -->
                        <div v-if="user" class="relative">
                            <button
                                @click="toggleUserDropdown"
                                class="navbar-btn btn btn-ghost btn-circle avatar hover:bg-white/20 transition-all duration-300 hover:scale-110 active:scale-95 p-1 border-white/20"
                                :class="{ 'bg-white/20': isUserDropdownOpen }"
                            >
                                <div class="w-10 rounded-full bg-gradient-to-br from-white/30 to-white/10 p-0.5 backdrop-blur-sm">
                                    <div class="w-full h-full bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30">
                                        <span class="text-sm font-bold text-white">
                                            {{ user.name.charAt(0).toUpperCase() }}
                                        </span>
                                    </div>
                                </div>
                            </button>

                            <div
                                v-if="isUserDropdownOpen"
                                class="navbar-dropdown absolute right-0 top-full mt-2 w-80 bg-black/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-4 animate-scale-in"
                            >
                                <!-- User info header -->
                                <div class="flex items-center gap-4 p-3 bg-white/10 backdrop-blur-sm rounded-xl mb-4 border border-white/20">
                                    <div class="avatar">
                                        <div class="w-12 rounded-full bg-gradient-to-br from-white/30 to-white/10 p-0.5">
                                            <div class="w-full h-full bg-white/20 rounded-full flex items-center justify-center">
                                                <span class="font-bold text-white">
                                                    {{ user.name.charAt(0).toUpperCase() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-white">{{ user.name }}</h3>
                                        <p class="text-sm text-white/70">{{ user.email }}</p>
                                        <div class="badge badge-primary badge-sm mt-1 capitalize bg-white/20 border-white/30 text-white">{{ user.role }}</div>
                                    </div>
                                </div>

                                <!-- Menu items -->
                                <div class="space-y-1">
                                    <Link
                                        v-for="item in userMenuItems"
                                        :key="item.name"
                                        :href="route(item.href)"
                                        class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 hover:bg-white/20 group"
                                        @click="closeAllDropdowns"
                                    >
                                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
                                            <component :is="item.icon" class="w-4 h-4 text-white" />
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-white">{{ item.name }}</p>
                                            <p class="text-xs text-white/60">{{ item.desc }}</p>
                                        </div>
                                    </Link>
                                </div>

                                <div class="divider my-2 border-white/20"></div>

                                <!-- Logout -->
                                <button
                                    @click="handleLogout"
                                    class="w-full flex items-center gap-3 p-3 rounded-xl transition-all duration-300 hover:bg-red-500/20 text-red-400 group"
                                >
                                    <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-all duration-300">
                                        <LogOut class="w-4 h-4" />
                                    </div>
                                    <span class="font-medium">Sign Out</span>
                                </button>
                            </div>
                        </div>

                        <!-- Enhanced Guest Actions with Glass Effect -->
                        <template v-else>
                            <div class="flex items-center gap-3">
                                <Link :href="route('login')" class="btn btn-sm btn-ghost font-medium hover:bg-white/20 transition-all duration-300 hover:scale-105 active:scale-95 text-white border-white/20">
                                    Sign In
                                </Link>
                                <Link :href="route('register')" class="btn btn-sm btn-primary bg-white/20 border-white/30 text-white hover:bg-white/30 hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-sm">
                                    Get Started
                                </Link>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style scoped>
/* Glass Navbar Effects */
.navbar-glass {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

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

.animate-scale-in {
    animation: scale-in 0.2s ease-out;
}

/* Custom Glass Scrollbar */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Gradient text support */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}

/* Enhanced Glass Effects */
.navbar-dropdown {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

/* Enhanced focus states */
.navbar-btn:focus-visible {
    outline: 2px solid rgba(255, 255, 255, 0.5);
    outline-offset: 2px;
}

/* Glass button effects */
.btn-ghost:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
