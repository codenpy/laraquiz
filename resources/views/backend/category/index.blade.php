@extends('backend.layouts.base')
@section('content')

    @include('backend.partials.alert')

    <div class="section-body">
        <div class="d-flex mb-2">
            <h4>Category</h4>
            <a href="{{ route('category.create') }}" class="btn btn-success ml-3">Add New Category</a>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <div class="table-responsive">
                        @if($categories)
                            <table id="basic-datatable" class="table table-striped dt-responsive w-100">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ Carbon\Carbon::parse($category->created_at)->format('d-m-Y') }}</td>
                                        <td class="text-start">
                                            <span
                                                class="badge badge-{{ $category->status == 1 ? 'primary' : 'danger' }}">{{ $category->status == 1 ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('category.edit', $category->id) }}" class="btn" data-original-title="Edit">
                                                <button type="submit" class="btn btn-success">Edit</button>
                                            </a>
                                            <a href="#" class="btn tblDelBtn" data-toggle="modal"
                                               data-target="#deleteModal{{ $category->id }}" data-original-title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                    </tr> <!-- End single item -->

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="teamModalCenterTitle" aria-hidden="false">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="teamModalCenterTitle">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center"><h5>Are you sure?</h5></div>
                                                <div class="modal-footer">
                                                    <form class="d-inline-block" action="{{ route('category.destroy', $category->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-success">Yes, delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>No quiz available</h4>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
