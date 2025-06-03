@extends('templates.main')

@section('title')
Detail Claim Garansi
@endsection

@section('body')

<div class="row">

    <div class="container-fluid mb-3">
        @if (session('error'))
        <span class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </span>
        @endif

        @if (session('success'))
        <span class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </span>
        @endif
    </div>

    <div class="col-12">
        <div class="card card-primary">
            <div class="card-body">
                <p class="card-text">
                <table>
                    <tr>
                        <td>
                            <h5><b>Nama &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->nama }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>No Hp &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->nomor_hp }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Email &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->email }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Alamat &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->alamat_penerima }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Nomor Garansi &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->nomor_garansi }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Brand &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->brand }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Alasan Kerusakan &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->alasan_kerusakan }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Foto Tipe Barang &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : <a href="{{ asset($claimGaransi->foto_tipe_barang) }}" data-toggle="lightbox" data-title="Foto Tipe Barang">
                                    <img src="{{ asset($claimGaransi->foto_tipe_barang) }}" alt="Foto Tipe Barang" width="200px">
                                </a>
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Foto Stiker &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : <a href="{{ asset($claimGaransi->foto_stiker) }}" data-toggle="lightbox" data-title="Foto Stiker"><img src="{{ asset($claimGaransi->foto_stiker) }}" alt="Foto Stiker" width="200px">
                                </a>
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Foto Kerusakan &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : <a href="{{ asset($claimGaransi->foto_kerusakan) }}" data-toggle="lightbox" data-title="Foto Kerusakan">
                                    <img src="{{ asset($claimGaransi->foto_kerusakan) }}" alt="Foto Kerusakan" width="200px">
                                </a>
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Foto Struk Pembelian &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : <a href="{{ asset($claimGaransi->foto_struk_pembelian) }}" data-toggle="lightbox" data-title="Foto Struk Pembelian">
                                    <img src="{{ asset($claimGaransi->foto_struk_pembelian) }}" alt="struk pembelian" width="200px">
                                </a>
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Nomor Invoice &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->no_invoice }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Model Barang &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->model_barang }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Jenis Barang &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->jenis_barang }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Tanggal Pembelian &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->tanggal_pembelian }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Metode Pembelian &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->metode_pembelian }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Nama Toko &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->nama_toko }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Keterangan Tambahan &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->keterangan_tambahan }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>QR Code &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->qr_code }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><b>Status &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> : {{ $claimGaransi->status }}</h5>
                        </td>
                    </tr>
                    @if ($claimGaransi->status === 'APPROVED')
                    <tr>
                        <td>
                            <h5><b>Proses &nbsp;</b></h5>
                        </td>
                        <td>
                            <h5> :
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-proses">
                                    {{ $claimGaransi->progress }} <i class="nav-icon fa fa-pencil-square"></i>
                                    <div></div>
                                </button>
                            </h5>
                        </td>
                    </tr>
                    @endif
                </table>
                @if ($claimGaransi->status === 'PENDING')
                <a href="{{ route('admin.claim-garansi.tolak', $claimGaransi->id) }}" class="btn btn-danger">Reject</a>
                <a href="{{ route('admin.claim-garansi.terima', $claimGaransi->id) }}" class="btn btn-primary">Approve</a>
                @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-proses" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Proses</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('admin.claim-garansi.progress', $claimGaransi->id) }}">
                <div class="modal-body">
                    <select name="progress" id="progress" class="form-control form-control-sm">
                        <option value="{{ $claimGaransi->progress }}">Saat ini : <b>{{ $claimGaransi->progress }}</b></option>
                        <option value="PENGECEKAN UNIT">PENGECEKAN UNIT</option>
                        <option value="PERGANTIAN UNIT">PERGANTIAN UNIT</option>
                        <option value="PENGIRIMAN UNIT">PENGIRIMAN UNIT</option>
                    </select>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

</div>

</div>

@endsection