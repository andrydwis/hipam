@if (session('success'))
<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
</div>
@elseif(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{session('error')}}
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
</div>
@endif