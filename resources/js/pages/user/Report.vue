<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavUser from '../../components/NavUser.vue';
import { ref, onMounted, watch, nextTick } from 'vue';
import FooterUser from '@/components/FooterUser.vue';

// Constants
const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
const ACCEPTED_IMAGE_TYPES = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
const MAX_IMAGES = 5;

// Form data untuk laporan
const form = useForm({
    report_type: 'road_condition',
    location: '',
    coordinates: {
        lat: null as number | null,
        lng: null as number | null
    },
    road_condition: 'baik',
    severity_level: 'rendah',
    description: '',
    category: 'jalan_raya',
    images: [] as File[],
    reporter_name: '',
    reporter_phone: '',
    is_emergency: false
});

// State untuk UI
const isLocationPickerOpen = ref(false);
const previewImages = ref<Array<{ file: File, url: string, name: string }>>([]);
const isLoadingLocation = ref(false);
const locationError = ref('');
const uploadError = ref('');
const showConfirmModal = ref(false);

// Validation states
const validationErrors = ref<Record<string, string>>({});

// Initialize theme and location on mount
onMounted(async () => {
    initializeTheme();
    await getCurrentLocation();
});

// Watch for form changes to clear validation errors
watch(() => form.data(), () => {
    clearValidationErrors();
}, { deep: true });

// Theme initialization
const initializeTheme = () => {
    const savedTheme = localStorage.getItem('theme') || 'system';
    const html = document.documentElement;

    if (savedTheme === 'system') {
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        html.setAttribute('data-theme', systemPrefersDark ? 'dark' : 'light');
    } else {
        html.setAttribute('data-theme', savedTheme);
    }
};

// Location methods
const getCurrentLocation = async (): Promise<void> => {
    if (!navigator.geolocation) {
        locationError.value = 'Geolocation tidak didukung oleh browser ini';
        return;
    }

    isLoadingLocation.value = true;
    locationError.value = '';

    const position = await new Promise<GeolocationPosition>((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 300000 // 5 minutes
        });
    });

    form.coordinates.lat = position.coords.latitude;
    form.coordinates.lng = position.coords.longitude;
    isLoadingLocation.value = false;
};

// Image handling methods
const validateImage = (file: File): string | null => {
    if (!ACCEPTED_IMAGE_TYPES.includes(file.type)) {
        return 'Format file tidak didukung. Gunakan JPG, PNG, atau WebP.';
    }

    if (file.size > MAX_FILE_SIZE) {
        return 'Ukuran file terlalu besar. Maksimal 10MB.';
    }

    if (previewImages.value.length >= MAX_IMAGES) {
        return `Maksimal ${MAX_IMAGES} gambar yang dapat diupload.`;
    }

    return null;
};

const handleImageUpload = async (event: Event): Promise<void> => {
    const target = event.target as HTMLInputElement;
    const files = Array.from(target.files || []);

    uploadError.value = '';

    if (files.length === 0) return;

    for (const file of files) {
        const error = validateImage(file);
        if (error) {
            uploadError.value = error;
            break;
        }

        const imageUrl = await readFileAsDataURL(file);
        previewImages.value.push({
            file: file,
            url: imageUrl,
            name: file.name
        });
    }

    // Update form images
    form.images = previewImages.value.map(img => img.file);

    // Reset input
    target.value = '';
};

const readFileAsDataURL = (file: File): Promise<string> => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (e) => resolve(e.target?.result as string);
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
};

const removeImage = (index: number): void => {
    if (index >= 0 && index < previewImages.value.length) {
        previewImages.value.splice(index, 1);
        form.images = previewImages.value.map(img => img.file);
        uploadError.value = '';
    }
};

// Validation methods
const validateForm = (): boolean => {
    clearValidationErrors();
    let isValid = true;

    if (!form.location.trim()) {
        validationErrors.value.location = 'Lokasi harus diisi';
        isValid = false;
    }

    if (!form.report_type) {
        validationErrors.value.report_type = 'Jenis laporan harus dipilih';
        isValid = false;
    }

    if (!form.category) {
        validationErrors.value.category = 'Kategori jalan harus dipilih';
        isValid = false;
    }

    if (form.reporter_phone && !isValidPhoneNumber(form.reporter_phone)) {
        validationErrors.value.reporter_phone = 'Format nomor telepon tidak valid';
        isValid = false;
    }

    return isValid;
};

