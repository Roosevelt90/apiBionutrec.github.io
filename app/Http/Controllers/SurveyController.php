<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\Survey;
use App\User;
use App\TypeQuestion;
use App\Question;
use App\UserSurvey;
use App\TypeIdentification;
use App\Contact;
use App\Result;
use App\Answer;
use Illuminate\Database\Connection;
use DB;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user()->id_rol);
        if (auth()->user()->id_rol == 1) {
            $survey = Survey::all();
        } else {
            $survey = Survey::join('user_survey', 'survey.id', '=', 'user_survey.id_survey')->where('user_survey.id_user', auth()->user()->id)->get();
        }
        //dd(auth()->user()->id);
        return view('survey.index', compact('survey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Projects::where('deleted_at', null)->get();
        $users = User::where('active', 1)->get();
        $typeQuestion = TypeQuestion::all();
        return view('survey.create', compact('projects', 'users', 'typeQuestion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
           // dd($data);
            $arrCampos = json_decode($data['str_campos']);
            $arrAsesores = json_decode($data['str_asesores']);

            $dateBegin = new \DateTime($data['date_begin']);
            $dateEnd = new \DateTime($data['date_end']);
            $obj = [
                'name' => $data['name'],
                'id_user' => auth()->id(),
                'id_project' => $data['idProject'],
                'date_begin' => $dateBegin,
                'date_end' => $dateEnd
            ];
            $survey = Survey::create($obj);
            $survey->save();

            for ($i = 0; $i < count($arrAsesores); $i++) {
                $item = $arrAsesores[$i];
                $objAsesor = [
                    'id_user' => $item->id,
                    'id_survey' => $survey->id
                ];
                $userSurvey = UserSurvey::create($objAsesor);
                $userSurvey->save();
            }

            for ($i = 0; $i < count($arrCampos); $i++) {
                $item = $arrCampos[$i];
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
                $objCampos = [
                    'id_survey' => $survey->id,
                    'id_type' => $item->typeField,
                    'name' => $item->name,
                    'name_id' => $strName,
                    'values' => $valuesF,
                    //'values' => $item->valuesField,
                    'required' => ((isset($item->requerido) && ($item->requerido == 'on' || $item->requerido == '1')) ? 1 : 0),
                    //  'header' => ((isset($item->header) && $item->header == 'on') ? 1 : 0)
                ];
                $c = Question::create($objCampos);
                $c->save();
            }

            DB::commit();
            return redirect()->route('encuesta.index')->with('success', 'Registro creado satisfactoriamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
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
        $projects = Projects::where('deleted_at', null)->get();
        $users = User::where('active', 1)->get();
        $typeQuestion = TypeQuestion::all();

        $survey = Survey::find($id);
        $fields = Question::where('id_survey', $id)->get();

        $usersSurvey = UserSurvey::join('users', 'users.id', '=', 'user_survey.id_user')->where('user_survey.id_survey', $id)->get();
        $arr =  [];
        foreach ($usersSurvey as $key) {
            $arr[] = [
                "id" => $key->id_user,
                "name" => $key->name,
                "last_name" => $key->last_name,
                "email" => $key->email
            ];
        }
        $usersSurvey = json_encode($arr);
        $arr =  [];

        foreach ($fields as $key) {
            $arr[] = [
                "name" => $this->str_replace($key->name),
                "typeField" => $key->id_type,
                "valuesField" => $key->values,
                "id" => $key->id,
                "requerido" => $key->required,
                "txtTypeField" => TypeQuestion::select('name')->where('id', $key->id_type)->first()->name
            ];
        }
        $fieldsSurvey = json_encode($arr);
        return view('survey.edit', compact('projects', 'users', 'typeQuestion', 'survey', 'fields', 'usersSurvey', 'fieldsSurvey'));
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
        try {
            DB::beginTransaction();

            $data = $request->all();
            $arrAsesores = json_decode($data['str_asesores']);
            $arrCampos = json_decode($data['str_campos']);
            $dateBegin = new \DateTime($data['date_begin']);
            $dateEnd = new \DateTime($data['date_end']);

            $obj = [
                'name' => $data['name'],
                'id_project' => $data['idProject'],
                'date_begin' => $dateBegin,
                'date_end' => $dateEnd
            ];
            Survey::find($id)->update($obj);

            UserSurvey::where('id_survey', $id)->delete();

            for ($i = 0; $i < count($arrAsesores); $i++) {
                $item = $arrAsesores[$i];
                $objAsesor = [
                    'id_user' => $item->id,
                    'id_survey' => $id
                ];
                $userSurvey = UserSurvey::create($objAsesor);
                $userSurvey->save();
            }

            for ($i = 0; $i < count($arrCampos); $i++) {
                $item = $arrCampos[$i];
                $strName = str_replace(' ', '_', $this->str_replace($item->name));
                $objCampos = [
                    'id_survey' => $id,
                    'id_type' => $item->typeField,
                    'name' => $item->name,
                    'name_id' => $strName,
                    'values' => $item->valuesField,
                    'required' => ((isset($item->requerido) && ($item->requerido == 'on' || $item->requerido == '1')) ? 1 : 0),
                    //'header' => ((isset($item->header) && $item->header == 'on') ? 1 : 0)
                ];
                if (isset($item->id)) {
                    Question::find($item->id)->update($objCampos);
                } else {
                    $c = Question::create($objCampos);
                    $c->save();
                }
            }
            DB::commit();
            return redirect()->route('encuesta.index')->with('success', 'Registro editado satisfactoriamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            UserSurvey::where('id_survey', $id)->delete();
            Question::where('id_survey', $id)->delete();
            Survey::find($id)->delete();
            DB::commit();
            return redirect()->route('encuesta.index')->with('success', 'Registro eliminado satisfactoriamente');
        } catch (\Exception $e) {
            //    dd($e->getMessage());
            DB::rollBack();
        }
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

    public function survey($idHash)
    {
        //$encrypted_data = base64_decode($valor);
        // $id = openssl_decrypt($idHash, 'aes-256-cbc', $_ENV['KEY_PASS_SURVEY'], false, base64_decode("C9fBxl1EWtYTL1/M8jfstw=="));
        $id = '';
        $idHash2 = base64_decode($idHash);
        for ($i = 0; $i < strlen($idHash2); $i++) {
            $char = substr($idHash2, $i, 1);
            $keychar = substr($_ENV['KEY_PASS_SURVEY'], ($i % strlen($_ENV['KEY_PASS_SURVEY'])) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $id .= $char;
        }
        $survey = Survey::find($id);
        $fields = Question::where('id_survey', $id)->get();
        //dd($fields);
        $typeIdentification = TypeIdentification::all();
        return view('survey.cliente', compact('survey', 'fields', 'typeIdentification', 'idHash'));
    }

    public function surveyClient(Request $request)
    {
        try {

            DB::beginTransaction();;
            $data = $request->all();
        //    dd($data);
      /*       dd($data);
            dd($request); */
            $idHash2 = base64_decode($data['idSurvey']);
            $idSurvey = '';
            for ($i = 0; $i < strlen($idHash2); $i++) {
                $char = substr($idHash2, $i, 1);
                $keychar = substr($_ENV['KEY_PASS_SURVEY'], ($i % strlen($_ENV['KEY_PASS_SURVEY'])) - 1, 1);
                $char = chr(ord($char) - ord($keychar));
                $idSurvey .= $char;
            }
            $fields = Question::where('id_survey', $idSurvey)->get();
            //dd($fields);
            $contact = Contact::where('id_type_identification', $data['id_type_identification'])->where('number_identification', $data['number_identification'])->first();
            if (!isset($contact)) {
                $obj = [
                    'name' => $data['name'],
                    'last_name' => $data['lastName'],
                    'id_type_identification' => $data['id_type_identification'],
                    'number_identification' => $data['number_identification']
                ];

                $contact = Contact::create($obj);
                $contact->save();
            }
            $objResult = [
                'id_user' => auth()->user()->id,
                'id_contact' => $contact->id,
                'id_survey' => $idSurvey
            ];

            $result = Result::create($objResult);
            $result->save();

            foreach ($fields as $key) {
                $justificacionString = null;
                if($key->id_type == 7){    
                    $justificacionString = $data[$key->name_id . '_text'];
                }
                if (isset($data[$key->name_id])) {
                  //  dd($data[$key->name_id]);
                    $objAnswer = [
                        'id_result' => $result->id,
                        'id_question' => $key->id,
                        'answer' => (($key->id_type == 4) ? implode(',', $data[$key->name_id]) : $data[$key->name_id]),
                        'question' => $key->name,
                        'justificacion' => $justificacionString
                    ];
                }else{
                    $objAnswer = [
                        'id_result' => $result->id,
                        'id_question' => $key->id,
                        'answer' => null,
                        'question' => $key->name,
                        'justificacion' => $justificacionString
                    ];
                }
                $answer = Answer::create($objAnswer);
                $answer->save(); 
            }
            DB::commit();
            return redirect()->route('survey', [$data['idSurvey']])->with('success', 'Encuesta realizada satisfactoriamente');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function getEstrategias(Request $request){
        dd($request->all());
      /* $pregunta =  Pregunta::with("categorias")->with("respuestas")->get();
      return \Response::json($pregunta); */
    }
}
