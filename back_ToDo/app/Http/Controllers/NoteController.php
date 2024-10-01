<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\User;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $notes = Note::all();

            return response()->json([
                'message' => 'Notes found',
                'notes' => $notes
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'notes' => null
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            $date = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'creation_date' => 'required|date',
                'due_date' => 'required|date',
                'user_id' => 'required|integer',
                'tags' => 'required|string',
                'image' => 'required|string',
            ]);
            
            $user = User::find($date['user_id']);

            if(!$user){
                return response()->json([
                    'message' => 'User not found',
                    'note' => null
                ], 400);
            }

            $note = Note::create($date);
    
            return response()->json([
                'message' => 'Note created successfully',
                'note' => $note
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'note'  => null
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $date = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'creation_date' => 'required|date',
                'due_date' => 'required|date',
                'user_id' => 'required|integer',
                'tags' => 'required|string',
                'image' => 'required|string',
            ]);
    
            $note = Note::create($date);
    
            return response()->json([
                'message' => 'Note created successfully',
                'note' => $note
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'note' => null
            ], 400);
        }
         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $note = Note::find($id);

            return response()->json([
                'message' => 'Note found',
                'note' => $note
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'note' => null
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $note = Note::find($id);

            return response()->json([
                'message' => 'Note found',
                'note' => $note
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'note' => null
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $date = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'creation_date' => 'required|date',
                'due_date' => 'required|date',
                'user_id' => 'required|integer',
                'tags' => 'required|string',
                'image' => 'required|string',
            ]);
    
            $user = User::find($date['user_id']);
            
            if(!$user){
                return response()->json([
                    'message' => 'User not found',
                    'note' => null
                ], 400);
            }

            $note = Note::find($id);

            if(!$note){
                return response()->json([
                    'message' => 'Note not found',
                    'note' => null
                ], 400);
            }

            $note->update($date);
    
            return response()->json([
                'message' => 'Note updated successfully',
                'note' => $note
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'note' => null
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $note = Note::find($id);

            if(!$note){
                return response()->json([
                    'message' => 'Note not found',
                    'note' => null
                ], 400);
            }

            $note->delete();

            return response()->json([
                'message' => 'Note deleted successfully',
                'note' => $note
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'note' => null
            ], 400);
        }
    }
    
    /**
    * Display a listing of the resource sorted by creation date or due date.
    */
    public function getNotesSorted(Request $request)
    {
        try {
            $sortBy = $request->query('sort_by', 'creation_date'); // Valor predeterminado
    
            // Validar el parámetro de ordenación
            if (!in_array($sortBy, ['creation_date', 'due_date'])) {
                return response()->json([
                    'message' => 'Invalid sort parameter. Use "creation_date" or "due_date".',
                    'notes' => null
                ], 400);
            }
    
            // Obtener las notas ordenadas
            $notes = Note::orderBy($sortBy)->get();
    
            return response()->json([
                'message' => 'Notes found and sorted by ' . $sortBy,
                'notes' => $notes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'notes' => null
            ], 400);
        }
    }
}
