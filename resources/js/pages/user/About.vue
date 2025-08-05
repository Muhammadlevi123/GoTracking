<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavUser from '@/components/NavUser.vue';
import { onMounted } from 'vue';

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
                        GoTracking adalah platform deteksi kecelakaan berbasis teknologi cerdas yang dirancang untuk memberikan rasa aman bagi pengendara di Indonesia. Melalui aplikasi web maupun mobile, GoTracking memanfaatkan sensor ponsel dan algoritma pendeteksi kecelakaan untuk secara otomatis mengenali insiden tabrakan atau jatuh, kemudian mengirim notifikasi darurat ke kontak keluarga, layanan medis, atau pihak berwenang terdekat.
                    </p>
                    <p class="text-base-content/80 text-lg leading-relaxed transition-colors duration-300">
                        Dengan sistem yang terintegrasi, GoTracking hadir sebagai solusi inovatif yang mendukung upaya penyelamatan jiwa, mengurangi risiko keterlambatan penanganan kecelakaan, serta memberikan ketenangan bagi pengguna maupun keluarga mereka.
                    </p>
                </div>

                <!-- Services -->
                <div class="mb-16">
                    <h3 class="text-2xl font-bold text-base-content mb-6 transition-colors duration-300">
                        Menyediakan Layanan Keamanan yang Mudah Diakses dan Terjangkau
                    </h3>
                    <p class="text-base-content/80 text-lg leading-relaxed transition-colors duration-300 mb-6">
                        Layanan deteksi kecelakaan otomatis GoTracking dirancang untuk semua kalangan pengguna kendaraan bermotor di Indonesia, baik pengendara sepeda motor, mobil pribadi, hingga layanan transportasi online. Fitur-fitur utama GoTracking mencakup kemampuan mendeteksi kecelakaan secara otomatis melalui sensor akselerometer dan giroskop, mengirim peringatan darurat berupa notifikasi real-time ke kontak darurat yang telah ditentukan, melacak lokasi terkini pengguna secara akurat, serta menyediakan riwayat perjalanan dan catatan insiden yang dapat diakses langsung oleh pengguna.
                    </p>
                    <p class="text-base-content/80 text-lg leading-relaxed transition-colors duration-300">
                        GoTracking juga dilengkapi fitur panggilan cepat ke layanan medis atau nomor darurat nasional, dan dashboard online ramah pengguna dengan laporan serta statistik keselamatan, sehingga seluruh layanan ini terintegrasi untuk memberikan pengalaman berkendara yang lebih aman dan nyaman.
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

        <footer class="bg-neutral text-neutral-content py-12 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                <span class="text-primary-content font-bold text-lg">GT</span>
                            </div>
                            <span class="text-xl font-bold">GoTracking</span>
                        </div>
                        <p class="text-neutral-content/70 mb-4 max-w-md transition-colors duration-300">
                            Platform keamanan pengendara terpercaya di Indonesia. Aman, akurat, dan selalu siaga.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-semibold mb-4">Fitur</h4>
                        <ul class="space-y-2 text-neutral-content/70">
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Deteksi Kecelakaan</a></li>
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Notifikasi Darurat</a></li>
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Pelacakan Lokasi</a></li>
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Dashboard</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold mb-4">Kontak</h4>
                        <ul class="space-y-2 text-neutral-content/70">
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Bantuan</a></li>
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Tim Kami</a></li>
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Karir</a></li>
                            <li><a href="#" class="hover:text-neutral-content transition-colors duration-300">Hubungi Kami</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-neutral-content/20 pt-8 text-center text-neutral-content/60 transition-colors duration-300">
                    <p>&copy; 2025 GoTracking Indonesia. Semua hak cipta dilindungi.</p>
                </div>
            </div>
        </footer>
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
