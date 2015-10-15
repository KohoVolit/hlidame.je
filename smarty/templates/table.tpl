{extends file='main.tpl'}
{block name=additionalHead}
<script src="{$app_url}libs/jquery.stickytableheaders.min.js"></script>
<script src="{$app_url}libs/sorttable.js"></script>
{/block}
{block name=body}

    <script>
        //shows and hides 
        $(function() {
            $(".show-details").click(function(){
                $("#"+this.id+"-body").show(100);
                $("#"+this.id).hide();
            });
        })
        $(function () {
            $("#explore-table").stickyTableHeaders();
        });
        $(function () {
          $('[data-toggle="popover"]').popover()
        });

        //de-select all countries and groups
        $(function() {
            $("#select-all-countries").click(function(){
                $(".checkbox-cc").attr('checked',true);
                $(".checkbox-cc").prop('checked', 'checked');
            });
            $("#select-all-groups").click(function(){
                $(".checkbox-g").attr('checked',true);
                $(".checkbox-g").prop('checked', 'checked');
            });
            $("#deselect-all-countries").click(function(){
                $(".checkbox-cc").attr('checked',false);
                $(".checkbox-cc").prop('checked', '');
            });
            $("#deselect-all-groups").click(function(){
                $(".checkbox-g").attr('checked',false);
                $(".checkbox-g").prop('checked', '');
            });
        })    
        
        //shows and hides forms
        $(function() {
            $("#show-suggest-edits").click(function(){
                $(".suggest-edits-hidden").show(1000);
                $(".suggest-edits-hide").hide(1000);
            });
            $("#hide-suggest-edits").click(function(){
                $(".suggest-edits-hidden").hide(1000);
                $(".suggest-edits-hide").show(1000);
            });

        })
{*        //shows and hides *}
{*        $(function() {*}
{*            $(".read-more").click(function(){*}
{*                $("#"+this.id+"-rest").show(100);*}
{*                $("#"+this.id).hide();*}
{*            });*}
{*        })*}
    </script>

    <h1>{$t['title']}</h1>

    <!-- buttons -->    
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#choose-show-modal"><strong><span class="caret"></span> {$t['choose_show']}</strong></button>
        </div>
        
        <div class="col-sm-4">
            <button class="btn btn-primary btn-lg btn-block" data-target="#choose-filter-modal" data-toggle="modal"><strong><span class="caret"></span> {$t['choose_filter']}</strong></button>
        </div>
    </div>
    
    <form id="explore-form">
    <!-- choose categories -->
        {include "table_choose-show.tpl"}
    <!-- /choose categories -->
    
    <!-- choose chambers -->
        {include "table_choose-filter.tpl"}
    <!-- /choose chambers -->  
    
    <!-- table -->
        <h3></h3>
        <!-- filter -->
        <div class="alert alert-warning">
            <h4><i class="fa fa-filter"></i> {$t['filter']}</h4>
            <p>
            {$t['groups']}:
            {foreach $selected_groups as $group}
                <span class="label label-primary"><a href="?{$group['internal_link']}">{$group['abbreviation']}</a></span>
            {/foreach}
            <p>
            {$t['countries']}:
            {foreach $selected_countries as $country}
                <span class="label label-primary"><a href="?{$country['internal_link']}"><img src="{$country['picture']}" alt="{$t["cc-{$country['code']}"]}" title="{$t["cc-{$country['code']}"]}" /> {$t["cc-{$country['code']}"]}</a></span>
            {/foreach}
        </div>
        <!-- /filter -->

    </form>
        <div class="alert alert-info">
            <h4><i class="fa fa-info-circle"></i> {$t['info']}</h4>
            <p>{$t['info_explanation']}
            
        </div>
        {include "table_table.tpl"}
    <!-- table -->


{/block}
