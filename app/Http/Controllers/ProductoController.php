<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller {

    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:events',
            'date' => 'required',
            'capacity' => 'required',
        ]);
        

        $model = new Producto();
        $model->name = $request->input('name');
        $model->date = $request->input('date');
        $model->capacity = $request->input('capacity');
        $model->save();
 
    	return response()->json($model);
    }

    public function show($id)
    {
        return 'show';
    }

    public function update($id)
    {
        return 'update';
    }

    public function destroy($id)
    {
        $model = Producto::find($id);
        if($model == null) {
            return ['result' => $id . ' Not Found'];
        }
        return response()->json([
            'result' => $model->delete()
        ]);    
    }

}