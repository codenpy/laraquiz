<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'correct' => 'required|string',
            'wrong1' => 'nullable|string',
            'wrong2' => 'nullable|string',
            'wrong3' => 'nullable|string',
        ]);

        $question = new Question();
        $question->quiz_id = $request->input('quiz_id');
        $question->question = $request->input('question');
        $question->correct = $request->input('correct');
        $question->wrong1 = $request->input('wrong1');
        $question->wrong2 = $request->input('wrong2');
        $question->wrong3 = $request->input('wrong3');
        $question->save();


        return redirect()->back()->with(['msg' => 'Question Added Successfully', 'type' => 'success']);

    }


    public function update(Request $request, $question_id)
    {
        $request->validate([
            'question' => 'required|string',
            'correct' => 'required|string',
            'wrong1' => 'nullable|string',
            'wrong2' => 'nullable|string',
            'wrong3' => 'nullable|string',
        ]);

        $question = Question::find($question_id);
        $question->quiz_id = $request->input('quiz_id');
        $question->question = $request->input('question');
        $question->correct = $request->input('correct');
        $question->wrong1 = $request->input('wrong1');
        $question->wrong2 = $request->input('wrong2');
        $question->wrong3 = $request->input('wrong3');
        $question->save();

        return redirect()->back()->with(['msg' => 'Question Updated Successfully', 'type' => 'success']);

    }


    public function destroy($question_id)
    {
        $question = Question::find($question_id);
        $question->delete();

        return redirect()->back()->with(['msg' => 'Question has been deleted', 'type' => 'success']);
    }

}
