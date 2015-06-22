jQuery(function() {

    var chartData = {
        labels: [],
        datasets: [
            {
                label: "Post Tags",
                data: []
            }
        ]
    };


    init();

    function init() {
        // Resize canvas
        resizeCanvas();
        getStats();
    }

    /**
     * Resize the canvas to match its parent's width
     */
    function resizeCanvas() {
        var canvas = document.getElementById("tagChart");
        var ctx = canvas.getContext("2d");
        var parent = jQuery('#tagorama-container');
        ctx.canvas.width = parent.width();
        ctx.canvas.height = 500;
        drawChart();
    }

    /**
     * Get stats from the server
     */
    function getStats() {
        jQuery.ajax({
            url: bloginfo + '/wp-admin/admin-ajax.php',
            data:{
                'action':'do_ajax',
                'fn':'tagorama_get_tags_stats'
            },
            dataType: 'JSON',
            success:function(response){
                console.log(response.data);
                for (var i = 0; i < response.data.length; i++) {
                    var tag = response.data[i];
                    chartData.labels.push(tag.name);
                    chartData.datasets[0].data.push(tag.posts.length);
                }

                drawChart();

            }


        });

    }

    /**
     * Draw the cart canvas.
     */
    function drawChart() {
        var ctx = document.getElementById("tagChart").getContext("2d");
        var tagChart = new Chart(ctx).Bar(chartData);
    }
})
