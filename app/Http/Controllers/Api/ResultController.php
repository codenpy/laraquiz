<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $quiz_id = $request->query('quiz_id');
        $questions = Question::where('quiz_id', $quiz_id)->get();

        $user_id = $request->query('user_id');
        $result = Result::where('quiz_id', $quiz_id)->where('user_id', $user_id)->latest()->first();
        $total_score = $result ? $result->score : null;

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
                'question' => $question->question,
                'correct' => $question->correct,
                'selected_option' => $question->selected_option,
                'options' => $option_array
            );

            array_push($question_data, $item_array);
        }

        return response()->json(['questions' => $question_data, 'total_score' => $total_score, 'quiz_info' => $quiz_info]);
    }



    public function addResult(Request $request)
    {
        //dd($request->all());
        // convert string to integer
        $score = (int)$request->get('score');
        $user_id = $request->get('user_id');
        $quiz_id = $request->get('quiz_id');

        $result = Result::where('user_id', $user_id)->where('quiz_id', $quiz_id)->first();
        if ($result === null)
        {
            $result = new Result(
                [
                    'user_id' => $user_id,
                    'quiz_id' => $quiz_id,
                    'score' => $score,
                ]
            );
        }
        $result->quiz_id = $quiz_id;
        $result->user_id = $user_id;
        $result->score = $score;
        $result->save();


        //add allscore for user table
        $user = User::find($request->get('user_id'));

        $user->allscore = $user->allscore + $score;

        $user->save();

        return response()->json('Added result data');
    }


    // Get each quiz result based on the user id
    public function userTakenQuiz($user_id)
    {
        $user_results = Result::where('user_id', $user_id)->latest()->get();

        $quizzes = [];
        foreach ($user_results as $user_result)
        {
            $quiz = Quiz::find($user_result->quiz_id);
            $questions = Question::where('quiz_id', $user_result->quiz_id)->get();

            $item_array = array(
                'id' => $quiz->id,
                'name' => $quiz->name,
                'passing_score' => $quiz->passing_score,
                'quiz_taken_time' => $user_result->created_at,
                'score' => $user_result->score,
                'total_question' => count($questions),
            );

            array_push($quizzes, $item_array);
        }


        return response()->json(['quizzes' => $quizzes]);
    }


    public function userTakenQuizResult(Request $request, $quiz_id)
    {
        //$questions = Question::with('selectedOptions')->where('quiz_id', $quiz_id)->get();
        $questions = Question::with(['selectedOptions' => function($q){
            $q->where('user_id', \request()->get('user_id'));
        }])->where('quiz_id', $quiz_id)->get();

        $quiz = Quiz::find($quiz_id);
        $quiz_info = array(
            'passing_score' => $quiz->passing_score,
            'question_time' => $quiz->question_time,
        );

        return response()->json(['questions' => $questions, 'quiz_info' => $quiz_info]);
    }
}
