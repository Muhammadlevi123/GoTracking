<template>

    <Head title="Dashboard - GoTracking">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-base-100 transition-colors duration-300">
        <!-- Universal Navbar -->
        <NavLanding />

        <!-- Hero Section with Full Background Image -->
        <section class="hero-background relative min-h-screen flex items-center">
            <!-- Hero Content -->
            <div class="hero min-h-screen w-full">
                <div class="hero-content text-center text-white max-w-4xl">
                    <div class="space-y-8">
                        <div class="min-h-screen pt-16">
                            <!-- Your page content goes here -->
                            <div class="hero min-h-screen flex items-center justify-center">
                                <div class="hero-content text-center text-white">
                                    <div class="max-w-md">
                                        <h1 class="text-5xl font-bold mb-5 drop-shadow-2xl">Selamat Datang di GoTracking
                                        </h1>
                                        <p class="text-xl mb-5 text-white/90 drop-shadow-lg">Platform monitoring kondisi
                                            jalan dan kecelakaan Indonesia.
                                            Berkendara lebih aman dengan data real-time yang akurat.</p>
                                        <Link :href="route('user.map')"
                                            class="btn btn-primary bg-white/20 border-white/30 text-white hover:bg-white/30 backdrop-blur-sm hover:scale-105 transition-all duration-300">
                                        Mulai Jelajahi
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Access Section -->
        <section class="py-16 bg-base-100 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-base-content mb-4">Akses Cepat</h2>
                    <p class="text-base-content/70 text-lg">Jelajahi fitur utama GoTracking dengan mudah</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Map Quick Access -->
                    <Link :href="route('user.map')"
                        class="group bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <MapPin class="w-8 h-8" />
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                            <ArrowRight class="w-6 h-6" />
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Peta Interaktif</h3>
                    <p class="text-white/80 text-sm">Lihat kondisi jalan real-time di seluruh Indonesia</p>
                    </Link>

                    <!-- Statistics Quick Access -->
                    <div @click="handleStatisticClick"
                        class="group bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <BarChart3 class="w-8 h-8" />
                            <div
                                class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                <ArrowRight class="w-6 h-6" />
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Statistik</h3>
                        <p class="text-white/80 text-sm">Analisis data kecelakaan dan kondisi jalan</p>
                    </div>

                    <!-- Report Quick Access -->
                    <div @click="handleReportClick"
                        class="group bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <FileText class="w-8 h-8" />
                            <div
                                class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                <ArrowRight class="w-6 h-6" />
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Laporan</h3>
                        <p class="text-white/80 text-sm">Laporkan kondisi jalan atau insiden kecelakaan</p>
                    </div>

                    <!-- About Quick Access -->
                    <Link :href="route('user.about')"
                        class="group bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <Info class="w-8 h-8" />
                        <div
                            class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                            <ArrowRight class="w-6 h-6" />
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Tentang Kami</h3>
                    <p class="text-white/80 text-sm">Pelajari lebih lanjut tentang GoTracking</p>
                    </Link>
                </div>
            </div>
        </section>

        <!-- About GoTracking Section -->
        <div class="py-24 sm:py-32 bg-base-100 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Left Content -->
                    <div>
                        <h2 class="text-3xl font-bold text-base-content mb-6 transition-colors duration-300">
                            Tentang <span class=" bg-clip-text  text-base-content">GoTracking</span>
                        </h2>

                        <div
                            class="space-y-6 text-base-content/70 text-lg leading-relaxed transition-colors duration-300">
                            <p>
                                GoTracking adalah platform monitoring kondisi jalan dan kecelakaan di Indonesia yang
                                membantu pengguna memilih jalur aman dengan data historis dan real-time.
                            </p>

                            <p>
                                Dilengkapi fitur laporan pengguna, peta interaktif, serta analisis statistik untuk
                                mendukung keselamatan berkendara. Platform ini dirancang untuk pengguna jalan,
                                pemerintah, dan perusahaan transportasi.
                            </p>
                        </div>

                        <div class="mt-8">
                            <Link :href="route('user.dashboard')"
                                class="btn btn-outline hover:scale-105 active:scale-95 transition-all duration-300 text-base-content">
                            Pelajari Lebih Lanjut
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            </Link>
                        </div>
                    </div>

                    <!-- Right Visual - Mobile App Mockup -->
                    <div class="relative">

                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section with Dark Mode Support -->
        <section class="py-24 bg-gradient-to-br from-base-200 to-base-300 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-base-content mb-4 transition-colors duration-300">Tim Kami</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                    <!-- Frontend Developer -->
                    <div class="group text-center">
                        <div class="relative mb-6">
                            <div
                                class="w-48 h-48 mx-auto rounded-full overflow-hidden shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-105 ring-4 ring-base-300 group-hover:ring-emerald-500/50">
                                <img :src="imageUrl" alt="Muhammad Levi - Developer"
                                    class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3
                                class="text-2xl font-bold text-base-content group-hover:text-emerald-600 transition-colors duration-300">
                                Muhammad Levi Asshidiqi
                            </h3>
                            <div
                                class="inline-flex items-center px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 rounded-full font-medium border border-emerald-200 dark:border-emerald-700">
                                <Code class="w-4 h-4 mr-2" />
                                Frontend Developer
                            </div>
                        </div>
                    </div>

                    <!-- Backend Developer -->
                    <div class="group text-center">
                        <div class="relative mb-6">
                            <div
                                class="w-48 h-48 mx-auto rounded-full overflow-hidden shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-105 ring-4 ring-base-300 group-hover:ring-blue-500/50">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80"
                                    alt="Ivan Darmawan - Backend Developer" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3
                                class="text-2xl font-bold text-base-content group-hover:text-blue-600 transition-colors duration-300">
                                Ivan Darmawan
                            </h3>
                            <div
                                class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full font-medium border border-blue-200 dark:border-blue-700">
                                <Server class="w-4 h-4 mr-2" />
                                Backend Developer
                            </div>
                        </div>
                    </div>

                    <!-- Data Analyst -->
                    <div class="group text-center">
                        <div class="relative mb-6">
                            <div
                                class="w-48 h-48 mx-auto rounded-full overflow-hidden shadow-xl group-hover:shadow-2xl transition-all duration-500 group-hover:scale-105 ring-4 ring-base-300 group-hover:ring-purple-500/50">
                                <img src="https://images.unsplash.com/photo-1494790108755-2616c8e14d60?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80"
                                    alt="Achmad Aulia Difiputra - Data Analyst" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3
                                class="text-2xl font-bold text-base-content group-hover:text-purple-600 transition-colors duration-300">
                                Achmad Aulia Difiputra
                            </h3>
                            <div
                                class="inline-flex items-center px-4 py-2 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full font-medium border border-purple-200 dark:border-purple-700">
                                <TrendingUp class="w-4 h-4 mr-2" />
                                Data Analyst
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <FooterUser />
    </div>
