<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reserva;
use App\Mesa;
use App\Cliente;

class ReservaController extends Controller {

    public function index(Request $request)
    {
        $q = $request->input('q');
        if($q) {
            
            $result = Reserva::whereHas('cliente', function ($query) use ($q){
                $query->where('nombre', 'like', '%'.$q.'%')
                ->orWhere('rut', 'like', '%'.$q.'%');
            })->orderBy('create_at')
            ->with(['cliente' => function($query) use ($q){
                $query->where('nombre', 'like', '%'.$q.'%')
                ->orWhere('rut', 'like', '%'.$q.'%');
            }])->get();

            return $result;
        }

        return Reserva::with('mesa', 'cliente')->get();
    }

    public function store(Request $request)
    {

        $mesa_id = $request->input('mesa_id');
        $cliente_id = $request->input('cliente_id');
        
        $this->validate($request, [
            'mesa_id' => 'required',
            'cliente_id' => 'required',
        ]);

        
        if(Mesa::find($mesa_id) == null || Cliente::find($cliente_id) == null) {
            return ['result' => 'Cliente or Mesa Not Found'];
        }

        $model = new Reserva();
        $model->mesa_id = $mesa_id;
        $model->cliente_id = $cliente_id;
        $model->save();
 
    	return response()->json($model);
    }

    public function show($id)
    {
        $model = Reserva::with('mesa', 'cliente')->find($id);

        if($model == null) {
            return ['result' => $id . ' Not Found'];
        }

        $total = 0;
        foreach ($model->pedidos as $pedido) {
            $pedido->producto;
            $total += $pedido->producto->valor;
        }
        return [
            'model' => $model,
            'total' => $total,
        ];
    }

    public function update(Request $request, $id)
    {
        $mesa_id = $request->input('mesa_id');
        $cliente_id = $request->input('cliente_id');
        $estado_no_disponible = '0';
        $estado_disponible = '1';

        $this->validate($request, [
            'mesa_id' => 'required',
            'cliente_id' => 'required',
        ]);

        $mesa = Mesa::find($mesa_id);
        if($mesa == null || Cliente::find($cliente_id) == null) {
            return ['result' => 'Cliente or Mesa Not Found'];
        }

        if($mesa->estado == $estado_no_disponible) {
            return ['result' => 'Mesa no esta disponible'];
        }

        $reserva = Reserva::where('id', '=', $id)->first();
        $mesa_antigua = Mesa::find($reserva->mesa_id);

        $mesa_antigua->estado = $estado_disponible;
        $mesa_antigua->update();

        $mesa->estado = $estado_no_disponible;
        $mesa->update();

        return [
            'result' => $reserva->update($request->all()),
        ];
    }

    public function destroy($id)
    {
        $model = Reserva::find($id);
        if($model == null) {
            return ['result' => $id . ' Not Found'];
        }
        return response()->json([
            'result' => $model->delete()
        ]);    
    }

}