const isValidPhoneNumber = (phone: string): boolean => {
    // Simple Indonesian phone number validation
    const phoneRegex = /^(\+62|62|0)[0-9]{8,13}$/;
    return phoneRegex.test(phone.replace(/[\s-]/g, ''));
};

const clearValidationErrors = (): void => {
    validationErrors.value = {};
};

// Form submission
const showConfirmation = (): void => {
    if (!validateForm()) {
        return;
    }
    showConfirmModal.value = true;
};

const submitReport = async (): Promise<void> => {
    showConfirmModal.value = false;

    // Prepare form data
    const formData = {
        ...form.data(),
        images: previewImages.value.map(img => img.file)
    };

    await form.post(route('user.report.store'), {
        onSuccess: () => {
            resetForm();
        },
        onError: (errors) => {
            handleSubmissionErrors(errors);
        }
    });
};

const handleSubmissionErrors = (errors: Record<string, string>): void => {
    // Map server errors to validation errors
    Object.keys(errors).forEach(key => {
        validationErrors.value[key] = errors[key];
    });
};

const resetForm = (): void => {
    form.reset();
    previewImages.value = [];
    clearValidationErrors();
    uploadError.value = '';
    locationError.value = '';
};

const scrollToTop = (): void => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Utility methods for styling
const getConditionColor = (condition: string): string => {
    const colors: Record<string, string> = {
        'baik': 'text-success',
        'rusak_ringan': 'text-warning',
        'rusak_berat': 'text-error',
        'dalam_perbaikan': 'text-info'
    };
    return colors[condition] || 'text-base-content';
};

const getSeverityColor = (severity: string): string => {
    const colors: Record<string, string> = {
        'rendah': 'text-success',
        'sedang': 'text-warning',
        'tinggi': 'text-error',
        'kritis': 'text-error'
    };
    return colors[severity] || 'text-base-content';
};
</script>

