<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;

class ProductObserver
{
    /**
     * Événement déclenché avant l'enregistrement d'un produit.
     *
     * @param Product $product
     * @return void
     */
    public function saving(Product $product)
    {
        // Vérifiez si le stock est inférieur à 10 et a changé
        if ($product->stock < 10 && $product->isDirty('stock')) {
            // Récupérer l'utilisateur admin (par exemple)
            $admin = User::where('user_role', 1)->first();
            if ($admin) {
                $admin->notify(new LowStockNotification($product));
            }
        }
    }
}
