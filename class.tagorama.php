<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 20/06/15
 * Time: 20:15
 */
require_once(TAGORAMA_PLUGIN_DIR . '/lib/TagGenerator.php');
require_once(TAGORAMA_PLUGIN_DIR . '/lib/TagCalculator.php');

define('TAGORAMA_NEW_POST_COUNT', 100);
class Tagorama {

    private static $initiated = false;


    /**
     * Activation Hook
     */
    public static function plugin_activate() {
        // Nothing to do here...
    }

    /**
     * Deactivation Hook
     */
    public static function plugin_deactivate() {
        // Nothing to do here...
    }

    /**
     * Init the plugin
     */
    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    /**
     * Hook the plugin to the Wordpress System
     */
    public static function init_hooks() {
        self::$initiated = true;
        add_action( 'admin_menu', array('Tagorama', 'tagorama_add_menu'));
    }

    /**
     * Add menu to the Admin Sidebar
     */
    public function tagorama_add_menu() {
        add_menu_page (
            'Tag-O-Rama Main',
            'Tag-O-Rama',
            'manage_options',
            'tagorama-page',
            array('Tagorama', 'admin_menu_page')
        );
    }

    /**
     * Shows the plugin page
     */
    public static function admin_menu_page() {
        include(TAGORAMA_PLUGIN_DIR . '/views/main_page.php');
    }

    /**
     * Generate new posts batch
     */
    public static function generate_new_posts() {
        self::delete_all_posts();
        self::add_new_posts();
    }

    /**
     * Delete all posts.
     * WARNING: Posts are not trashed, but deleted from the DB
     */
    public static function delete_all_posts() {
        $query = new WP_Query('post_type=post&posts_per_page=-1');
        while($query->have_posts()) {

            $query->the_post();
            wp_delete_post($query->post->ID, true);

        }
    }

    /**
     * Create a new post with a random title and tags
     * @param int $count  number of posts to be created
     */
    public static function add_new_posts($count = TAGORAMA_NEW_POST_COUNT) {
        require_once TAGORAMA_PLUGIN_DIR . 'vendor/fzaninotto/faker/src/autoload.php';
        // alternatively, use another PSR-0 compliant autoloader (like the Symfony2 ClassLoader for instance)

        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create();
        for($i = 0; $i < $count; $i++) {
            $post_id = wp_insert_post([
                'post_title' => $faker->sentence(),
                'post_content' => 'Lorem ipsum!',
                'post_status' => 'publish',
            ]);
            $generator = new TagGenerator();

            wp_add_post_tags($post_id, $generator->generate(rand(1, 10)));
        }

    }

    /**
     * Handle Chart.js ajax call
     */
    public static function get_stats_ajax() {
        $calculator = new TagCalculator();
        if ($_REQUEST['fn'] == 'tagorama_get_tags_stats') {
            $response = [
                'data' => $calculator->getStats()
            ];
            wp_send_json($response);
        }

    }
}