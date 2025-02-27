// File: src/ts/core/admin/admin.ts

/**
 * Main entry point for Atrawi theme JavaScript
 */

// Import admin functionality if in admin area
if (typeof window !== 'undefined' && window.wp && typeof window.wp.customize === 'undefined') {
    // Check if we're in the WordPress admin (but not in the customizer)
    import('./theme-settings').then(module => {
        // Admin functionality loaded
    }).catch(error => {
        console.error('Error loading admin functionality:', error);
    });
}