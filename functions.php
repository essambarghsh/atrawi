<?php
/**
 * Atrawi Theme functions and definitions
 */

// Define theme version and constants
define('ATRAWI_VERSION', '1.0.0');
define('ATRAWI_DIR', get_template_directory());
define('ATRAWI_URI', get_template_directory_uri());

// Autoload classes
spl_autoload_register(function($class) {
    // Base directory for the namespace
    $prefix = 'Atrawi\\';
    $base_dir = get_template_directory() . '/app/';
    
    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No, move to the next registered autoloader
        return;
    }
    
    // Get the relative class name
    $relative_class = substr($class, $len);
    
    // Convert namespace separators to directory separators,
    // append .php and convert class name to lowercase with hyphens
    $parts = explode('\\', $relative_class);
    $last_part = array_pop($parts);
    $last_part = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $last_part));
    $parts[] = $last_part;
    
    $file = $base_dir . strtolower(implode('/', $parts)) . '.php';
    
    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Initialize the theme
try {
    Atrawi\Core\Theme::getInstance()->initialize();
} catch (Exception $e) {
    // Log error to PHP error log
    error_log('Atrawi Theme Error: ' . $e->getMessage());
    
    // Add admin notice if in admin area
    if (is_admin()) {
        add_action('admin_notices', function() use ($e) {
            echo '<div class="error"><p>Atrawi Theme Error: ' . esc_html($e->getMessage()) . '</p></div>';
        });
    }
}