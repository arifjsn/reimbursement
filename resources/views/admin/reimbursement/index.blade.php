@extends('templates.main')

@section('title')
All Reimbursements
@endsection

@section('body')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header" style="background-color: maroon; color: #fff;">
                    <h3 class="card-title mb-0">All Reimbursements</h3>
                    <form method="GET" action="{{ route('admin.reimbursement.index') }}" class="form-inline float-right">
                        <div class="form-group mb-0 ml-3">
                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="">-- All Status --</option>
                                <option value="requested" {{ request('status') == 'requested' ? 'selected' : '' }}>Requested
                                </option>
                                <option value="claimed" {{ request('status') == 'claimed' ? 'selected' : '' }}>Claimed
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead style="background-color: maroon; color: #fff;">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Proof</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reimbursements as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
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
                                        Rp {{ number_format($item->details->sum('money'), 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.reimbursement.detail', $item->id) }}" class="btn btn-sm btn-primary" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if($item->status == 'requested')
                                            <button class="btn btn-sm btn-success" onclick="confirmAccept({{ $item->id }})" title="Accept">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="confirmReject({{ $item->id }})" title="Reject">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endif
                                        <form id="accept-form-{{ $item->id }}" action="{{ route('admin.reimbursement.accept', $item->id) }}" method="POST" style="display:none;">
                                            @csrf
                                        </form>
                                        <form id="reject-form-{{ $item->id }}" action="{{ route('admin.reimbursement.reject', $item->id) }}" method="POST" style="display:none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No reimbursement data found.</td>
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

@endsection

@push('scripts')
<script>
    function confirmAccept(id) {
        Swal.fire({
            title: 'Accept this reimbursement?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, Accept',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('accept-form-' + id).submit();
            }
        });
    }

    function confirmReject(id) {
        Swal.fire({
            title: 'Reject this reimbursement?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reject-form-' + id).submit();
            }
        });
    }
</script>
@endpush