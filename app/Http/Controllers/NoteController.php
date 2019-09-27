<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $note = new Note();
        $note->user_id = Auth::id();
        $note->title = $request->title;
        $note->notes = nl2br($request->notes);
        $note->save();

        return back()->with('is_notes');
    }

    public function details(Request $request)
    {
        $id = $request->id;
        $note = Note::findOrFail($id);
        
        return \Response::json($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function updating(Request $request)
    {
        $note = Note::findOrFail($request->id);
        if(!empty($note)){
            $note->title = $request->title;
            $note->notes = nl2br($request->notes);
            $note->update();

            return redirect()->back()->with('note_saved','Saved');
        }
        return redirect()->back()->with('note_save_error','Error');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        
    }

    public function delt(Request $request){

        $note = Note::findOrFail($request->id);
        if(!empty($note)){
            $note->delete();

            return \Response::json(1);
        }
        return \Response::json(2);
    }
}
