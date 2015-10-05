<script>

var graphic_data = {json_encode($data['activities'])};

var minmaxdate = { 'min':new Date(2014,4,1),'max':new Date() }

var $charts = $('.activity-chart');

var graphic_minmaxdate = minmaxdate;

var mobile_threshold = 500;


function drawGraphic() {

    if ($chart.width() < mobile_threshold)
        var margin = { top: 10, right: 5, bottom: 30, left: 5 };
    else
        var margin = { top: 10, right: 30, bottom: 30, left: 40 };
    var timelineplot = [];
    for (i = 0; i<len($charts); i++) {
        $chart = $charts[i];
        var width = $chart.width() - margin.left - margin.right;
        timelineplot.push({
            "data": graphic_data,
            "margin": margin,
            "minmaxdate": graphic_minmaxdate,
            "size":{"width":width,"height":70},
        });
        // clear out existing graphics
        $chart.empty();
    }
    var svgs = d3.select(".chart-activity")
        .append("svg")
        .attr("width",timelineplot[0]['size']['width'])
        .attr("height",timelineplot[0]['size']['height']);
        
    
    
    /* Initialize tooltip */
/*       tip = d3.tip().attr('class', 'd3-tip').html(function(d) { 
      return "<span class=\'stronger\'>" + d + "</span><br>";
    });*/

    /* Invoke the tip in the context of your visualization */
    /*svg.call(tip)*/
    
    
    var tlp = d3.timelineplot()
        .data(function(d) {return d.data})
        .margin(function(d) {return d.margin})
        .minmaxdate(function(d) {return d.minmaxdate})

        
   var timeline = svgs.selectAll(".timelineplot")
    .data(timelineplot)
  .enter()
    .append("svg:g")
    .attr("transform", "translate(" + timelineplot[0].margin.left + "," + timelineplot[0].margin.top + ")")
    .call(tlp);
}

if (Modernizr.svg) { // if svg is supported, draw dynamic chart
    drawGraphic();
    window.onresize = drawGraphic;

}

</script>
