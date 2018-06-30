<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;

class PedidoController extends Controller {

    public function index()
    {
        return Pedido::with('producto', 'reserva', 'reserva.mesa', 'reserva.cliente')->get();
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'producto_id' => 'required',
            'reserva_id' => 'required',
        ]);
        

        $model = new Pedido();
        $model->producto_id = $request->input('producto_id');
        $model->reserva_id = $request->input('reserva_id');
        $model->save();
 
    	return response()->json($model);
    }

    public function show($id)
    {
        $model = Pedido::find($id);

        if($model == null) {
            return ['result' => $id . ' Not Found'];
        }
        return $model;
    }

    public function showPorReserva($id)
    {
        $model = Pedido::where('reserva_id', $id)->with('producto', 'reserva', 'reserva.mesa', 'reserva.cliente')->get();

        if($model == null) {
            return ['result' => $id . ' Not Found'];
        }
        return $model;
    }

    public function update($id)
    {
        return 'update';
    }

    public function destroy($id)
    {
        $model = Pedido::find($id);
        if($model == null) {
            return ['result' => $id . ' Not Found'];
        }
        return response()->json([
            'result' => $model->delete()
        ]);    
    }
}