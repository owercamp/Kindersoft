@if(session('Success'))
<div class="alert alert-success text-center rounded" role="alert">
  {{session('Success')}}
</div>
@elseif(session('Warning'))
<div class="alert alert-warning text-center rounded" role="alert">
  {{session('Warning')}}
</div>
@elseif(session('Error'))
<div class="alert alert-danger text-center rounded" role="alert">
  {{session('Error')}}
</div>
@elseif(session('Info'))
<div class="alert alert-secondary text-center rounded" role="alert">
  {{session('Info')}}
</div>
@endif