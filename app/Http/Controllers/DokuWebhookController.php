<?php

namespace App\Http\Controllers;

use App\Models\TagihanSpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DokuWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Simpan log callback untuk debugging
        Log::info('DOKU CALLBACK: ', $request->all());

        // Ambil data callback
        $orderId = $request->order['invoice_number'] ?? null;
        $status  = $request->transaction['status'] ?? null;

        if (!$orderId || !$status) {
            return response()->json(['error' => 'invalid payload'], 400);
        }

        // Cari tagihan berdasarkan invoice_number
        $tagihan = TagihanSpp::where('invoice_number', $orderId)->first();

        if (!$tagihan) {
            Log::warning("TAGIHAN NOT FOUND UNTUK ORDER: $orderId");
            return response()->json(['error' => 'tagihan not found'], 404);
        }

        // Simpan raw callback
        $tagihan->raw_callback = $request->all();

        // Update status pembayaran
        if ($status === "SUCCESS") {
            $tagihan->payment_status = "paid";
            $tagihan->status = "Lunas";
            $tagihan->payment_date = now();
        } 
        else if ($status === "FAILED") {
            $tagihan->payment_status = "failed";
        } 
        else {
            $tagihan->payment_status = strtolower($status);
        }

        $tagihan->save();

        return response()->json(['message' => 'ok']);
    }
}
