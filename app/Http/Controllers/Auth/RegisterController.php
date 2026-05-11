<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WaliMurid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showDataForm()
    {
        if (!Session::has('verified_phone')) {
            return redirect()->route('register')->with('error', 'Silakan verifikasi nomor WhatsApp terlebih dahulu.');
        }

        return view('auth.register_data', [
            'phone' => Session::get('verified_phone'),
        ]);
    }

    public function storeData(Request $request)
    {
        if (!Session::has('verified_phone')) {
            return redirect()->route('register')->with('error', 'Silakan verifikasi nomor WhatsApp terlebih dahulu.');
        }

        $request->validate([
            'nik'         => 'required|string|max:20|unique:wali_murids,nik',
            'nama'        => 'required|string|max:255',
            'phone'       => 'required|string|min:10|unique:wali_murids,phone',
            'alamat'      => 'required|string|max:500',
            'provinsi'    => 'required|string|max:100',
            'kabupaten'   => 'required|string|max:100',
            'kecamatan'   => 'required|string|max:100',
            'kelurahan'   => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:50',
            'pendidikan'    => 'required|string|max:100',
            'pekerjaan'     => 'required|string|max:100',
        ]);

        WaliMurid::create($request->all());
        Session::forget('verified_phone');

        return redirect()->route('login')->with('success', 'Data wali murid berhasil disimpan. Silakan login.');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10',
        ]);

        // Jika nomor sudah ada di database
        if (WaliMurid::where('phone', $request->phone)->exists()) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Nomor Anda sudah terdaftar.'
            ]);
        }

        $phone = $request->phone;
        $otp = rand(100000, 999999); // Generate OTP 6 digit

        // Simpan OTP di session sementara
        Session::put('otp_code', $otp);
        Session::put('phone', $phone);

        // API WhatsApp
        $appkey = 'd17dbcf2-a137-45af-a033-24a942246016';
        $authkey = 'tqecqRgWa7UJ0uM5pjTqFkUuAOzlMGE2U1EKLvL9cbcQiu2UNY';
        $sender = '6285959880656'; // Ganti dengan nomor sender
        $receiver = $phone;
        $message = "Kode OTP Anda: $otp. Jangan berikan kode ini kepada siapapun.";

        $url = "http://wa.mpdev.my.id/api/create-message";

        try {
            $response = Http::get($url, [
                'appkey'   => $appkey,
                'authkey'  => $authkey,
                'to'       => $receiver,
                'message'  => $message,
            ]);

            if ($response->successful()) {
                return response()->json([
                    'message' => 'OTP berhasil dikirim ke WhatsApp Anda',
                    'status'  => true
                ]);
            } else {
                return response()->json([
                    'message' => 'Gagal mengirim OTP. Server WhatsApp tidak merespons sukses.',
                    'status'  => false
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengirim OTP. Silakan coba lagi.',
                'error'   => $e->getMessage(),
                'status'  => false
            ]);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10',
            'otp_code' => 'required|numeric',
        ]);

        $storedOTP = Session::get('otp_code');
        $storedPhone = Session::get('phone');

        if (!$storedOTP || $storedPhone !== $request->phone || $storedOTP != $request->otp_code) {
            return response()->json([
                'message' => 'OTP salah atau kadaluarsa',
                'status'  => false
            ]);
        }

        // Simpan nomor yang berhasil diverifikasi
        Session::put('verified_phone', $storedPhone);

        // Hapus OTP dari sesi setelah verifikasi sukses
        Session::forget('otp_code');
        Session::forget('phone');

        return response()->json([
            'message'  => 'Verifikasi berhasil! Lanjut ke input data.',
            'redirect' => url('/register/data'),
            'status'   => true,
        ]);
    }
}
