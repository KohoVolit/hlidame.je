<div class="modal fade" id="choose-filter-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="{$t['close']}"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{$t['choose_filter']}</h4>
      </div>
      
      <div class="modal-body">
        

            <h3>{$t['choose_filter']}</h3>
            
            
            <h4>{$t['countries']}: 
              <small><a href="#"><span id="select-all-countries">{$t['select_all']}</span></a> / <a href="#"><span id="deselect-all-countries">{$t['deselect_all']}</span></a></small>
            </h4>
                <table class="table table-hover">
                  <tbody>
                    {foreach $all_countries as $country}
                      {if ($country@iteration - 1) is div by 4}
                        <tr>
                      {/if}
                        <td class="col-sm-3">
                        <input type="checkbox" name="cc[]" class="checkbox-cc" value="{$country['code']}"
                        {if (in_array($country['code'],array_keys($selected_countries)))}
                            checked
                        {/if}
                        > <img src="{$country['picture']}" alt="{$t["cc-{$country['code']}"]}" title="{$t["cc-{$country['code']}"]}" /> {$t["cc-{$country['code']}"]}
                    {/foreach} 
                  </tbody>
                </table>
             <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <input type="submit" value="{$t['explore']}" class="btn btn-success btn-block btn-lg">
                    </div>
            </div>
                
            <h4>{$t['groups']}:
                <small><a href="#"><span id="select-all-groups">{$t['select_all']}</span></a> / <a href="#"><span id="deselect-all-groups">{$t['deselect_all']}</span></a></small>
                </h4>
                <table class="table table-hover">
                  <tbody>
                    {foreach $all_groups as $group}
                      {if ($group@iteration - 1) is div by 2}
                        <tr>
                      {/if}
                        <td class="col-sm-6">
                        <input type="checkbox" name="g[]" class="checkbox-g" value="{$group['code']}"
                        {if (in_array($group['code'],array_keys($selected_groups)))}
                            checked
                        {/if}
                        > <img src="{$group['picture']}" alt="{$t["g-{$group['code']}"]}" title="{$t["g-{$group['code']}"]}" /> {$t["g-{$group['code']}"]}
                    {/foreach} 
                  </tbody>
                </table>
                
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <input type="submit" value="{$t['explore']}" class="btn btn-success btn-block btn-lg">
                    </div>
                </div>
                

      </div>

    </div>
  </div>
</div>
