<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = [
        'name', 'brand', 'model', 'category', 'description',
        'cost_price', 'sale_price', 'stock', 'stock_min',
        'sku', 'status', 'image',
    ];

    // Labels legíveis para as categorias
    public static function categories(): array
    {
        return [
            'mountain'  => 'Mountain Bike',
            'speed'     => 'Speed / Road',
            'urbana'    => 'Urbana / City',
            'infantil'  => 'Infantil',
            'eletrica'  => 'Elétrica',
            'bmx'       => 'BMX',
            'acessorio' => 'Acessório',
            'peca'      => 'Peça / Componente',
            'outro'     => 'Outro',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::categories()[$this->category] ?? $this->category;
    }

    // Margem de lucro em %
    public function getMarginAttribute(): float
    {
        if (!$this->cost_price || $this->cost_price == 0) return 0;
        return round((($this->sale_price - $this->cost_price) / $this->cost_price) * 100, 1);
    }

    // Estoque baixo?
    public function getLowStockAttribute(): bool
    {
        return $this->stock <= $this->stock_min;
    }
}