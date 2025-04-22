<?php

namespace Projetux\Math;

class Basic 
{
    /**
     * @return int|float
     */
    public function soma(int|float $numero, int|float $numero2)
    {
        return $numero + $numero2;
    }


   
    /**
     * @return int|float
     */
    public function subtrai(int|float $numero, int|float $numero2)
    {
        return $numero - $numero2;
    }


    /**
     * @return int|float
     */
    public function divide(int|float $numero, int|float $divisor)
    {
        return $numero / $divisor;
    }


    /**
     * @return int|float
     */
    public function raizQuadrada(int|float $numero, int|float $numero2)
    {
     return sqrt($numero);
     //return $numero ** (1/2)
    }


    /**
     * @return int|float
     */
    public function muiltiplica(int|float $numero, int|float $numero2)
    {
        return $numero * $numero2;
    }

    /**
     * @return int|float
     */
    public function elevadoAoQuadrado(int|float $numero, int|float $numero2)
    {
        return $numero ** $numero2;
    }


}
