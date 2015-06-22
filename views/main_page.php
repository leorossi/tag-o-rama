<?php
    wp_enqueue_script('ChartJS', TAGORAMA_PLUGIN_URL . "js/Chart.js");
    wp_enqueue_script('tagorama-app', TAGORAMA_PLUGIN_URL . "js/tagorama.js");
?>

<script type="text/javascript">
    // Global-like variables for ajax call
    var bloginfo = '<?php bloginfo('url') ?>';
</script>
<div class="wrap" id="tagorama-container">
    <h2>Tag-O-Rama main page</h2>
    <p>Press the button to generate some new posts, and apply random tags.</p>
    <form action="<?php echo $_REQUEST['URI'] ?>" method="POST">
        <input type="hidden" name="generate_posts" value="1"/>
        <input type="submit" value="Generate random posts" class="button button-primary"/>
    </form>

    <h2>Post/Tag distribution</h2>
    <p>This chart shows the distribution of tags in all posts. </p>
    <canvas id="tagChart"></canvas>
</div>
