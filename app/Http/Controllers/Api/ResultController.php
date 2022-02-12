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

        $result = new Result();
        $result->quiz_id = $request->get('quiz_id');
        $result->user_id = $request->get('user_id');
        $result->score = $score;

        $result->save();

        //add allscore for user table
        $user = User::find($request->get('user_id'));

        $user->allscore = $user->allscore + $score;

        $user->save();

        return response()->json('Added result data');
    }


    // Get each user quiz results
    public function userResults($user_id)
    {
        $results = Result::where('user_id', $user_id)->latest()->get();

        // get result quizzes based on the user
        //$quizzes = Result::where('user_id', $user_id)->where('')->latest()->get();

        //$questions = Question::where('quiz_id', $quiz_id)->get();

        dd($results);
    }
}
