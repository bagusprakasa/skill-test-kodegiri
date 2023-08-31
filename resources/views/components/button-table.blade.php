@if (Request::segment(1) != 'product-gallery' && Request::segment(2) != 'show-gallery')
    <button type="button" class="btn btn-icon btn-round btn-primary"
        onClick="editRow('{{ route(Request::segment(1) . '.edit', $item->id) }}')" data-toggle="tooltip"
        data-placement="top" title="Edit">
        <i class="fas fa-pencil-alt"></i>
    </button>
@endif
<button type="button" class="btn btn-icon btn-round btn-danger"
    onClick="deleteRow({{ $item->id }},'{{ $item->name }}')" data-toggle="tooltip" data-placement="top"
    title="Delete">
    <i class="fas fa-trash"></i>
</button>
@php
    $route = Request::segment(2) != 'show-gallery' ? Request::segment(1) : 'product-gallery';
@endphp
<form action="{{ route($route . '.destroy', $item->id) }}" id="deleteAction{{ $item->id }}" method="POST">
    @csrf
    @method('DELETE')
</form>
