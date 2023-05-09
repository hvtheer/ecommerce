<div>
    @include('livewire.admin.brand.modal-form')

    <div class="row">
        <div class="col-md-12">
            {{-- @if (session('message'))
            <h2 class="alert alert-success">{{ session('message') }}</h2>
            @endif --}}
            <div class="card">
                <div class="card-header">
                    <h4>Brand
                        <a href="#" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                            data-bs-target="#addBrandModal">Add brand</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                            <tr>
                                <td>
                                    {{ $brand->id }}
                                </td>
                                <td>
                                    {{ $brand->name }}
                                </td>
                                <td>
                                    {{ $brand->slug }}
                                </td>
                                <td>
                                    {{ $brand->status == '1' ? 'Hidden':'Visible' }}
                                </td>
                                <td>
                                    <a href="#" wire:click="editBrand({{$brand->id}})" data-bs-toggle="modal"
                                        data-bs-target="#updateBrandModal" class="btn btn-success">Edit</a>
                                    <a href="#" wire:click="deleteBrand({{$brand->id}})" data-bs-toggle="modal"
                                        data-bs-target="#deleteBrandModal" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination">
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    window.addEventListener('close-modal', event => {
        $('#addBrandModal').modal('hide');
        $('#updateBrandModal').modal('hide');
        $('#deleteBrandModal').modal('hide');
    });

</script>
@endpush