<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\tbllivros;

class TbllivrosController extends Controller
{
    // Mostrar todos os registros da tabela livros
    public function index(){
        $regBooks = tbllivros::all();
        $count = $regBooks->count();

        return response()->json([
            'message' => 'Livros encontrados',
            'count' => $count,
            'data' => $regBooks
        ], Response::HTTP_OK);
    }

    // Mostrar um tipo de registro específico
    public function show(string $id){
        $regBook = tbllivros::find($id);

        if($regBook) {
            return response()->json([
                'message' => 'Livro encontrado',
                'data' => $regBook
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Livro não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    // Cadastrar registros
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nomeLivro' => 'required',
            'generoLivro' => 'required',
            'anoLivro' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $regBook = tbllivros::create($request->all());

        return response()->json([
            'message' => 'Livro cadastrado com sucesso',
            'data' => $regBook
        ], Response::HTTP_CREATED);
    }

    // Alterar registros
    public function update(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'nomeLivro' => 'required',
            'generoLivro' => 'required',
            'anoLivro' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $regBook = tbllivros::find($id);

        if (!$regBook) {
            return response()->json([
                'message' => 'Livro não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $regBook->update($request->all());

        return response()->json([
            'message' => 'Livro atualizado com sucesso',
            'data' => $regBook
        ], Response::HTTP_OK);
    }

    // Deletar os registros
    public function destroy(string $id){
        $regBook = tbllivros::find($id);

        if (!$regBook) {
            return response()->json([
                'message' => 'Livro não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $regBook->delete();

        return response()->json([
            'message' => 'Livro deletado com sucesso'
        ], Response::HTTP_NO_CONTENT);
    }
}
