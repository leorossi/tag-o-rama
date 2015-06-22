<?php

class TagCalculator
{
    public $posts = [];
    public $stats = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', array($this, 'getAllPosts'));
    }

    /**
     * Save all posts in an internal array for further use
     */
    public function getAllPosts()
    {
        $query = new WP_Query('post_type=post&posts_per_page=-1');
        while($query->have_posts()) {
            $query->the_post();
            $this->posts[] = $query->post;
        }
    }

    /**
     * Get the stats for the post tags
     * @return array
     */
    public function getStats()
    {
        $this->getAllPosts();
        foreach($this->posts as $post) {
            $tags = wp_get_post_tags($post->ID);
            foreach ($tags as $tag) {
                if (!isset($this->stats[$tag->name])) {
                    $this->stats[$tag->name] = [];
                }
                $this->stats[$tag->name][] = $post->ID;
            }
        }
        $output = [];
        foreach ($this->stats as $name => $posts) {
            $output[] = [
                'name' => $name,
                'posts' => $posts
            ];
        }
        return $output;
    }
}