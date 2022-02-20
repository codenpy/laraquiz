<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index()
    {
        $quizes = Quiz::orderBy('id','desc')->get();

        return view('backend.quiz.index', compact('quizes'));
    }


    public function create()
    {
        return view('backend.quiz.create');
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'passing_score' => 'nullable|integer',
            'question_time' => 'required|integer',
            'status' => 'nullable|integer',
        ]);

        $quiz = new Quiz();
        $quiz->user_id = 1;
        $quiz->name = $request->input('name');
        $quiz->passing_score = $request->input('passing_score');
        $quiz->question_time = $request->input('question_time');
        $quiz->status = $request->input('status');

        $quiz->save();

        return redirect()->route('quiz.edit', $quiz->id)->with(['msg' => 'Quiz Added Successfully', 'type' => 'success']);

    }


    public function single($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $results = Result::with('user')->where('quiz_id', $quiz_id)->get();
        //dd($results);

        return view('backend.quiz.single', compact('quiz', 'results'));
    }



    public function edit($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $all_questions = Question::where('quiz_id', $quiz_id)
            ->orderBy('id', 'desc')
            ->get();


        $questions = array();
        foreach ($all_questions as $question) {
            $option_array = array();
            $option_array['correct'] = $question->correct;
            $option_array['wrong1'] = $question->wrong1;
            $option_array['wrong2'] = $question->wrong2;
            $option_array['wrong3'] = $question->wrong3;

            $item_array = array(
                'id' => $question->id,
                'question' => $question->question,
                'correct' => $question->correct,
                'selected_option' => $question->selected_option,
                'options' => $option_array
            );

            array_push($questions, $item_array);
        }

        //dd($questions);

        //return response()->json($questions);
        return view('backend.quiz.edit', compact('quiz', 'questions'));
    }


    public function update(Request $request, $id)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'passing_score' => 'nullable|integer',
            'question_time' => 'required|integer',
            'status' => 'nullable|integer',
        ]);

        $quiz = Quiz::find($id);

        $quiz->user_id = 1;
        $quiz->name = $request->input('name');
        $quiz->passing_score = $request->input('passing_score');
        $quiz->question_time = $request->input('question_time');
        $quiz->status = $request->input('status');

        $quiz->save();

        return redirect()->back()->with(['msg' => 'Quiz Updated Successfully', 'type' => 'success']);
    }


    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        $quiz->delete();

        return redirect()->route('quiz.index')->with(['msg' => 'Quiz has been deleted', 'type' => 'success']);
    }


}
