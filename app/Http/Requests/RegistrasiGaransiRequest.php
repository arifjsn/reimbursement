<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrasiGaransiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string'],
            /**
             * Bagian pertama adalah untuk menentukan kode negara. Kode negara Indonesia adalah +62. Namun, nomor telepon Indonesia juga dapat dimulai dengan 62 atau 0.
             * Bagian kedua adalah untuk menentukan panjang dan pola nomor telepon. Nomor telepon Indonesia terdiri dari 10-13 digit angka, dengan digit pertama adalah 8.
             */
            'nomor_hp' => ['required', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'email' => ['required', 'string', 'email'],
            'tanggal_lahir' => ['required', 'date', 'date_format:Y-m-d'],
            'alamat' => ['required', 'string'],
            'provinsi' => ['required', 'string'],
            'kota' => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'kelurahan' => ['required', 'string'],
            'rt_rw' => ['required', 'string'],
            'kode_pos' => ['required', 'numeric', 'regex:/^[0-9]{5}$/'],
            'brand' => ['required', 'string'],
            'struk_pembelian' => ['required', 'file', 'image', 'max:' . (1024 * 5)],
            'no_invoice' => ['required', 'string'],
            'model_barang' => ['required', 'string'],
            'jenis_barang' => ['required', 'string'],
            'nomor_garansi' => ['required', 'string'],
            'tanggal_pembelian' => ['required', 'date', 'date_format:Y-m-d'],
            'metode_pembelian' => ['required', 'string', Rule::in(['Online', 'Offline'])],
            'nama_toko' => ['required', 'string'],
            'keterangan_tambahan' => ['nullable', 'string'],
            'qr_code' => ['nullable', 'string']
        ];
    }

    /**
     * Attributes
     */
    public function attributes(): array
    {
        return [
            'nama' => 'Nama',
            'nomor_hp' => 'Nomor HP',
            'email' => 'Email',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat',
            'provinsi' => 'Provinsi',
            'kota' => 'Kota',
            'kecamatan' => 'Kecamatan',
            'kelurahan' => 'Kelurahan',
            'rt_rw' => 'RT/RW',
            'kode_pos' => 'Kode Pos',
            'brand' => 'Brand',
            'struk_pembelian' => 'Struk Pembelian',
            'no_invoice' => 'Nomor Invoice',
            'model_barang' => 'Model Barang',
            'jenis_barang' => 'Jenis Barang',
            'nomor_garansi' => 'Nomor Garansi',
            'tanggal_pembelian' => 'Tanggal Pembelian',
            'metode_pembelian' => 'Metode Pembelian',
            'nama_toko' => 'Nama Toko',
            'keterangan_tambahan' => 'Keterangan Tambahan',
            'qr_code' => 'QR Code',
        ];
    }
}
