<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizes = Quiz::orderBy('id', 'desc')->where('status', 1)->get();

        return response()->json(['quizes' => $quizes]);
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

        $question = Question::find($question_id);
        $question->selected_option = $request->get('selected_option');
        $question->save();
        return response()->json('Select option updated successfully');


    }


}
