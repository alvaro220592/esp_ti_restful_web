<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['result' => $this->product->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validacao = validator($data, $this->product->rules());

        if ($validacao->fails()) {
            $mensagens = $validacao->messages();
            return response()->json(['Erro' => $mensagens]);
        }
        
        if (! $insert = $this->product->create($data))
            return response()->json(['Erro' => "Erro ao inserir os dados"], 500);
        
        return response()->json([
            'Mensagem' => "Dados inseridos com sucesso",
            'Dados' => $insert,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! $product = $this->product->find($id)){
            return response()->json(['Erro' => 'Produto não encontrado']);
        }else{
            return response()->json(['Produto' => $product]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = $this->product->find($id);

        if (! $produto){
            return response()->json(["Erro no update" => "Produto não encontrado"]);
        }

        $dados = $request->all();

        $validacao = validator($dados, $this->product->rules($id));
        if ($validacao->fails()){
            return response()->json(["Erro" => $validacao->messages()]);
        }

        if(! $update = $produto->update($dados)){
            return response()->json(['Erro' => "Erro ao alterar os dados"], 500);
        }else{
            return response()->json([
                'Mensagem' => "Dados alterados com sucesso",
                "Resultado" => $update
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(! $produto = $this->product::find($id)){
            return response()->json(['Erro' => "Produto não encontrado"]);
        }

        if(! $delete = $produto->delete()){
            return response()->json(['Erro' => 'Não foi possível excluir o registro'], 500);
        }else{
            return response()->json(['Mensagem' => "Produto excluído com sucesso", "Resultado" => $delete]);
        }
    }
}
