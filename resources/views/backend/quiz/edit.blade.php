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
                    <form action="{{ route('quiz.update', $quiz->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Quiz Name <span class="field-required">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{ $quiz->name }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Quiz Pass Score</label>
                            <input class="form-control" type="text" name="passing_score"
                                   value="{{ $quiz->passing_score }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Each Question Time in Seconds</label>
                            <input class="form-control" type="text" name="question_time" value="{{ $quiz->question_time }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label"> Quiz Status </label>
                            <select class="form-control form-select" name="status">
                                <option value="1" {{ $quiz->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $quiz->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 waves-effect">Update</button>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('question.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                        <div class="form-group">
                            <label class="form-label">Question <span class="field-required">*</span></label>
                            <input class="form-control" type="text" name="question" value="" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Correct Answer <span class="field-required">*</span></label>
                            <input class="form-control" type="text" name="correct" value="" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Wrong Answer <span class="field-required">*</span></label>
                            <input class="form-control" type="text" name="wrong1" value="" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Wrong Answer</label>
                            <input class="form-control" type="text" name="wrong2" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Wrong Answer</label>
                            <input class="form-control" type="text" name="wrong3" value="">
                        </div>
                    </div>
                </div>

                <button type="submit" style="margin: 0 auto; padding: 10px"
                        class="btn btn-info mt-3 mb-3 waves-effect d-flex">Add Question
                </button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        @if($questions)
                            <table id="basic-datatable" class="table table-striped dt-responsive w-100">
                                <thead>
                                <tr>
                                    <th>Questions</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            {{ $question['question'] }} <br>
                                        
                                                <span class="badge badge-success">{{ $question['options']['correct'] }}</span>
                                                <span class="badge badge-danger">{{ $question['options']['wrong1'] }}</span>
                                                <span class="badge badge-danger">{{ $question['options']['wrong2'] }}</span>
                                                <span class="badge badge-danger">{{ $question['options']['wrong3'] }}</span>
                                          
                                        </td>
                                        <td>
                                            <a href="#" class="btn"
                                               data-toggle="modal" data-target="#editModal{{ $question['id'] }}"
                                               data-original-title="Edit">
                                                <button type="submit" class="btn btn-success">Edit</button>
                                            </a>
                                            <a href="#" class="btn tblDelBtn" data-toggle="modal"
                                               data-target="#deleteModal{{ $question['id'] }}"
                                               data-original-title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                    </tr> <!-- End single item -->

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $question['id'] }}" tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="teamModalCenterTitle" aria-hidden="false">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form class="d-inline-block"
                                                      action="{{ route('question.update', $question['id']) }}"
                                                      method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="teamModalCenterTitle">Edit
                                                            Question</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                                                        <div class="form-group">
                                                            <label class="form-label">Question <span
                                                                    class="field-required">*</span></label>
                                                            <input class="form-control" type="text" name="question"
                                                                   value="{{ $question['question'] }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Correct Answer <span
                                                                    class="field-required">*</span></label>
                                                            <input class="form-control" type="text" name="correct"
                                                                   value="{{ $question['correct'] }}"
                                                                   required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Wrong Answer <span
                                                                    class="field-required">*</span></label>
                                                            <input class="form-control" type="text" name="wrong1"
                                                                   value="{{ $question['options']['wrong1'] }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Wrong Answer</label>
                                                            <input class="form-control" type="text" name="wrong2"
                                                                   value="{{ $question['options']['wrong2'] }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Wrong Answer</label>
                                                            <input class="form-control" type="text" name="wrong3"
                                                                   value="{{ $question['options']['wrong3'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-success">Update</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="deleteModal{{ $question['id'] }}" tabindex="-1"
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
                                                          action="{{ route('question.destroy', $question['id']) }}"
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
