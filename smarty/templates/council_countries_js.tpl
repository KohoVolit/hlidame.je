<script>

var chart_data = {json_encode($chart_data)};
var upper = {json_encode($chart_years)};
var lower = {json_encode($chart_prime_ministers)};
{literal}
var $charts = $('.chart-presence');
var mobile_threshold = 500;

function drawGraphic() {
    $charts.empty();
    
    var rp = d3.rowplot()
            .data(function(d) {return d.data})
            .margin(function(d) {return d.margin});
    nothing = 0;
    
    for (i in chart_data) {
        $chart = $('#chart-'+i);
        if ($chart.width() < mobile_threshold)
            var margin = { top: 10, right: 5, bottom: 30, left: 40 };
        else
            var margin = { top: 30, right: 60, bottom: 100, left: 40 };
        
        var width = $chart.width() - margin.left - margin.right;
        rowplot = [{
            "data": chart_data[i],
            "margin": margin,
            "size":{"width":width,"height":170},
            "upper": upper[i],
            "lower": lower[i]
        }];
        
        var svg = d3.select("#chart-"+i)
            .append("svg")
            .attr("width",rowplot[0]['size']['width'])
            .attr("height",rowplot[0]['size']['height']); 
        
        var rowpl = svg.selectAll(".rowplot")
            .data(rowplot)
          .enter()
            .append("svg:g")
            .attr("transform", "translate(" + rowplot[0].margin.left + "," + rowplot[0].margin.top + ")")
            .call(rp);
    }
    
}

if (Modernizr.svg) { // if svg is supported, draw dynamic chart
    drawGraphic();
    window.onresize = drawGraphic;
}
    
    
{/literal}
</script>
