<footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4"><?php bloginfo('name'); ?></h3>
                    <p><?php bloginfo('description'); ?></p>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4"><?php _e('Navigation', 'atrawi'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'flex flex-col space-y-2',
                    ));
                    ?>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4"><?php _e('Contact', 'atrawi'); ?></h3>
                    <p><?php _e('Email: info@example.com', 'atrawi'); ?></p>
                    <p><?php _e('Phone: +1 (555) 123-4567', 'atrawi'); ?></p>
                </div>
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-700 text-center">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'atrawi'); ?></p>
            </div>
        </div>
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>