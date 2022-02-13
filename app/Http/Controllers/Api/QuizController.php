<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\SelectedOption;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::orderBy('id', 'desc')->where('status', 1)->get();

        return response()->json(['quizzes' => $quizzes]);
    }


    public function edit($quiz_id)
    {
        $questions = Question::where('quiz_id', $quiz_id)->get();


        $quiz = Quiz::find($quiz_id);
        $quiz_info = array(
            'passing_score' => $quiz->passing_score,
            'question_time' => $quiz->question_time,
        );


        $question_data = array();
        foreach ($questions as $question) {

            $option_array = array();
            $option_array[] = $question->correct;
            $option_array[] = $question->wrong1;
            $option_array[] = $question->wrong2;
            $option_array[] = $question->wrong3;

            $item_array = array(
                'id' => $question->id,
                'quiz_id' => $question->quiz_id,
                'question' => $question->question,
                'correct' => $question->correct,
                'options' => $option_array
            );

            array_push($question_data, $item_array);
        }

        return response()->json(['questions' => $question_data, 'quiz_info' => $quiz_info]);
    }


    public function quizOptionSelected(Request $request, $question_id)
    {
        //dd($request->all());
        $selected_option = new SelectedOption();
        $selected_option->user_id = $request->get('user_id');
        $selected_option->quiz_id = $request->get('quiz_id');
        $selected_option->question_id = $question_id;
        $selected_option->selected_option = $request->get('selected_option');
        $selected_option->save();

        return response()->json('Select option added successfully');


    }


}
