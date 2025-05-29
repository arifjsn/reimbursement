@extends('templates.main')

@section('title')
Logs
@endsection

@section('body')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <form>
                    <div class="row">
                        <div class="col-auto" style="width: 150px;">
                            <input class="form-control form-control-sm" name="tgl_awal" value="{{ request()->tgl_awal }}" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Tgl Awal">
                        </div>
                        <div class="col-auto" style="width: 150px;">
                            <input class="form-control form-control-sm" name="tgl_akhir" value="{{ request()->tgl_akhir }}" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Tgl Akhir">
                        </div>
                        <div class="card-tools">
                            <div class="input-group col-auto">
                                <input type="text" name="pencarian" class="form-control form-control-sm float-right" value="{{ request()->pencarian }}" placeholder="Pencarian">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default btn-sm">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p class="card-title">
                        @if (request()->pencarian)
                        Menampilkan hasil pencarian "{{ request()->pencarian }}"
                        @endif

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
                    </p>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->deskripsi }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end m-3">
                    {{ $logs->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection