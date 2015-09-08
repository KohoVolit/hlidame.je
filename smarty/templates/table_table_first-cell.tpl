<th>
{if $show == 'people'}
    <img src="{$row['meta']['country_picture']}" alt="{$row['meta']['country_name']}" title="{$row['meta']['country_name']}" />
    <img src="{$row['meta']['group_picture']}" alt="{$row['meta']['group_name']}" title="{$row['meta']['group_name']}" />
    <a href="./mep.php?id={$row['meta']['person_id']}">{$row['meta']['person_name']}</a>
    {if ($row['meta']['weight'] < 1)}
        <span title="{$t['not_whole_term']}"><sup>½</sup></span>
    {/if}
    <br/><small>{$row['meta']['party_name']}</small>
    
{elseif $show == 'parties'}
    {$row['meta']['party_name']} <small>({$row['meta']['weight']})</small>
    
{elseif $show == 'groups'}
    <img src="{$row['meta']['group_picture']}" alt="{$row['meta']['group_name']}" title="{$row['meta']['group_name']}" /><a href="#">{$row['meta']['group_name']} <small>({$row['meta']['weight']})</small></a> 
    
{else if $show == 'countries'}
    <img src="{$row['meta']['country_picture']}" alt="{$row['meta']['country_name']}" title="{$row['meta']['country_name']}" /> <a href="#">{$row['meta']['country_name']} <small>({$row['meta']['weight']})</small></a> 
{/if}
