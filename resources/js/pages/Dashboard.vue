<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import NavUser from '../components/NavUser.vue';
import { onMounted } from 'vue';
import FooterUser from '../components/footerUser.vue';

// Initialize theme on mount
onMounted(() => {
    // Apply initial theme if not already set by navbar
    const savedTheme = localStorage.getItem('theme') || 'system';
    const html = document.documentElement;

    if (savedTheme === 'system') {
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        html.setAttribute('data-theme', systemPrefersDark ? 'dark' : 'light');
    } else {
        html.setAttribute('data-theme', savedTheme);
    }
});
</script>

<template>
    <Head title="GoTracking - Aman di Setiap Perjalanan">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <!-- Background dengan pattern peta yang responsive terhadap dark mode -->
    <div class="min-h-screen bg-gradient-to-br from-base-200 via-base-100 to-base-200 transition-all duration-300">

        <!-- Universal Navbar -->
        <NavUser />

        <!-- Main Content -->
        <main class="pt-16">

            <!-- Hero Section -->
            <div class="relative overflow-hidden">
                <!-- Background Map Pattern - Responsive to theme -->
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.08] transition-opacity duration-300">
                    <div class="w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'%3E%3C/path%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-repeat: repeat;"></div>
                </div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 relative">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Left Content -->
                        <div>
                            <!-- Welcome Message -->
                            <h1 class="text-4xl sm:text-6xl font-bold text-base-content mb-6 transition-colors duration-300">
                                <span class=" bg-clip-text text-base-content">
                                    GoTracking
                                </span>
                                <br>
                                <span class="text-3xl sm:text-4xl">Aman di Setiap Perjalanan</span>
                            </h1>

                            <p class="text-xl text-base-content/70 mb-8 leading-relaxed transition-colors duration-300">
                                Platform analisis kondisi jalan & kecelakaan di Indonesia.
                                Temukan jalur teraman untuk perjalanan Anda dengan data real-time dan historis.
                            </p>

                            <!-- CTA Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <template v-if="$page.props.auth?.user">
                                    <!-- Authenticated User Actions -->
                                    <Link
                                        :href="$page.props.auth.user.role === 'admin' ? route('admin.dashboard') : route('user.dashboard')"
                                        class="btn btn-primary btn-lg hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg hover:shadow-xl"
                                    >
                                        <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        Dashboard Tracking
                                    </Link>
                                </template>
                                <template v-else>
                                    <!-- Guest User Actions -->
                                    <Link :href="route('user.map')"
                                        class="btn btn-primary btn-lg hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg hover:shadow-xl"
                                    >
                                        <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        Cari Jalur Aman
                                    </Link>
                                    <Link :href="route('user.report')"
                                        class="btn btn-outline btn-lg hover:scale-105 active:scale-95 transition-all duration-300"
                                    >
                                        <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Lapor Kondisi Jalan
                                    </Link>
                                </template>
                            </div>
                        </div>

                        <!-- Right Visual -->
                        <div class="relative">
                            <!-- Map Visual Placeholder -->
                            <div class="relative bg-gradient-to-br from-primary/10 to-secondary/10 backdrop-blur-sm rounded-2xl p-8 shadow-2xl border border-base-content/10 transition-all duration-300">
                                <!-- Animated Map Elements -->
                                <div class="space-y-4">
                                    <!-- Route Lines -->
                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-success rounded-full animate-pulse shadow-lg"></div>
                                        <div class="flex-1 h-2 bg-base-content/20 rounded-full relative overflow-hidden">
                                            <div class="absolute left-0 top-0 h-full w-1/3 bg-success rounded-full animate-pulse"></div>
                                        </div>
                                        <div class="w-4 h-4 bg-info rounded-full shadow-lg"></div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-warning rounded-full shadow-lg"></div>
                                        <div class="flex-1 h-2 bg-base-content/20 rounded-full relative overflow-hidden">
                                            <div class="absolute left-0 top-0 h-full w-2/3 bg-warning rounded-full"></div>
                                        </div>
                                        <div class="w-4 h-4 bg-error rounded-full animate-ping shadow-lg"></div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <div class="w-4 h-4 bg-info rounded-full shadow-lg"></div>
                                        <div class="flex-1 h-2 bg-base-content/20 rounded-full relative overflow-hidden">
                                            <div class="absolute left-0 top-0 h-full w-full bg-info rounded-full"></div>
                                        </div>
                                        <div class="w-4 h-4 bg-success rounded-full animate-bounce shadow-lg"></div>
                                    </div>
                                </div>

                                <!-- Status Cards -->
                                <div class="mt-6 grid grid-cols-2 gap-3">
                                    <div class="bg-base-100/80 backdrop-blur-sm p-3 rounded-lg shadow-sm border border-base-content/10 transition-all duration-300">
                                        <div class="text-xs text-base-content/60">Status Jalan</div>
                                        <div class="text-sm font-semibold text-success">Aman</div>
                                    </div>
                                    <div class="bg-base-100/80 backdrop-blur-sm p-3 rounded-lg shadow-sm border border-base-content/10 transition-all duration-300">
                                        <div class="text-xs text-base-content/60">Waktu Tempuh</div>
                                        <div class="text-sm font-semibold text-info">45 menit</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Background Decoration -->
                <div class="absolute inset-0 -z-10">
                    <div class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-base-100/50 shadow-xl shadow-primary/5 ring-1 ring-base-content/10 transition-all duration-300 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"></div>
                </div>
            </div>

            <!-- About GoTracking Section -->
            <div class="py-24 sm:py-32 bg-base-100 transition-colors duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-16 items-center">
                        <!-- Left Content -->
                        <div>
                            <h2 class="text-3xl font-bold text-base-content mb-6 transition-colors duration-300">
                                Tentang <span class=" bg-clip-text  text-base-content">GoTracking</span>
                            </h2>

                            <div class="space-y-6 text-base-content/70 text-lg leading-relaxed transition-colors duration-300">
                                <p>
                                    GoTracking adalah platform monitoring kondisi jalan dan kecelakaan di Indonesia yang membantu pengguna memilih jalur aman dengan data historis dan real-time.
                                </p>

                                <p>
                                    Dilengkapi fitur laporan pengguna, peta interaktif, serta analisis statistik untuk mendukung keselamatan berkendara. Platform ini dirancang untuk pengguna jalan, pemerintah, dan perusahaan transportasi.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                                    <div class="text-center p-4 bg-success/10 rounded-lg border border-success/20 transition-all duration-300 hover:scale-105">
                                        <div class="text-2xl font-bold text-success">1000+</div>
                                        <div class="text-sm text-base-content/60">Laporan Jalan</div>
                                    </div>
                                    <div class="text-center p-4 bg-info/10 rounded-lg border border-info/20 transition-all duration-300 hover:scale-105">
                                        <div class="text-2xl font-bold text-info">50+</div>
                                        <div class="text-sm text-base-content/60">Kota Terpantau</div>
                                    </div>
                                    <div class="text-center p-4 bg-secondary/10 rounded-lg border border-secondary/20 transition-all duration-300 hover:scale-105">
                                        <div class="text-2xl font-bold text-secondary">24/7</div>
                                        <div class="text-sm text-base-content/60">Monitoring</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <Link :href="route('user.dashboard')"
                                    class="btn btn-outline hover:scale-105 active:scale-95 transition-all duration-300 text-base-content"
                                >
                                    Pelajari Lebih Lanjut
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </Link>
                            </div>
                        </div>

                        <!-- Right Visual - Mobile App Mockup -->
                        <div class="relative">
                            <div class="relative mx-auto w-64 h-[480px]">
                                <!-- Phone Frame -->
                                <div class="absolute inset-0 bg-slate-800 rounded-[2.5rem] shadow-2xl"></div>
                                <div class="absolute inset-2 bg-black rounded-[2rem] overflow-hidden">
                                    <!-- Screen Content -->
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-blue-600 relative">
                                        <!-- Status Bar -->
                                        <div class="absolute top-0 left-0 right-0 h-8 bg-black/20"></div>

                                        <!-- App Logo -->
                                        <div class="absolute top-12 left-1/2 transform -translate-x-1/2 ">
                                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                                                <div class="text-2xl font-bold text-emerald-600">GT</div>
                                            </div>
                                            <div class="text-white text-center mt-2 font-semibold ">GoTracking</div>
                                        </div>

                                        <!-- Mock Interface -->
                                        <div class="absolute bottom-20 left-4 right-4">
                                            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-4 space-y-3">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                                                    <div class="flex-1 text-sm text-slate-700">Jl. Sudirman - Aman</div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                                    <div class="flex-1 text-sm text-slate-700">Jl. Gatot Subroto - Padat</div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                                    <div class="flex-1 text-sm text-slate-700">Jl. Thamrin - Kecelakaan</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bottom Button -->
                                        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2">
                                            <div class="bg-white px-6 py-2 rounded-full text-emerald-600 font-semibold text-sm shadow-lg">
                                                Mulai Tracking
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Home Indicator -->
                                <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-slate-600 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <FooterUser />
    </div>
</template>

<style scoped>
/* Smooth transitions for theme changes */
* {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
    transition-duration: 300ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Enhanced backdrop blur support */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

/* Gradient text support */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}

/* Animation enhancements */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

/* Focus states for accessibility */
.btn:focus-visible {
    outline: 2px solid oklch(var(--p));
    outline-offset: 2px;
}

/* Custom scrollbar for consistency */
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
</style>
