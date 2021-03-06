<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function rules($id = ''){
        return [
            'name' => ['required', 'min:3', 'max:100', "unique:products,name,{$id},id"],
            'description' => ['required', 'min:5', 'max:1000'],
        ];
    }
    
    public function search($dados, $paginas){
        return $this->where('name', 'like', "%{$dados['busca']}%")
                    ->orWhere('description', 'like', "%{$dados['busca']}%")
                    ->paginate(5);
    }
}