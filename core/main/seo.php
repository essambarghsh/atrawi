<?php
/**
 * SEO Handling Class
 * Implements schema.org markup and optimizes SEO
 */

namespace Ashwab;

defined('ABSPATH') || exit;

class SEO {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_head', [$this, 'outputSchemaMarkup'], 5);
        add_action('wp_head', [$this, 'outputMetaTags'], 1);
        add_filter('get_the_archive_title', [$this, 'removeArchivePrefix']);
    }
    
    /**
     * Generate schema.org structured data
     */
    public function outputSchemaMarkup() {
        $schema = [];
        
        // Website schema
        $schema['website'] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'url' => home_url('/'),
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            ]
        ];
        
        // Additional schema based on page type
        if (is_singular('post')) {
            global $post;
            
            // Get post author details
            $author_id = $post->post_author;
            $author_name = get_the_author_meta('display_name', $author_id);
            $author_url = get_author_posts_url($author_id);
            
            // Get post image
            $image = '';
            if (has_post_thumbnail()) {
                $image_id = get_post_thumbnail_id();
                $image_url = wp_get_attachment_image_src($image_id, 'full');
                if ($image_url) {
                    $image = $image_url[0];
                }
            }
            
            // Article schema
            $schema['article'] = [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => get_the_title(),
                'datePublished' => get_the_date('c'),
                'dateModified' => get_the_modified_date('c'),
                'author' => [
                    '@type' => 'Person',
                    'name' => $author_name,
                    'url' => $author_url
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => get_bloginfo('name'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => get_theme_mod('atrawi_site_logo', '')
                    ]
                ],
                'mainEntityOfPage' => get_permalink(),
                'description' => get_the_excerpt()
            ];
            
            // Add image if available
            if ($image) {
                $schema['article']['image'] = [
                    '@type' => 'ImageObject',
                    'url' => $image,
                    'width' => $image_url[1],
                    'height' => $image_url[2]
                ];
            }
        }
        
        // Output schemas
        foreach ($schema as $schema_data) {
            echo '<script type="application/ld+json">' . wp_json_encode($schema_data) . '</script>' . "\n";
        }
    }
    
    /**
     * Output meta tags for SEO
     */
    public function outputMetaTags() {
        // Default values
        $title = get_bloginfo('name');
        $description = get_bloginfo('description');
        $image = '';
        
        // Custom title and description based on page type
        if (is_singular()) {
            global $post;
            
            $title = get_the_title() . ' - ' . get_bloginfo('name');
            
            // Get excerpt or generate one from content
            $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 25, '...');
            
            // Get featured image
            if (has_post_thumbnail()) {
                $image_id = get_post_thumbnail_id();
                $image_data = wp_get_attachment_image_src($image_id, 'large');
                if ($image_data) {
                    $image = $image_data[0];
                }
            }
        } elseif (is_category() || is_tag() || is_tax()) {
            $term = get_queried_object();
            $title = single_term_title('', false) . ' - ' . get_bloginfo('name');
            $description = term_description();
        } elseif (is_author()) {
            $author_id = get_queried_object_id();
            $title = get_the_author_meta('display_name', $author_id) . ' - ' . get_bloginfo('name');
            $description = get_the_author_meta('description', $author_id);
        }
        
        // Clean description
        $description = strip_tags(strip_shortcodes($description));
        $description = str_replace(["\n", "\r", "\t"], ' ', $description);
        $description = trim(preg_replace('/\s+/', ' ', $description));
        
        // Output meta tags
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        
        // Open Graph tags
        echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '">' . "\n";
        echo '<meta property="og:type" content="' . (is_singular('post') ? 'article' : 'website') . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_the_permalink()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        
        if ($image) {
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
        }
        
        // Twitter Card tags
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
        
        if ($image) {
            echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
        }
    }
    
    /**
     * Remove "Category:", "Tag:", etc. from archive titles
     *
     * @param string $title The archive title
     * @return string Modified title
     */
    public function removeArchivePrefix($title) {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            $title = get_the_author();
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } elseif (is_tax()) {
            $title = single_term_title('', false);
        }
        
        return $title;
    }
}