<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ClaimGaransiRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nomor_garansi' => ['required', 'string'],
            'nama' => ['required', 'string'],
            'nomor_hp' => ['required', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'email' => ['required', 'string', 'email'],
            'alamat_penerima' => ['required', 'string'],
            'provinsi' => ['required', 'string'],
            'kota' => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'kelurahan' => ['required', 'string'],
            'rt_rw' => ['required', 'string'],
            'kode_pos' => ['required', 'numeric', 'regex:/^[0-9]{5}$/'],
            'brand' => ['required', 'string'],
            'foto_tipe_barang' => ['required', 'file', 'image', 'max:10240'],
            'foto_stiker' => ['required', 'file', 'image', 'max:10240'],
            'alasan_kerusakan' => ['required', 'string'],
            'foto_kerusakan' => ['required', 'file', 'image', 'max:10240'],
            'foto_struk_pembelian' => ['required', 'file', 'image', 'max:10240'],
            'no_invoice' => ['required', 'string'],
            'model_barang' => ['required', 'string'],
            'jenis_barang' => ['required', 'string'],
            'tanggal_pembelian' => ['required', 'date', 'date_format:Y-m-d'],
            'metode_pembelian' => ['required', 'string', Rule::in(['Online', 'Offline'])],
            'nama_toko' => ['required', 'string'],
            'keterangan_tambahan' => ['nullable', 'string'],
            'qr_code' => ['nullable', 'string'],
        ];
    }

    /**
     * Attributes
     */
    public function attributes(): array
    {
        return [
            'nomor_garansi' => 'Nomor Garansi',
            'nama' => 'Nama',
            'nomor_hp' => 'Nomor HP',
            'email' => 'Email',
            'alamat_penerima' => 'Alamat Penerima',
            'provinsi' => 'Provinsi',
            'kota' => 'Kota',
            'kecamatan' => 'Kecamatan',
            'kelurahan' => 'Kelurahan',
            'rt_rw' => 'RT/RW',
            'kode_pos' => 'Kode Pos',
            'brand' => 'Brand',
            'foto_tipe_barang' => 'Foto Tipe Barang',
            'foto_stiker' => 'Foto Stiker Box',
            'alasan_kerusakan' => 'Alasan Kerusakan',
            'foto_kerusakan' => 'Foto Kerusakan',
            'provinsi' => 'Provinsi',
            'kota' => 'Kota',
            'kecamatan' => 'Kecamatan',
            'kelurahan' => 'Kelurahan',
            'rt_rw' => 'RT/RW',
            'kode_pos' => 'Kode Pos',
            'foto_struk_pembelian' => 'Struk Pembelian',
            'no_invoice' => 'Nomor Invoice',
            'model_barang' => 'Model Barang',
            'jenis_barang' => 'Jenis Barang',
            'serial_number' => 'Serial Number',
            'tanggal_pembelian' => 'Tanggal Pembelian',
            'metode_pembelian' => 'Metode Pembelian',
            'nama_toko' => 'Nama Toko',
            'keterangan_tambahan' => 'Keterangan Tambahan',
            'qr_code' => 'QR Code',
        ];
    }
}
