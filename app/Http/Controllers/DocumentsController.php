<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

Use App\Models\Document;

class DocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     function index(){
        $documents = Document::all();
        return view('modules.documents.index', compact('documents'));
    }

    function editDocument($id){ 
        $document = Document::find($id);
        return view('modules.documents.edit', compact('document')); 
    }

    function updateDocument(Request $request, $id){
        try{
            $document = Document::find($id);
            $document->type = strtoupper($request->type);
            $document->save();
            return redirect()->route('documents')->with('PrimaryUpdateDocument', 'Registro: ' . strtoupper($request->type) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('documents')->with('SecondaryUpdateDocument', 'Error!!, No es posible actualizar el documento');
        }
    }

    function deleteDocument($id){
        try{
            $document = Document::find($id);
            $namedocument = $document->type;
            $document->delete();
            return redirect()->route('documents')->with('WarningDeleteDocument', 'Registro: ' . $namedocument . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('documents')->with('SecondaryDeleteDocument', 'Error!!, No es posible eliminar el documento');
        }
            
    }

    function newDocument(Request $request){
        try{
            $documentSave = Document::where('type',strtoupper($request->type))->first();
            if($documentSave == null){
                Document::create([
                    'type' => strtoupper($request->type),
                ]);
                return redirect()->route('documents')->with('SuccessSaveDocument', 'Registro: ' . strtoupper($request->type) . ', creado correctamente');
            }else{
                 return redirect()->route('documents')->with('SecondarySaveDocument', 'Ya existe un registro ' . strtoupper($request->type));
            }
            /* Document::firstOrCreate([
                    'type' => strtoupper($request->type),
                ],[
                    'type' => strtoupper($request->type),
                ]
            );
            return redirect()->route('documents')->with('SuccessSaveDocument', 'Registro: ' . strtoupper($request->type) . ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('documents')->with('SecondarySaveDocument', 'Error!!, No es posible crear el documento');
        }
            
    }
}
