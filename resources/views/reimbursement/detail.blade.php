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
                            <span
                                class="badge badge-{{ $reimbursement->status == 'requested' ? 'warning' : ($reimbursement->status == 'claimed' ? 'success' : 'danger') }}">
                                {{ ucfirst($reimbursement->status) }}
                            </span>
                        </p>
                        <p>Created at: {{ $reimbursement->created_at->format('d-m-Y H:i') }}</p>
                        <p>
                            Proof:
                            @if($reimbursement->proof)
                                <a href="{{ asset($reimbursement->proof) }}" data-toggle="lightbox" data-title="Proof"
                                    class="btn btn-sm btn-info">View Proof</a>
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
                                    @forelse($reimbursement->details as $detail)
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
                            </table>
                        </div>
                        <a href="{{ route('reimbursement.index') }}" class="btn btn-secondary mt-2">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection