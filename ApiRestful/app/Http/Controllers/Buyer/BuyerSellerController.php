<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $this->allowedAdminAction();
        // Se utiliza Eager Loading por ser una relacion 1:N
        // $buyer->transactions->product no funciona ya que transactions se comvierte en una Coleccion
        $sellers = $buyer->transactions()->with('product.seller') // con el . le estamos diciendo que nos de los vendedores de cada producto
            ->get()
            ->pluck('product.seller')//seller no esta de manera directa con la coleccion inicial, por eso es product.seller
            ->unique('id')//el id es el factor para determinar que sean diferentes los resultados
            ->values();//elimina los indices vacios resultado del unique() y reorganiza los inidices en el orden correcto

        return $this->showAll($sellers);
    }
}
