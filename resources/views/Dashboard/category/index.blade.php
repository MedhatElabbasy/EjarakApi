@extends('Dashboard.layouts.app')
@section('title')
Category Dashboard
@endsection



@section('content')
@livewire('Dashboard.admin.category.category-livewire')
@endsection

@section('script')
<script>
    window.addEventListener('close-modal', event => {

        $('#catModal').modal('hide');
        $('#updateCatModal').modal('hide');
        $('#deleteCatModal').modal('hide');
    })
</script>
@endsection