<template>
    <Head title="Laporan Kondisi Jalan - GoTracking">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <!-- Background dengan pattern yang konsisten -->
    <div class="min-h-screen bg-gradient-to-br from-base-200 via-base-100 to-base-200 transition-all duration-300">

        <!-- Universal Navbar -->
        <NavUser />

        <!-- Main Content -->
        <main class="pt-40 pb-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Header Section -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-base-content mb-4">
                        Laporkan Kondisi Jalan
                    </h1>
                </div>

                <!-- Form Container -->
                <div class="bg-base-100 rounded-2xl shadow-xl border border-base-content/10 overflow-hidden">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-base-content mb-6">Informasi Laporan</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Jenis Laporan -->
                                <div>
                                    <label class="block text-sm font-medium text-base-content mb-3">Jenis Laporan</label>
                                    <div class="grid grid-cols-1 gap-3">
                                        <label class="relative">
                                            <input type="radio" v-model="form.report_type" value="road_condition" class="sr-only peer">
                                            <div class="p-4 border-2 border-base-300 rounded-lg cursor-pointer transition-all duration-300 peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                    </svg>
                                                    <div>
                                                        <div class="font-medium text-base-content">Kondisi Jalan</div>
                                                        <div class="text-sm text-base-content/60">Jalan rusak, berlubang, dll</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative">
                                            <input type="radio" v-model="form.report_type" value="accident" class="sr-only peer">
                                            <div class="p-4 border-2 border-base-300 rounded-lg cursor-pointer transition-all duration-300 peer-checked:border-error peer-checked:bg-error/10 hover:border-error/50">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>
                                                        <div class="font-medium text-base-content">Kecelakaan</div>
                                                        <div class="text-sm text-base-content/60">Kecelakaan lalu lintas</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative">
                                            <input type="radio" v-model="form.report_type" value="new_area" class="sr-only peer">
                                            <div class="p-4 border-2 border-base-300 rounded-lg cursor-pointer transition-all duration-300 peer-checked:border-success peer-checked:bg-success/10 hover:border-success/50">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <div>
                                                        <div class="font-medium text-base-content">Wilayah Baru</div>
                                                        <div class="text-sm text-base-content/60">Tambah area monitoring</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div>
                                    <label class="block text-sm font-medium text-base-content mb-3">Lokasi Kejadian</label>
                                    <div class="space-y-4">
                                        <div class="relative text-base-content">
                                            <input type="text" v-model="form.location" placeholder="Masukkan nama jalan atau alamat lengkap..." class="input input-bordered w-full pr-12 focus:input-primary transition-all duration-300" required>
                                            <button type="button" @click="getCurrentLocation" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/50 hover:text-primary transition-colors duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Koordinat GPS -->
                                        <div v-if="form.coordinates.lat && form.coordinates.lng" class="text-sm text-base-content/60 bg-base-200 p-3 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Koordinat GPS: {{ form.coordinates.lat.toFixed(6) }}, {{ form.coordinates.lng.toFixed(6) }}</span>
                                            </div>
                                        </div>

                                        <!-- Loading Location -->
                                        <div v-if="isLoadingLocation" class="text-sm text-base-content/60 bg-base-200 p-3 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <span class="loading loading-spinner loading-sm"></span>
                                                <span>Mengambil lokasi...</span>
                                            </div>
                                        </div>

                                        <!-- Location Error -->
                                        <div v-if="locationError" class="text-sm text-error bg-error/10 p-3 rounded-lg border border-error/20">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ locationError }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kategori Jalan -->
                                <div>
                                    <label class="block text-sm font-medium text-base-content mb-3">Kategori Jalan</label>
                                    <select v-model="form.category" class="select select-bordered w-full focus:select-primary transition-all duration-300 text-base-content">
                                        <option value="jalan_raya">Jalan Raya</option>
                                        <option value="jalan_tol">Jalan Tol</option>
                                        <option value="jalan_provinsi">Jalan Provinsi</option>
                                        <option value="jalan_kabupaten">Jalan Kabupaten/Kota</option>
                                        <option value="jalan_desa">Jalan Desa</option>
                                        <option value="gang">Gang/Jalan Kecil</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Kondisi Jalan (dropdown) -->
                                <div v-if="form.report_type === 'road_condition'">
                                    <label class="block text-sm font-medium text-base-content mb-3">Kondisi Jalan</label>
                                    <select v-model="form.road_condition" class="select select-bordered w-full focus:select-primary transition-all duration-300 text-base-content">
                                        <option value="baik">Baik</option>
                                        <option value="rusak_ringan">Rusak Ringan</option>
                                        <option value="rusak_berat">Rusak Berat</option>
                                        <option value="dalam_perbaikan">Dalam Perbaikan</option>
                                    </select>
                                </div>

                                <!-- Tingkat Keparahan (dropdown) -->
                                <div>
                                    <label class="block text-sm font-medium text-base-content mb-3">Tingkat Keparahan</label>
                                    <select v-model="form.severity_level" class="select select-bordered w-full focus:select-primary transition-all duration-300 text-base-content">
                                        <option value="rendah">Rendah - Tidak mengganggu</option>
                                        <option value="sedang">Sedang - Sedikit mengganggu</option>
                                        <option value="tinggi">Tinggi - Sangat mengganggu</option>
                                        <option value="kritis">Kritis - Berbahaya</option>
                                    </select>
                                </div>

                                <!-- Deskripsi Detail -->
                                <div>
                                    <label class="block text-sm font-medium text-base-content mb-3">Deskripsi Detail</label>
                                    <textarea v-model="form.description" rows="4" placeholder="Jelaskan kondisi secara detail... (opsional)" class="textarea textarea-bordered w-full focus:textarea-primary transition-all duration-300 resize-none text-base-content"></textarea>
                                    <div class="text-xs text-base-content/50 mt-2">
                                        Contoh: "Jalan berlubang besar di tengah jalan, diameter sekitar 2 meter, kedalaman 30cm. Sangat berbahaya untuk motor."
                                    </div>
                                </div>

                                <!-- Upload Foto -->
                                <div>
                                    <label class="block text-sm font-medium text-base-content mb-3">Foto Bukti (Opsional)</label>
                                    <div class="border-2 border-dashed border-base-300 rounded-lg p-4 text-center hover:border-primary/50 transition-all duration-300">
                                        <input type="file" @change="handleImageUpload" multiple accept="image/*" class="hidden" id="image-upload">
                                        <label for="image-upload" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-base-content/40 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <div class="text-base-content/60 text-sm">
                                                <span class="font-medium  text-base-content">Klik untuk upload</span>
                                            </div>
                                            <div class="text-xs text-base-content/40 mt-1">PNG, JPG hingga 10MB</div>
                                        </label>
                                    </div>

                                    <!-- Upload Error -->
                                    <div v-if="uploadError" class="text-sm text-error bg-error/10 p-3 rounded-lg border border-error/20 mt-3">
                                        {{ uploadError }}
                                    </div>

                                    <!-- Preview Images -->
                                    <div v-if="previewImages.length > 0" class="grid grid-cols-3 gap-2 mt-3">
                                        <div v-for="(image, index) in previewImages" :key="index" class="relative group">
                                            <img :src="image.url" :alt="image.name" class="w-full h-16 object-cover rounded border border-base-300">
                                            <button type="button" @click="removeImage(index)" class="absolute -top-1 -right-1 w-5 h-5 bg-error text-error-content rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end mt-8 pt-6 border-t border-base-content/10">
                                    <button type="button" @click="showConfirmModal = true" :disabled="!form.location || !form.report_type" class="btn btn-primary hover:scale-105 active:scale-95 transition-all duration-300 disabled:opacity-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Kirim Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <FooterUser />

        <!-- Confirmation Modal -->
        <div v-if="showConfirmModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-base-100 rounded-2xl p-8 max-w-md w-full shadow-2xl">
                <div class="text-center">
                    <div class="w-16 h-16 bg-warning/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-base-content mb-2">Konfirmasi Laporan</h3>
                    <p class="text-base-content/70 mb-6">
                        Apakah Anda yakin ingin mengirim laporan ini? Pastikan semua informasi sudah benar.
                    </p>
                    <div class="flex space-x-3">
                        <button @click="showConfirmModal = false" class="btn btn-ghost flex-1">
                            Batal
                        </button>
                        <button @click="submitReport" :disabled="form.processing" class="btn btn-primary flex-1">
                            <span v-if="form.processing" class="loading loading-spinner loading-sm mr-2"></span>
                            {{ form.processing ? 'Mengirim...' : 'Ya, Kirim' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div v-if="form.wasSuccessful" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-base-100 rounded-2xl p-8 max-w-md w-full shadow-2xl">
                <div class="text-center">
                    <div class="w-16 h-16 bg-success/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-base-content mb-2">Laporan Berhasil Dikirim!</h3>
                    <p class="text-base-content/70 mb-6">
                        Terima kasih atas kontribusi Anda. Laporan akan diverifikasi dalam 1x24 jam.
                    </p>
                    <div class="space-y-3">
                        <Link :href="route('user.map')" class="btn btn-primary w-full">
                            Lihat di Peta
                        </Link>
                        <button @click="form.wasSuccessful = false; resetForm()" class="btn btn-ghost w-full">
                            Buat Laporan Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>
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

/* Custom radio button styling */
input[type="radio"]:checked+div {
    transform: scale(1.02);
}

/* Image preview styling */
.group:hover img {
    transform: scale(1.05);
}

/* Loading animation */
.loading {
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

/* Focus states for accessibility */
.btn:focus-visible,
.input:focus-visible,
.textarea:focus-visible,
.select:focus-visible {
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

/* Animation untuk step transitions */
.step-transition-enter-active,
.step-transition-leave-active {
    transition: all 0.3s ease;
}

.step-transition-enter-from {
    opacity: 0;
    transform: translateX(30px);
}

.step-transition-leave-to {
    opacity: 0;
    transform: translateX(-30px);
}

/* Hover effects untuk cards */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

.active\:scale-95:active {
    transform: scale(0.95);
}

/* Glassmorphism effect */
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Dark mode adjustments */
[data-theme="dark"] .glass {
    background: rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
