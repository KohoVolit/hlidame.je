{extends file='main.tpl'}
{block name=additionalHead}
<link id="bsdp-css" href="{$app_url}libs/datepicker3.css" rel="stylesheet">
<script src="//cdn.bootcss.com/d3/3.5.6/d3.min.js"></script>
<script src="{$app_url}libs/modernizr.svg.js"></script>
<script src="{$app_url}libs/d3.rowplot.js"></script>
<script src="{$app_url}libs/bootstrap-datepicker.js"></script>
<script src="{$app_url}libs/locales/bootstrap-datepicker.{$lang}.js" charset="UTF-8"></script>
{/block}
{block name=body}
    <script>
        //de-select all countries and groups
        $(function() {
            $("#select-all-countries").click(function(){
                $(".checkbox-cc").attr('checked',true);
                $(".checkbox-cc").prop('checked', 'checked');
            });
            $("#select-all-configurations").click(function(){
                $(".checkbox-co").attr('checked',true);
                $(".checkbox-co").prop('checked', 'checked');
            });
            $("#deselect-all-countries").click(function(){
                $(".checkbox-cc").attr('checked',false);
                $(".checkbox-cc").prop('checked', '');
            });
            $("#deselect-all-configurations").click(function(){
                $(".checkbox-co").attr('checked',false);
                $(".checkbox-co").prop('checked', '');
            });
        })    
        
    </script>
    
    <h1>{$t['c_title']}</h1>
    
    <!-- buttons -->    
    <div class="row">
        <div class="col-sm-3"></div>

        
        <div class="col-sm-6">
            <button class="btn btn-primary btn-lg btn-block" data-target="#council-filter-modal" data-toggle="modal"><strong><span class="caret"></span> {$t['choose_filter']}</strong></button>
        </div>
    </div>
    
    <form id="filter-form">
    <!-- filter  -->
        {include "council_filter.tpl"}
    <!-- /filter -->
    
        <!-- data -->
        <h3></h3>
        <!-- filter -->
        <div class="alert alert-warning">
            <h4><i class="fa fa-filter"></i> {$t['filter']}</h4>
            <p>
            {$t['groups']}:
            {foreach $selected_configurations as $configuration}
                <span class="label label-primary">{$t["co-{$configuration['configuration_code']}"]}</a></span>
            {/foreach}
            <p>
            {$t['countries']}:
            {foreach $selected_countries as $country}
                <span class="label label-primary"><img src="{$country['picture']}" alt="{$t["cc-{$country['code']}"]}" title="{$t["cc-{$country['code']}"]}" /> {$t["cc-{$country['code']}"]}</span>
            {/foreach}
            <p>
            {$t['time_filter']}:
            {$sd|date_format:"%x"} - {$ed|date_format:"%x"}
        </div>
        <!-- /filter -->
    </form>
    
    <!-- activities -->
    {include "council_countries.tpl"}
    <!-- /activities -->
    
{/block}
