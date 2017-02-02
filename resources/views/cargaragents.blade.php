
 @extends('layout')

@section('content')

    <form method="post"  action="{{ url('addAgents') }}" class="form-horizontal">
        {!! csrf_field() !!}

<fieldset>

<!-- Form Name -->
<legend>CARGAR AGENTES</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="agentId">agente Id</label>  
  <div class="col-md-4">
  <input id="agentId" name="agentId" type="text" placeholder="agente Id" class="form-control input-md" required>
  <span class="help-block">agente Id</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="name">Name agente</label>  
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md" required>
  <span class="help-block">Name</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="zipCode">zip Code</label>  
  <div class="col-md-4">
  <input id="zipCode" name="zipCode" type="text" placeholder="zip Code" class="form-control input-md" required>
  <span class="help-block">zip Code</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="agentId2">agente Id 2</label>  
  <div class="col-md-4">
  <input id="agentId2" name="agentId2" type="text" placeholder="agente Id" class="form-control input-md" required>
  <span class="help-block">agente Id</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="name2">name agente 2</label>  
  <div class="col-md-4">
  <input id="name2" name="name2" type="text" placeholder="name2" class="form-control input-md" required>
  <span class="help-block">help</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="zipCode">zip Code 2</label>  
  <div class="col-md-4">
  <input id="zipCode2" name="zipCode2" type="text" placeholder="zip Code" class="form-control input-md" required>
  <span class="help-block">zip Code</span>  
  </div>
</div>




<!-- Button (Double) -->
<div class="form-group">
  <div class="col-md-8">
    
    <button type="submit" class="btn btn-success">Add Agents</button>
    <a href="{{ url('/') }}" class="btn btn-danger">Cancel</a>
  </div>
</div>

</fieldset>
</form>
     @endsection