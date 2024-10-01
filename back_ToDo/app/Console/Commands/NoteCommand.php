<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use App\Models\User;

class NoteCommand extends Command
{

    protected $signature = 'note {action} {--id=} {--user=} {--title=} {--description=} {--due_date=} {--tags=} {--image=}';
    protected $description = 'Interactuar con las notas';
    
    protected $noteController;
    
    public function __construct(NoteController $noteController)
    {
        parent::__construct();
        $this->noteController = $noteController;
    }
    
    public function handle()
    {
        $action = $this->argument('action');
    
        try {
            switch ($action) {
                case 'index':
                    $this->info($this->noteController->index()->getContent());
                    break;
    
                case 'show':
                    $id = $this->option('id');
                    if (empty($id)) {
                        $this->error('El ID es requerido para mostrar una nota.');
                        return;
                    }
                    $this->info($this->noteController->show($id)->getContent());
                    break;
    
                case 'create':
                    $data = $this->getNoteData();
                    if ($data === null) {
                        return; // Error ya mostrado en getNoteData
                    }
                    $request = new Request($data);
                    $this->info($this->noteController->create($request)->getContent());
                    break;
    
                case 'update':
                    $id = $this->option('id');
                    if (empty($id)) {
                        $this->error('El ID es requerido para actualizar una nota.');
                        return;
                    }

                    $note = $this->noteController->show($id)->getData()->note;
                   
                    if (!$note) {
                        $this->error('La nota con ID ' . $id . ' no existe.');
                        return;
                    }

                    $data = $this->getNoteData();
                    if ($data === null) {
                        return; // Error ya mostrado en getNoteData
                    }
                    $request = new Request($data);
                    $this->info($this->noteController->update($request, $id)->getContent());
                    break;
    
                case 'destroy':
                    $id = $this->option('id');
                    if (empty($id)) {
                        $this->error('El ID es requerido para eliminar una nota.');
                        return;
                    }
                    
                    $note = $this->noteController->show($id)->getData()->note;
                   
                    if (!$note) {
                        $this->error('La nota con ID ' . $id . ' no existe.');
                        return;
                    }

                    $this->info($this->noteController->destroy($id)->getContent());
                    
                    break;
    
                default:
                    $this->error('Acción no válida. Las acciones disponibles son: index, show, create, update, destroy.');
                    break;
            }
        } catch (\Exception $e) {
            $this->error('Se produjo un error: ' . $e->getMessage());
        }
    }
    
    private function getNoteData()
    {
        $title = $this->option('title');
        $description = $this->option('description');
        $due_date = $this->option('due_date');
        $user_id = $this->option('user');
        $tags = $this->option('tags');
        $image = $this->option('image');
    
        // Validaciones
        if (empty($title) || empty($description) || empty($due_date) || empty($user_id) || empty($tags) || empty($image)) {
            $this->error('Todos los campos son obligatorios: title, description, due_date, user, tags, image.');
            return null;
        }

        $user = User::find($user_id);
        if (!$user) {
            $this->error('El usuario con ID ' . $user_id . ' no existe.');
            return null;
        }
    
        return [
            'title' => $title,
            'description' => $description,
            'creation_date' => now(),
            'due_date' => $due_date,
            'user_id' => $user_id,
            'tags' => $tags,
            'image' => $image,
        ];
    }
    
}