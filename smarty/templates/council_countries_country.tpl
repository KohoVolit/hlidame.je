<h3>
{if $country['mean'] > $mean}
        <i class="fa fa-circle traffic-color-1 fa-2x"></i> 
{elseif $country['mean'] < $mean}
    <i class="fa fa-circle traffic-color-3 fa-2x"></i> 
{else}
    <i class="fa fa-circle traffic-color-2 fa-2x"></i> 
{/if}

{$t["cc-{$country['country_code']}"]} <img src="http://www.europarl.europa.eu/ep_framework/img/flag/flag_icon_{$country['country_code']}.gif" width="24" height="15" alt="{$country['country_code']}" title='{$t["cc-{$country['country_code']}"]}'> 
<small>
{$t["average_minister_presence"]}: {$country['mean']} %
</small>
</h3>
<div class="chart-presence" id="chart-{$country['country_code']}" data-cc="{$country['country_code']}"></div>
