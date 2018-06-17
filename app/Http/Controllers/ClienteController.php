<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller {

    public function index()
    {
        return Cliente::all();
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:events',
            'date' => 'required',
            'capacity' => 'required',
        ]);
        

        $model = new Cliente();
        $model->name = $request->input('name');
        $model->date = $request->input('date');
        $model->capacity = $request->input('capacity');
        $model->save();
 
    	return response()->json($model);
    }

    public function show($id)
    {
        $model = Cliente::find($id);

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
        $model = Cliente::find($id);
        if($model == null) {
            return ['result' => $id . ' Not Found'];
        }
        return response()->json([
            'result' => $model->delete()
        ]);    
    }

}