</template>

<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import FooterUser from '@/components/FooterUser.vue';
import {
    MapPin,
    BarChart3,
    ArrowRight,
    FileText,
    Info,
    Code,
    Server,
    TrendingUp
} from 'lucide-vue-next';
import NavLanding from '@/components/NavLanding.vue';

const imageUrl = '/storage/img/developer/levi.png'

// Get current page props to check authentication
const page = usePage();

// Check if user is authenticated
const isAuthenticated = computed(() => {
    return page.props.auth?.user != null;
});

// Handle Statistic click
const handleStatisticClick = () => {
    if (isAuthenticated.value) {
        // User is authenticated, redirect to statistic page
        router.visit(route('user.statistic'));
    } else {
        // User is not authenticated, redirect directly to login with intended page
        const loginUrl = route('login') + '?intended=' + encodeURIComponent(route('user.statistic'));
        router.visit(loginUrl);
    }
};

// Handle Report click
const handleReportClick = () => {
    if (isAuthenticated.value) {
        // User is authenticated, redirect to report page
        router.visit(route('user.report'));
    } else {
        // User is not authenticated, redirect directly to login with intended page
        const loginUrl = route('login') + '?intended=' + encodeURIComponent(route('user.report'));
        router.visit(loginUrl);
    }
};
</script>

<style scoped>
.hero-background {
    position: relative;
    background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.5)),
        url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

/* Smooth transitions for all elements */
* {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Enhanced backdrop blur support */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.backdrop-blur-md {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

/* Gradient text support */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}

/* Enhanced drop shadows */
.drop-shadow-2xl {
    filter: drop-shadow(0 25px 25px rgba(0, 0, 0, 0.8));
}

.drop-shadow-lg {
    filter: drop-shadow(0 10px 8px rgba(0, 0, 0, 0.6));
}

/* Enhanced animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInFromLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInFromRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-out;
}

.animate-slide-in-left {
    animation: slideInFromLeft 0.8s ease-out;
}

.animate-slide-in-right {
    animation: slideInFromRight 0.8s ease-out;
}

/* Enhanced focus states for accessibility */
.btn:focus-visible {
    outline: 2px solid oklch(var(--p));
    outline-offset: 2px;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: oklch(var(--b2));
}

::-webkit-scrollbar-thumb {
    background: oklch(var(--bc) / 0.3);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: oklch(var(--bc) / 0.5);
}

/* Glass effect enhancements */
.bg-white\/10 {
    background-color: rgba(255, 255, 255, 0.1);
}

.bg-white\/20 {
    background-color: rgba(255, 255, 255, 0.2);
}

.border-white\/20 {
    border-color: rgba(255, 255, 255, 0.2);
}

.border-white\/30 {
    border-color: rgba(255, 255, 255, 0.3);
}

/* Responsive typography */
@media (max-width: 640px) {
    .text-4xl {
        font-size: 2.5rem;
    }

    .text-7xl {
        font-size: 4rem;
    }
}

/* Enhanced hover effects */
.group:hover .group-hover\:rotate-12 {
    transform: rotate(12deg);
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}
</style>
