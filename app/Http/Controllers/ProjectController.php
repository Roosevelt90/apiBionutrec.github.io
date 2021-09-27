<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\FieldsProject;
use stdClass;
use App\TypeQuestion;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Projects::all();
        $typeQuestion = TypeQuestion::all();
        return view('project.index', compact('projects', 'typeQuestion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $data = $request->all();
        $obj = [            
            'name' => $data['name'],
            'id_user' => auth()->id()
        ];

        Projects::create($obj);
        return redirect()->route('project.index')->with('success', 'Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $project = Projects::find($id);
        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[ 'name'=>'required']);
 
        Projects::find($id)->update($request->all());
        return redirect()->route('project.index')->with('success','Registro actualizado satisfactoriamente');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Projects::find($id)->delete();
        $project = Projects::find($id);
        $status = $project->deleted_at;
        $msg = '';
        if($status == null){
            $msg = 'Se desactivo el proyecto satisfactoriamente';
            $project->deleted_at = date("Y-m-d H:i:s");
        }else{
            $msg = 'Se activo el proyecto satisfactoriamente';
            $status = null;
            $project->deleted_at = null;
        }

        $project->save();
        return redirect()->route('project.index')->with('success', $msg);
    }

    public function savefield(Request $request)
    {
        $data = $request->all();
        $idProject = $data['idProject'];
        $arrCampos = json_decode($data['arrFields']);
    //    dd($arrCampos);

        for ($i = 0; $i < count($arrCampos); $i++) {
            $item = $arrCampos[$i];
            if(!isset($item->id)){
                $valuesF = '';
                if($item->typeField == 3 || $item->typeField == 4){
                    $arrV = json_decode($item->valuesField);
                    for ($j=0; $j < count($arrV); $j++) { 
                        $item2 = $arrV[$j];                        
                        $valuesF .= $item2->desc;
                        if($j < (count($arrV) - 1)){
                            $valuesF .= ',';
                        }
                    }
                }
    
                $strName = str_replace(' ', '_', $this->str_replace($item->name));
                $obj = [            
                    'id_project' => $idProject,
                    'id_type' => $item->typeField,
                    'name' => $item->name,
                    'name_id' => $strName,
                    'values' => $valuesF,
                    'validacion' => ((isset($item->validacion) && $item->validacion == 'on') ? 1 : 0)
                ];
                $c = FieldsProject::create($obj);
                $c->save();
            }          
        }
    }

    public function getField($id){
        $c = FieldsProject::select("fields_project.*", "type_question.name AS txtTypeField")->join("type_question", "type_question.id", "=", "fields_project.id_type")->where("id_project",$id)->get();
        return response()->json($c);
    }

    public function str_replace($cadena)
    {

        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
        );

        return $cadena;
    }
}
