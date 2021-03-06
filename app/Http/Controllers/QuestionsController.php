<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //\DB::enableQueryLog();
        $questions = Question::with('user')->latest()->paginate(5);
        //view('questions.index', compact('questions'))->render();
        //dd(\DB::getQueryLog());
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $question = new Question();
        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        //
        //dd('store');
        $request->user()->questions()->create($request->only('title', 'body'));
        //$request->user()->questions()->create($request->all());
        //return redirect('/questions');
        return redirect()->route('questions.index')->with('success', 'Your question has been submitted');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        $question->increment('views');

        return view('questions.show', compact('question'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
        $this->authorize("update", $question);
        return view('questions.edit', compact('question'));
        //$question = Question::findOrFail($id);
        /** if(\Gate::allows('update-question', $question)){
            **return view('questions.edit', compact('question'));
        **}
        **abort(403, "Access denied"); **/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        //
        $this->authorise('update', $question);
        $question->update($request->only('title', 'body'));
        /**if(\Gate::allows('update-question', $question)){
            return redirect('/questions')->with('success', 'your question has been updated');
        }
        abort(403, "Access denied"); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        $this->authorise('delete', $question);
        $question->delete();
        /** if(\Gate::allows('delete-question', $question)){
           * return redirect('\questions')->with('success', "Your question has been deleted.");
        *}
        *abort(403, "Access denied");**/

    }
}
