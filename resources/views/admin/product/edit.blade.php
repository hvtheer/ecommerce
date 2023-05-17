@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Edit Product
                    <a href="{{ url('admin/product') }}" class="btn btn-danger btn-sm text-white float-end">BACK</a>
                </h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif
                <form action="{{ url('admin/product/'.$product->id )}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">
                                Home
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seotag-tab" data-bs-toggle="tab" data-bs-target="#seotag"
                                type="button" role="tab" aria-controls="seotag" aria-selected="false">
                                SEO Tag
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details" aria-selected="false">
                                Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images"
                                type="button" role="tab" aria-controls="images" aria-selected="false">
                                Images
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade border p-3 show active" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Selecect category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected':'' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Product name</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label>Product slug</label>
                                <input type="text" name="slug" value="{{ $product->slug }}" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label>Brand</label>
                                <select name="brand" class="form-control">
                                    <option value="">Selecect brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->name }}"
                                        {{ $brand->name == $product->brand ? 'selected':'' }}>
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Small description (500 words)</label>
                                <textarea name="small_description" class="form-control"
                                    rows="3">{{ $product->small_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control"
                                    rows="3">{{ $product->description }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade border p-3" id="seotag" role="tabpanel" aria-labelledby="seotag-tab">
                            <div class="mb-3">
                                <label>Meta title</label>
                                <input type="text" name="meta_title" value="{{ $product->meta_title }}"
                                    class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label>Meta description</label>
                                <textarea name="meta_description" class="form-control"
                                    rows="3">{{ $product->meta_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label>Meta keyword</label>
                                <textarea name="meta_keyword" class="form-control"
                                    rows="3">{{ $product->meta_keyword }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade border p-3" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Original price</label>
                                        <input type="text" name="original_price" value="{{ $product->original_price }}"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Selling price</label>
                                        <input type="text" name="selling_price" value="{{ $product->selling_price }}"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Quantity</label>
                                        <input type="number" name="quantity" value="{{ $product->quantity }}"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Trending</label> </br>
                                        <input type="checkbox" name="trending"
                                            {{ $product->trending ? 'checked':'' }} />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Status</label> </br>
                                        <input type="checkbox" name="status" {{ $product->status ? 'checked':'' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade border p-3" id="images" role="tabpanel" aria-labelledby="images-tab">
                            <div class="mb-3">
                                <label>Upload product's images</label>
                                <input type="file" name="image[]" multiple class="form-control" />
                                <div class="row">
                                    @foreach ($product->productImages as $image)
                                    <div class="col-md-2">
                                        <img src="{{ asset($image->image) }}" style="width: 80px; height: 80px;"
                                            class="me-4" alt="img">
                                        <a href="{{ url('admin/product-image/'.$image->id.'/delete')}}"
                                            class="d-block">Remove</a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
