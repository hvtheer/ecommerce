<!-- Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBrandModalLabel">Add brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="storeBrand">
              <div class="modal-body">
                <div class="mb-3">
                  <label>Name</label>
                  <input type="text" wire:model.defer="name" class="form-control" />
                  @error('name') <small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                  <label>Slug</label>
                  <input type="text" wire:model.defer="slug" class="form-control" />
                  @error('slug') <small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                  <label>Status</label> <br/>
                  <input type="checkbox" wire:model.defer="status" />Checked = Hidden, Unchecked = Visible
                </div>
                @error('status') <small class="text-danger">{{ $message }}</small>@enderror
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
            
        </div>
    </div>
</div>
