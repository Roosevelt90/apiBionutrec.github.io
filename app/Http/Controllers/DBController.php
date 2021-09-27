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
use App\BaseDeDatos;
use App\FieldsProjectXBD;
use App\FieldsProject;
use Illuminate\Database\Connection;
use DB;
use phpDocumentor\Reflection\Project;

class DBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user()->id_rol);
        //$survey = Projects::join('user_survey', 'survey.id', '=', 'user_survey.id_survey')->where('user_survey.id_user', auth()->user()->id)->get();        
        $projects = Projects::where('deleted_at', null)->get();
        $typeIdentification = TypeIdentification::all();
        return view('db.index', compact('projects', 'typeIdentification'));
    }

    public function saveDB(Request $request, $id)
    {
        $data = $request->all();
        ///dd($data['id_type_identification']);
        try {
            DB::beginTransaction();
            $contact = BaseDeDatos::where("id_type_identification", $data['id_type_identification'])
                ->where("number_identification", $data['number_identification'])
                ->where("id_project", $data['idProject'])
                ->get();
            //throw new \InvalidArgumentException("El contacto ingresado ya existe para este proyecto");
            if (count($contact) > 0) {
                //throw new \InvalidArgumentException("El contacto ingresado ya existe para este proyecto, con ese número de identificación.");
                throw new \InvalidArgumentException("Ya existe un contacto con el número de identificación ingresado.");
            }

            $contactTmp = FieldsProjectXBD::join("base_de_datos", "base_de_datos.id", "=", "fields_project_x_bd.id_base_de_datos")
                /*             ->where("id_type_identification", $data['id_type_identification'])
            ->where("number_identification", $data['number_identification']) */
                ->where("id_project", $data['idProject'])
                ->get();
            //dd($contactTmp);
            //->join("type_question", "type_question.id", "=", "fields_project.id_type")->where("id_project",$id)->get();

            $objDB = [
                'id_project' =>  $data['idProject'],
                'id_type_identification' => $data['id_type_identification'],
                'number_identification' => $data['number_identification'],
                'name' => $data['name'],
                'last_name' => $data['lastName'],
            ];
            $c = BaseDeDatos::create($objDB);
            $c->save();

            $fields = FieldsProject::where('id_project', $data['idProject'])->get();
            foreach ($fields as $key) {
                // var_dump($data[$key->name_id]);

                if (isset($data[$key->name_id])) {
                    //  dd($data[$key->name_id]);
                    $objAnswer = [
                        'id_base_de_datos' => $c->id,
                        'id_fields_project' => $key->id,
                        'answer' => (($key->id_type == 4) ? implode(',', $data[$key->name_id]) : $data[$key->name_id]),
                        'question' => $key->name
                    ];
                } else {
                    $objAnswer = [
                        'id_base_de_datos' => $c->id,
                        'id_fields_project' => $key->id,
                        'answer' => null,
                        'question' => $key->name
                    ];
                }
                $answer = FieldsProjectXBD::create($objAnswer);
                $answer->save();
            }

            DB::commit();
            return response()->json(["msg" => "OK"]);
        } catch (\InvalidArgumentException $exception) {
            DB::rollBack();
            return response()->json(["msg" => $exception->getMessage()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    function patient_char($str)
    {
        $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $newName = '';
        do {
            $str--;
            $limit = floor($str / 26);
            $reminder = $str % 26;
            $newName = $alpha[$reminder] . $newName;
            $str = $limit;
        } while ($str > 0);
        return $newName;
    }

    public function saveDBImport(Request $request)
    {
        $data = $request->all();
        ///dd($data['id_type_identification']);
        try {
            DB::beginTransaction();
            //   dd(json_decode($data['json']));
            $json = json_decode($data['json']);
            $sltFields = json_decode($data['sltFields']);

            //  dd($this->patient_char(26));

            $fields = FieldsProject::where('id_project', $data['idProjectImport'])->get();
            //dd($fields);
            /*    echo array_search("Nombre_principal",$fields);
            exit; */
            foreach ($json as $key) {
                //dd($fields);
                $objDB = [
                    'id_project' =>  $data['idProjectImport']
                ];
                $c = BaseDeDatos::create($objDB);
                $c->save();
                //foreach ($key as $item) {
                for ($i = 0; $i < count($key); $i++) {
                    $item = $key[$i];
                    foreach ($sltFields as $keySltFields) {
                        //dd($keySltFields, $item, $i, $this->patient_char($i + 1));
                        if ($this->patient_char($i + 1) == $keySltFields->value) {
                            $fieldFirst = FieldsProject::where('id_project', $data['idProjectImport'])->where('name_id', $keySltFields->nameId)->first();

                            $objAnswer = [
                                'id_base_de_datos' => $c->id,
                                'id_fields_project' => $fieldFirst->id,
                                'answer' => $item,
                                //'answer' => (($key->id_type == 4) ? implode(',', $data[$key->name_id]) : $data[$key->name_id]),
                                'question' => $fieldFirst->name
                            ];
                            $answer = FieldsProjectXBD::create($objAnswer);
                            $answer->save();
                            /*                             echo "<pre>";
                            var_dump($objAnswer);
             /*                var_dump($keySltFields);
                            var_dump($item);
                            var_dump($fieldFirst->id); */
                            //echo "</pre>"; 
                        }
                    }
                    //   exit;
                }
                // var_dump($data[$key->name_id]);

                /*        if (isset($data[$key->name_id])) {
                    //  dd($data[$key->name_id]);
                    $objAnswer = [
                        'id_base_de_datos' => $c->id,
                        'id_fields_project' => $key->id,
                        'answer' => (($key->id_type == 4) ? implode(',', $data[$key->name_id]) : $data[$key->name_id]),
                        'question' => $key->name
                    ];
                } else {
                    $objAnswer = [
                        'id_base_de_datos' => $c->id,
                        'id_fields_project' => $key->id,
                        'answer' => null,
                        'question' => $key->name
                    ];
                }
                 $answer = FieldsProjectXBD::create($objAnswer);
                $answer->save();   */
            }

            DB::commit();
            return response()->json(["msg" => "OK"]);
        } catch (\InvalidArgumentException $exception) {
            DB::rollBack();
            return response()->json(["msg" => $exception->getMessage()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function getdatadb($id)
    {
        $fields = FieldsProject::where('id_project', $id)->orderBy('id')->get();
        /*         $contact = BaseDeDatos::select('base_de_datos.*', 'type_identification.name AS nameTypeIdentification')
            ->join("type_identification", "type_identification.id", "=", "base_de_datos.id_type_identification")
            ->where('id_project', $id)->get()->toArray(); */

        $contact = BaseDeDatos::select('base_de_datos.*')
            ->where('id_project', $id)->get()->toArray();

        //dd($contact);
        for ($i = 0; $i < count($contact); $i++) {
            $key = $contact[$i];
            $answer = FieldsProjectXBD::select("fields_project_x_bd.*", "fields_project.name_id AS name_id")
                ->join("fields_project", "fields_project.id", "=", "fields_project_x_bd.id_fields_project")
                ->where('id_base_de_datos', $key['id'])->get();

            for ($j = 0; $j < count($answer); $j++) {
                $key2 = $answer[$j];
                $contact[$i][$key2['name_id']] = $key2['answer'];
            }
        }
        //dd($contact);
        return response()->json(['contact' => $contact, 'fields' => $fields]);
    }
}
