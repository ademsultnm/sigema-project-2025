<?php

namespace App\Http\Controllers;

use App\Models\TagihanSpp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DokuCheckoutService;

class CheckoutController extends Controller
{
    public function create(DokuCheckoutService $doku, TagihanSpp $tagihan)
{
    $siswa = $tagihan->siswa;
    $user  = $siswa->user; 

    $orderId = "SPP-" . $tagihan->id . "-" . time();
    $amount  = (int) $tagihan->jumlah_tagihan;

    $customer = [
        "name"  => $siswa->nama,
        "email" => $user->email,
        "phone" => "081234567890", 
    ];

    // cek payloadnya
    $payload = $doku->createCheckout($orderId, $amount, $customer);

    if (!isset($payload['response']['payment']['url'])) {
        // API gagal → jangan redirect → tampilkan error
        return back()->with('error', 'Gagal membuat checkout DOKU.');
    }

    // =============== SIMPAN DATA PEMBAYARAN ===============
    $tagihan->invoice_number = $orderId;      // ← simpan invoice
    $tagihan->payment_status = 'pending';     // ← pending sebelum bayar
    $tagihan->external_id    = $payload['response']['order']['invoice_number'] ?? null;
    $tagihan->payment_channel = 'doku';
    $tagihan->save();
    // dd($payload);

    return redirect($payload['response']['payment']['url']);
}


}
