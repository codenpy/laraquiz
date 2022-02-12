@extends('backend.layouts.base')
@section('content')

    @include('backend.partials.alert')
    <div class="section-body">
        <div class="d-flex mb-2 justify-content-between">
            <h4>Add New Quiz</h4>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('quiz.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">Quiz Name <span class="field-required">*</span></label>
                                <input class="form-control" type="text" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Quiz Pass Score</label>
                                <input class="form-control" type="text" name="passing_score">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Each Question Time in Seconds</label>
                                <input class="form-control" type="text" name="question_time" value="10">
                            </div>
                            <div class="form-group">
                                <label class="form-label"> Quiz Status </label>
                                <select class="form-control form-select" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 waves-effect">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
