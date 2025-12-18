new Swiper(".swiftq-swiper", {
    // Core Functionality
    loop: true,
    centeredSlides: true,
    slidesPerView: 1, // Start with 1 on small screens (as per breakpoints)
    spaceBetween: 30,

    // Speed and Smoothness (New/Enhanced)
    speed: 800, // Faster, professional transition speed (in milliseconds)
    easing: 'ease-out', // Ensure smooth deceleration (often default, but good to know)
    // Note: Remove 'loopedSlides: 3' - Swiper handles this internally for 'loop' and 'centeredSlides'.

    // Navigation
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    // Pagination (New: For better discoverability and visual cues)
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    
    // Autoplay
    autoplay: {
        delay: 3500, // Slightly longer delay (3.5 seconds) for better readability
        disableOnInteraction: false,
        pauseOnMouseEnter: true, // New: Excellent UX feature
    },

    // Responsive Breakpoints
    breakpoints: {
        0: { slidesPerView: 1, spaceBetween: 20 }, // Added spaceBetween for small screens
        768: { slidesPerView: 2, spaceBetween: 30 },
        1024: { slidesPerView: 3, spaceBetween: 30 },
    },
});