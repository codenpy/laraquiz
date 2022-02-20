@extends('backend.layouts.base')
@section('content')

@include('backend.partials.alert')

<div class="section-body">
    <div class="d-flex mb-2">
        <h4>{{ $quiz->name }}</h4>
    </div>

    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="car-header">
                    <h4 class="d-flex justify-content-center p-4">Quiz Result
                        ( {{ Carbon\Carbon::parse($quiz->created_at)->format('d-m-Y') }} )</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($results)
                            <table id="basic-datatable" class="table table-striped dt-responsive w-100">
                                <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Phone Number</th>
                                    <th>Score</th>
                                    <th>Passing Score</th>
                                    <th>Result</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($results as $result)
                                    <tr>
                                        @if($result->user->student_id)
                                            <td>{{ $result->user->name }} <br> <span class="font-14">ID: 356395692</span></td>
                                        @else
                                            <td>{{ $result->user->name }}</td>
                                        @endif
                                        <td>{{ $result->user->phone }}</td>
                                        <td>{{ $result->score }}</td>
                                        <td>{{ $quiz->passing_score }}</td>
                                        <td class="text-start">
                                        <span
                                            class="badge badge-{{ $result->score < $quiz->passing_score ? 'danger' : 'success' }}">{{ $result->score < $quiz->passing_score ? 'FAILED' : 'PASSED' }}</span>
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
