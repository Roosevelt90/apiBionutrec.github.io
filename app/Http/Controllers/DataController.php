<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Bogota');

use Illuminate\Http\Request;
use App\Jugador;
use App\Score;
use App\Respuestas;
use App\Tema;
use App\TipoUsuario;
use App\Pregunta;
use Illuminate\Database\Connection;
use DB;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getJson()
    {
        $obj = new \stdClass;
        $obj->tipoUsuario =  TipoUsuario::all();
        $obj->tema =  Tema::all();
        $obj->respuestas =  Respuestas::all();
        $obj->jugador =  Jugador::all();

        return \Response::json($obj);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      //public function saveRanking(Request $request)
      public function saveRanking($nombre, $numero_identificacion, $score)
      {
          //$data = $request->all();
          $fechaActual = date('Y-m-d H:i:s');
  
          try {
              DB::beginTransaction();
              $idJugador = null;
              $jugador = Jugador::where('nombre', $nombre)->where('numero_identificacion', $numero_identificacion)->where('rol', 'jugador')->get();
              if (count($jugador) > 0) {
                  $idJugador = $jugador[0]->id;
              } else {
                  $objJugador = [
                      'nombre' =>  $nombre,
                      'numero_identificacion' => $numero_identificacion,
                      'rol' => 'jugador'
                  ];
                  $j = Jugador::create($objJugador);
                  $j->save();
                  $idJugador = $j->id;
              }
  
              $rspScore = Score::where('id_jugador', $idJugador)->first();
              //dd($rspScore);
              if ($rspScore != null) {
                  $rspScore->score +=  $score;
                  $rspScore->save();
              } else {
                  $objScore = [
                      'id_jugador' =>  $idJugador,
                      'score' => $score,
                      'fecha' => $fechaActual
                  ];
                  $s = Score::create($objScore);
                  $s->save();
              }
  
  
              DB::commit();;
              return response()->json(["msg" => "OK"]);
          } catch (\InvalidArgumentException $exception) {
              DB::rollBack();
              return response()->json(["msg" => $exception->getMessage()], 422);
          } catch (\Exception $e) {
              DB::rollBack();
              dd($e->getMessage());
          }
      }
  
      public function getRanking()
      {
          $fechaActual = date('Y-m-d H:i:s');
  
          $ranking = Score::select("jugador.*", "score.score")
              ->join("jugador", "jugador.id", "=", "score.id_jugador")->orderBy('score.score', 'DESC')->limit(10)->get();
          return \Response::json($ranking);
      }

      public function getPreguntas(){
        $pregunta =  Pregunta::with("categorias")->with("respuestas")->get();
        return \Response::json($pregunta);
      }

      public function getEstrategias(Request $request){
          dd($request->all());
        /* $pregunta =  Pregunta::with("categorias")->with("respuestas")->get();
        return \Response::json($pregunta); */
      }

}
