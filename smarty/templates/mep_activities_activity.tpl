<h3>
{$activity}
{if isset($data['activities'][$activity])}
    {if $thirds[$activity]['upper'] < count($data['activities'][$activity])}
        <i class="fa fa-circle traffic-color-1 fa-2x"></i> 
    {elseif $thirds[$activity]['lower'] < count($data['activities'][$activity])}
        <i class="fa fa-circle traffic-color-2 fa-2x"></i>
    {else}
        <i class="fa fa-circle traffic-color-3 fa-2x"></i>
    {/if}
    
{else}
    <i class="fa fa-circle traffic-color-3 fa-2x"></i>
{/if}
<small>
# 
{if isset($data['activities'][$activity])}
    {count($data['activities'][$activity])}
{else}
    0
{/if}
{$t['median']} {$thirds[$activity]['median']}
<a href="http://www.europarl.europa.eu/meps/en/{$data['meta']['person_id']}/seeall.html?type={$activity}" target="_blank"><i class="fa fa-external-link"></i></a>
</small>
</h3>
<div id="chart-{$activity}" data-activity="{$activity}" class="chart-activity"></div>
