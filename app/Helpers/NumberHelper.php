<?php

if (!function_exists('formatNumber')) {
    /**
     * Formatear números con separador de miles usando punto
     * 
     * @param int|float|string $number
     * @return string
     */
    function formatNumber($number)
    {
        if (is_null($number) || $number === '') {
            return '0';
        }
        
        return number_format((float) $number, 0, ',', '.');
    }
}

if (!function_exists('formatCuit')) {
    /**
     * Formatear CUIT sin separadores de miles
     * 
     * @param string $cuit
     * @return string
     */
    function formatCuit($cuit)
    {
        return (string) $cuit;
    }
}
