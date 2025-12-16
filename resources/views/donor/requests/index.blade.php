@extends('layouts.donor')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">{{ __('donor.stat_req') }} (Pending)</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('donor.th_receiver') }}</th>
                        <th>{{ __('donor.th_req_food') }}</th>
                        <th>{{ __('donor.th_msg') }}</th>
                        <th>{{ __('donor.th_time') }}</th>
                        <th>{{ __('donor.th_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                    <tr>
                        <td>
                            <strong>{{ $claim->receiver->name }}</strong><br>
                            <small class="text-muted">{{ $claim->receiver->phone }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($claim->fooditems->photo)
                                    <img src="{{ asset($claim->fooditems->photo) }}" width="40" class="rounded me-2">
                                @endif
                                <span>{{ $claim->fooditems->name }}</span>
                            </div>
                        </td>
                        <td>{{ $claim->message ?? '-' }}</td>
                        <td>{{ $claim->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('donor.requests.approve', $claim->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success">✓ {{ __('donor.btn_accept') }}</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $claim->id }}">
                                ✗ {{ __('donor.btn_reject') }}
                            </button>
                            <div class="modal fade" id="rejectModal-{{ $claim->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('donor.requests.reject', $claim->id) }}" method="POST">
                                            @csrf 
                                            @method('PATCH')
                                            
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('donor.modal_rej_title') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>{!! __('donor.modal_rej_body', ['name' => $claim->receiver->name ?? 'User']) !!}</p>
                                                
                                                <div class="mb-3">
                                                    <label for="reason-select-{{ $claim->id }}" class="form-label">{{ __('donor.label_reason') }}</label>
                                                    
                                                    <select name="rejection_reason" id="reason-select-{{ $claim->id }}" class="form-select" required>
                                                        <option value="">{{ __('donor.reason_default') }}</option>
                                                        <option value="{{ __('donor.reason_1') }}">{{ __('donor.reason_1') }}</option>
                                                        <option value="{{ __('donor.reason_2') }}">{{ __('donor.reason_2') }}</option>
                                                        <option value="{{ __('donor.reason_3') }}">{{ __('donor.reason_3') }}</option>
                                                        <option value="{{ __('donor.reason_4') }}">{{ __('donor.reason_4') }}</option>
                                                        <option value="{{ __('donor.reason_5') }}">{{ __('donor.reason_5') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('donor.btn_cancel') }}</button>
                                                <button type="submit" class="btn btn-danger">{{ __('donor.btn_submit_reject') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">{{ __('donor.empty_req') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection