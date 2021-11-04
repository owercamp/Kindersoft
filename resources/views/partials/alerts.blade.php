@if(session('Success'))
<div class="alert alert-success w-100 text-center" role="alert">
  <div>{{session('Success')}}</div>
</div>
@endif
@if(session("Error"))
<div class="alert alert-danger w-100 text-center" role="alert">
  <div>{{session('Error')}}</div>
</div>
@endif
@if(session("Update"))
<div class="alert alert-primary w-100 text-center" role="alert">
  <div>{{session('Update')}}</div>
</div>
@endif
@if(session("Delete"))
<div class="alert alert-warning w-100 text-center" role="alert">
  <div>{{session('Delete')}}</div>
</div>
@endif
@if(session("Info"))
<div class="alert alert-info w-100 text-center" role="alert">
  <div>{{session('Info')}}</div>
</div>
@endif