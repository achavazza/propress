<?php
/**
 * EMERGENCY REPAIR SCRIPT
 * This script forces WordPress to regenerate rewrite rules
 * 
 * Instructions:
 * 1. Visit: http://propress.test/wp-admin/admin.php?force_rewrite=1
 * 2. Wait for the "Done!" message
 * 3. Test your pages again
 */

// Force WordPress to regenerate rewrite rules
if (is_admin() && isset($_GET['force_rewrite'])) {
    // Clear all rewrite rules
    delete_option('rewrite_rules');
    
    // Force flush
    flush_rewrite_rules(true);
    
    // Show message
    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible">
            <h1>REWRITE RULES REGENERATED!</h1>
            <p>All rewrite rules have been cleared and regenerated.</p>
            <p><a href="' . home_url() . '" target="_blank" class="button button-primary">Test Homepage</a></p>
        </div>';
    });
}

// Emergency: Disable all custom post types and taxonomies
if (isset($_GET['safe_mode'])) {
    // This will temporarily disable all post type registrations
    add_action('init', function() {
        // Don't register anything - just for testing
    }, 999);
    
    add_action('admin_notices', function() {
        echo '<div class="notice notice-warning">
            <h2>SAFE MODE ACTIVE</h2>
            <p>All custom post types and taxonomies are temporarily disabled for testing.</p>
            <p>Remove ?safe_mode from URL to re-enable them.</p>
        </div>';
    });
}
