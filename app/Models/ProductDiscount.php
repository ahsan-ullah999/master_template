<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $fillable = [
        'min_count',
        'max_count',
        'min_subtotal',     // optional min subtotal threshold
        'discount_amount',  // for fixed amount OR percent value depending on discount_type
        'discount_type',    // 'fixed' or 'percent'
        'active'
    ];

    /**
     * Find the best matching active rule for a given quantity and subtotal.
     * Returns the ProductDiscount model or null.
     */
    public static function matchingRule(int $count, float $subtotal)
    {
        return self::where('active', true)
            ->where('min_count', '<=', $count)
            ->where(function ($q) use ($count) {
                $q->whereNull('max_count')->orWhere('max_count', '>=', $count);
            })
            ->where(function ($q) use ($subtotal) {
                $q->whereNull('min_subtotal')->orWhere('min_subtotal', '<=', $subtotal);
            })
            ->orderByDesc('min_count')
            ->first();
    }

    /**
     * Given a matching rule and subtotal, compute the discount amount (absolute currency).
     * Returns 0 if no rule.
     */
    public static function discountAmountFor(int $count, float $subtotal): float
    {
        $rule = self::matchingRule($count, $subtotal);
        if (!$rule) {
            return 0.0;
        }

        if ($rule->discount_type === 'percent') {
            return round($subtotal * ($rule->discount_amount / 100.0), 2);
        }

        // fixed
        return round((float) $rule->discount_amount, 2);
    }
}
