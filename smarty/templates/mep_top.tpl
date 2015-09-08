<div class="row" id="mep-top">
  <div class="col-sm-1"></div>
  <div class="col-sm-3">
    <div class="pull-right">
      <img width="113" height="143" src="http://www.europarl.europa.eu/mepphoto/{$data['meta']['person_id']}.jpg" class="img-circle" />
    </div>
  </div>
  <div class="col-sm-8">  
    <ul>
      <li><h1><strong>{$data['meta']['person_name']}</strong></h1></li>
      <li><strong>{$data['meta']['party_name']}</strong>
      <li><img src="{$data['meta']['group_picture']}" alt="{$data['meta']['group_name']}" title="{$data['meta']['group_name']}" /> <strong>{$data['meta']['group_name']}</strong> 
      <li><img src="{$data['meta']['country_picture']}" alt="{$data['meta']['country_name']}" title="{$data['meta']['country_name']}" /> <strong>{$data['meta']['country_name']}</strong> 
    </ul>
  </div>
</div> <!-- /row -->
