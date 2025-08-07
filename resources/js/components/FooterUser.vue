<template>
    <!-- Footer -->
    <footer id="footer" class="bg-black/90 text-neutral-content transition-colors duration-300">
        <div class="footer-legal text-center py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row justify-center lg:justify-between items-center">

                    <!-- Social Links - Left side on desktop, top on mobile -->
                    <div class="social-links order-first lg:order-first mb-6 lg:mb-0">
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-neutral-content/10 hover:bg-primary rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-neutral-content/10 hover:bg-primary rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-neutral-content/10 hover:bg-primary rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.219-.359-1.219c0-1.142.662-1.995 1.488-1.995.701 0 1.039.219 1.039 1.219 0 .738-.468 1.841-.711 2.862-.202.854.428 1.55 1.275 1.55 1.533 0 2.714-1.617 2.714-3.955 0-2.067-1.486-3.515-3.612-3.515-2.459 0-3.899 1.844-3.899 3.748 0 .742.284 1.538.639 1.971.07.086.08.162.059.25-.065.270-.211.861-.239.982-.037.155-.121.187-.279.113-1.074-.5-1.746-2.067-1.746-3.323 0-2.72 1.977-5.217 5.699-5.217 2.993 0 5.32 2.135 5.32 4.988 0 2.977-1.877 5.371-4.482 5.371-.875 0-1.697-.456-1.978-1.001 0 0-.433 1.651-.538 2.058-.195.749-.722 1.688-1.077 2.262.811.25 1.669.385 2.564.385 6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-neutral-content/10 hover:bg-primary rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Logo and Copyright - Center/Right side -->
                    <div class="flex flex-col ">
                        <!-- Logo -->
                        <div class="copyright mb-3">
                            <div class="flex items-center space-x-3 ">
                                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center shadow-lg">
                                    <img src="@/assets/logofooter.png" alt="GoTracking Logo" class="w-10 h-10 object-contain">
                                </div>

                                <div class="text-left">
                                    <div class="text-xl font-bold text-neutral-content">GoTracking</div>
                                    <div class="text-sm text-neutral-content/60">Indonesia</div>
                                </div>
                            </div>
                        </div>

                        <!-- Credits -->
                        <div class="credits text-neutral-content/70 text-sm">
                            All rights Reserved
                            <span class="text-primary hover:text-primary-focus transition-colors duration-300">
                                2023-2025
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
</template>
