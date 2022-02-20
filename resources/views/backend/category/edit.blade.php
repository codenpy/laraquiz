@extends('backend.layouts.base')
@include('backend.partials.alert')

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
    <h3>Edit Quiz</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Category Name <span class="field-required">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{ $category->name }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"> Category Status </label>
                            <select class="form-control form-select" name="status">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 waves-effect">Update</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
