<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Payment;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $payments = Payment::all();

        if ($payments->isEmpty()) {
            $this->command->warn('No se encontraron payments. Se omite la creación de invoices.');
            return;
        }

        // Crear invoices para pagos existentes (uno por cada payment)
        foreach ($payments as $payment) {
            Invoice::factory()->create([
                'payment_id' => $payment->id,
            ]);
        }

        $this->command->info('Se han creado las invoices asociadas a los payments correctamente.');
    }
}