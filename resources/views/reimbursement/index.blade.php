@extends('templates.main')

@section('title')
Reimbursement List
@endsection

@section('body')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: maroon; color: #fff;">
                    <h3 class="card-title mb-0">My Reimbursements</h3>
                    <a href="{{ route('reimbursement.create') }}" class="btn btn-primary" style="background-color: maroon; border-color: maroon;">
                        <i class="fa fa-plus"></i> Add Reimbursement
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead style="background-color: maroon; color: #fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Proof</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reimbursements as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->status == 'requested' ? 'warning' : ($item->status == 'claimed' ? 'success' : 'danger') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->proof)
                                        <a href="{{ asset('storage/'.$item->proof) }}" target="_blank" class="btn btn-sm btn-info">View</a>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('reimbursement.detail', $item->id) }}" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('reimbursement.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('reimbursement.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this reimbursement?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No reimbursement data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary,
    .btn-primary:active,
    .btn-primary:focus,
    .btn-primary:hover {
        background-color: maroon !important;
        border-color: maroon !important;
        color: #fff !important;
    }

    .table thead {
        background-color: maroon !important;
        color: #fff !important;
    }
</style>
@endsection