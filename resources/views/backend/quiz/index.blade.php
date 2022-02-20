@extends('backend.layouts.base')
@section('content')

    @include('backend.partials.alert')

    <div class="section-body">
        <div class="d-flex mb-2">
            <h4>Quiz</h4>
            <a href="{{ route('quiz.create') }}" class="btn btn-success ml-3">Add New Quiz</a>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($quizes)
                                <table id="basic-datatable" class="table table-striped dt-responsive w-100">
                                    <thead>
                                    <tr>
                                        <th>Quiz Name</th>
                                        <th>Passing Score</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($quizes as $quiz)
                                        <tr>
                                            <td><a href="{{ route('quiz.single', $quiz->id) }}">{{ $quiz->name }}</a>
                                            </td>
                                            <td>{{ $quiz->passing_score }}</td>
                                            <td>{{ Carbon\Carbon::parse($quiz->created_at)->format('d-m-Y') }}</td>
                                            <td class="text-start">
                                            <span
                                                class="badge badge-{{ $quiz->status == 1 ? 'primary' : 'danger' }}">{{ $quiz->status == 1 ? 'Active' : 'Inactive' }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn"
                                                   data-original-title="Edit">
                                                    <button type="submit" class="btn btn-success">Edit</button>
                                                </a>
                                                <a href="#" class="btn tblDelBtn" data-toggle="modal"
                                                   data-target="#deleteModal{{ $quiz->id }}"
                                                   data-original-title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr> <!-- End single item -->

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="deleteModal{{ $quiz->id }}" tabindex="-1"
                                             role="dialog"
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
                                                        <form class="d-inline-block"
                                                              action="{{ route('quiz.destroy', $quiz->id) }}"
                                                              method="POST">
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
