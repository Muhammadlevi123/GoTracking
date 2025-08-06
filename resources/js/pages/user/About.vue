<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavUser from '@/components/NavUser.vue';
import { onMounted } from 'vue';
import FooterUser from '../../components/footerUser.vue';

onMounted(() => {
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
    <Head title="Tentang GoTracking - Platform Keamanan Pengendara">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-base-200 via-base-100 to-base-200 transition-all duration-300">
        <NavUser />

        <main class="py-16 sm:py-24 bg-base-100 transition-colors duration-300">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Platform Overview -->
                <div class="mb-16">
                    <h3 class="text-2xl font-bold text-base-content mb-6 transition-colors duration-300">
                        GoTracking - Platform Keamanan Pengendara Terdepan di Indonesia
                    </h3>
                    <p class="text-base-content/80 text-lg leading-relaxed transition-colors duration-300 mb-6">
                        GoTracking adalah platform navigasi online yang dapat digunakan untuk memilih jalan berkendara yang paling optimal, dengan kerusakan jalan yang minimal dan keamanan jalan berdasarkan data historis kecelakaan. Data keamanan jalan dinilai berdasarkan tingkat kerusakan, data historis kecelakaan, dan survey kondisi jalan secara berkala.
                    </p>
                </div>

                <!-- Future Vision -->
                <div class="mb-16">
                    <h3 class="text-2xl font-bold text-base-content mb-6 transition-colors duration-300">
                        GoTracking - Masa Depan Keselamatan Pengendara di Indonesia
                    </h3>
                    <p class="text-base-content/80 text-lg leading-relaxed transition-colors duration-300 mb-6">
                        GoTracking tersedia dalam versi aplikasi mobile dan web dengan antarmuka modern yang mudah digunakan. Platform ini didukung oleh teknologi cloud yang andal, notifikasi instan, serta desain berbasis user-centered yang memberikan pengalaman terbaik bagi pengguna.
                    </p>
                    <p class="text-base-content/80 text-lg leading-relaxed transition-colors duration-300">
                        GoTracking berkomitmen membantu pemerintah dan masyarakat menciptakan budaya berkendara aman, serta mendukung target penurunan angka kecelakaan lalu lintas di Indonesia.
                    </p>
                </div>

            </div>
        </main>

        <!-- footer -->
        <FooterUser />

    </div>
</template>

<style scoped>
/* Global Transitions */
* {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
    transition-duration: 300ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Backdrop Effects */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

/* Background Clip Text */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}

/* Animations */
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

/* Focus States */
.btn:focus-visible {
    outline: 2px solid oklch(var(--p));
    outline-offset: 2px;
}

/* Custom Scrollbar */
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

/* Typography Improvements */
h3 {
    line-height: 1.3;
    letter-spacing: -0.025em;
}

p {
    text-align: justify;
    hyphens: auto;
}

/* Responsive Typography */
@media (max-width: 640px) {
    h3 {
        font-size: 1.5rem;
        line-height: 2rem;
    }

    p {
        font-size: 1rem;
        line-height: 1.75rem;
    }
}

/* Content Spacing */
.mb-16:last-child {
    margin-bottom: 0;
}

/* Link Hover Effects */
a:hover {
    text-decoration: none;
}

/* Focus Accessibility */
a:focus-visible {
    outline: 2px solid oklch(var(--p));
    outline-offset: 2px;
    border-radius: 4px;
}
</style>
