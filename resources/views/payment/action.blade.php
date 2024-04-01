<?php
$auth_user = authSession();
?>

{{-- Opening the form for updating payment status --}}
@if($auth_user->hasAnyRole(['admin', 'handyman']))
    <div class="d-flex justify-content-end align-items-center">
        @if($auth_user->hasAnyRole(['admin']))
            <a class="mr-3" href="{{ route('payment.destroy', $payment->id) }}" data--submit="payment{{$payment->id}}" 
                data--confirmation='true' 
                data--ajax="true"
                data-datatable="reload"
                data-title="{{ __('messages.delete_form_title',['form'=>  __('messages.payment') ]) }}"
                title="{{ __('messages.delete_form_title',['form'=>  __('messages.payment') ]) }}"
                data-message='{{ __("messages.delete_msg") }}'>
                <i class="far fa-trash-alt text-danger"></i>
            </a>
        @endif

        <div class="payment-status-form">
            {{ Form::open(['route' => ['payments.update_status', $payment->id], 'method' => 'PUT']) }}

            {{-- CSRF token --}}
            @csrf

            {{-- Select field for choosing status --}}
            <select name="status" class="form-control payment-status-select">
                <option value="paid" {{ $payment->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ $payment->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ $payment->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>

            {{-- Submit button --}}
            <button type="submit" class="btn btn-primary">Update Status</button>
            {{ Form::close() }}
        </div>
    </div>
@endif
