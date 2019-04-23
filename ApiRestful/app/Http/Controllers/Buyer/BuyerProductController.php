<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
        $this->middleware('can:view,buyer')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // Se utiliza Eager Loading por ser una relacion 1:N
        // $buyer->transactions->product no funciona ya que transactions se comvierte en una Coleccion
        $products = $buyer->transactions()->with('product')// Se obtiene un Query Builder y por eso se puede usar el metodo with()
            ->get()
            ->pluck('product');// El metodo pluck() nos sirve para solo obtener un solo indice de la coleccion

        return $this->showAll($products);
    }
}
