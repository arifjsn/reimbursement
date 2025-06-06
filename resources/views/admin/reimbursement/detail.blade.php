@extends('templates.main')

@section('title')
Reimbursement Detail
@endsection

@section('body')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card mt-4">
                <div class="card-header" style="background-color: maroon; color: #fff;">
                    <h3 class="card-title mb-0">Reimbursement Detail</h3>
                </div>
                <div class="card-body">
                    <h5>User: {{ $reimbursement->user->name ?? '-' }}</h5>
                    <p>Status:
                        <span class="badge badge-{{ $reimbursement->status == 'requested' ? 'warning' : ($reimbursement->status == 'claimed' ? 'success' : 'danger') }}">
                            {{ ucfirst($reimbursement->status) }}
                        </span>
                    </p>
                    <p>Created at: {{ $reimbursement->created_at->format('d-m-Y H:i') }}</p>
                    <p>
                        Proof:
                        @if($reimbursement->proof)
                        <a href="{{ asset('storage/'.$reimbursement->proof) }}" target="_blank" class="btn btn-sm btn-info">View Proof</a>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </p>
                    <hr>
                    <h5>Expense Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color: maroon; color: #fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @forelse($reimbursement->details as $detail)
                                @php $total += $detail->money; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($detail->date)->format('d-m-y') }}</td>
                                    <td>{{ $detail->description }}</td>
                                    <td>Rp {{ number_format($detail->money, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No expense details.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total</th>
                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <a href="{{ route('admin.reimbursement.index') }}" class="btn btn-secondary mt-2" style="display:inline-block;">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    @if($reimbursement->status == 'requested')
                        <form id="accept-form" action="{{ route('admin.reimbursement.accept', $reimbursement->id) }}" method="POST" style="display:inline-block; margin-left: 8px;">
                            @csrf
                            <button type="button" class="btn btn-success mt-2" onclick="confirmAccept()">
                                <i class="fa fa-check"></i> Accept
                            </button>
                        </form>
                        <form id="reject-form" action="{{ route('admin.reimbursement.reject', $reimbursement->id) }}" method="POST" style="display:inline-block; margin-left: 8px;">
                            @csrf
                            <button type="button" class="btn btn-danger mt-2" onclick="confirmReject()">
                                <i class="fa fa-times"></i> Reject
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmAccept() {
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
                document.getElementById('accept-form').submit();
            }
        });
    }

    function confirmReject() {
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
                document.getElementById('reject-form').submit();
            }
        });
    }
</script>
@endpush