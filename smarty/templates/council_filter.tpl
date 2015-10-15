<div class="modal fade" id="council-filter-modal" tabindex="-1" role="dialog">
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
            
            <h4>{$t['time_filter']}:</h4>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <h5>{$t['since']}:</h5>
                    <input id="sd" name="sd" type="text" class="form-control" value="{$sd}">
                </div>
                <div class="col-sm-4">
                    <h5>{$t['until']}:</h5>
                    <input id="ed" name="ed" type="text" class="form-control" value="{$ed}">
                </div>
            </div>
            <br>
            <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <input type="submit" value="{$t['explore']}" class="btn btn-success btn-block btn-lg">
                    </div>
            </div>    
             
                
            <h4>{$t['configurations']}:
                <small><a href="#"><span id="select-all-configurations">{$t['select_all']}</span></a> / <a href="#"><span id="deselect-all-configurations">{$t['deselect_all']}</span></a></small>
                </h4>
                <table class="table table-hover">
                  <tbody>
                    {foreach $all_configurations as $configuration}
                      {if ($configuration@iteration - 1) is div by 2}
                        <tr>
                      {/if}
                        <td class="col-sm-6">
                        <input type="checkbox" name="co[]" class="checkbox-co" value="{$configuration['configuration_code']}"
                        {if (in_array($configuration['configuration_code'],array_keys($selected_configurations)))}
                            checked
                        {/if}
                        > {$t["co-{$configuration['configuration_code']}"]}
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

<script>
    $('#sd').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        startView: 2,
        language: "{$lang}"
    });
    $('#ed').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        startView: 2,
        language: "{$lang}"
    });
</script>
