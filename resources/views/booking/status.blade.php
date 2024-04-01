<?php
$auth_user = authSession();
?>
{{ Form::open(['route' => ['booking.destroy', $booking->id], 'method' => 'delete','data--submit'=>'booking'.$booking->id]) }}
<div class="d-flex justify-content-end align-items-center">
    @if(!$booking->trashed())
        @if($auth_user->can('booking delete') && !$booking->trashed())
            <a class="mr-3" href="{{ route('booking.destroy', $booking->id) }}" data--submit="booking{{$booking->id}}"
               data--confirmation='true'
               data--ajax="true"
               data-datatable="reload"
               data-title="{{ __('messages.delete_form_title',['form'=>  __('messages.booking') ]) }}"
               title="{{ __('messages.delete_form_title',['form'=>  __('messages.booking') ]) }}"
               data-message='{{ __("messages.delete_msg") }}'>
                <i class="far fa-trash-alt text-danger "></i>
            </a>
        @endif
    @endif
    @if(auth()->user()->hasAnyRole(['admin','handyman'])) {{-- Check if the user is not logged in --}}
        {{-- Add the editing option --}}
        <a class="mr-2" href="{{ route('booking.edit', $booking->id) }}" title="Edit Booking">
            <i class="fas fa-edit text-primary"></i>
        </a>
    @endif
    @if(auth()->user()->hasAnyRole(['admin']) && $booking->trashed())
        <a class="mr-2" href="{{ route('booking.action',['id' => $booking->id, 'type' => 'restore']) }}"
           title="{{ __('messages.restore_form_title',['form' => __('messages.booking') ]) }}"
           data--submit="confirm_form"
           data--confirmation='true'
           data--ajax='true'
           data-title="{{ __('messages.restore_form_title',['form'=>  __('messages.booking') ]) }}"
           data-message='{{ __("messages.restore_msg") }}'
           data-datatable="reload">
            <i class="fas fa-redo text-secondary"></i>
        </a>
        <a href="{{ route('booking.action',['id' => $booking->id, 'type' => 'forcedelete']) }}"
           title="{{ __('messages.forcedelete_form_title',['form' => __('messages.booking') ]) }}"
           data--submit="confirm_form"
           data--confirmation='true'
           data--ajax='true'
           data-title="{{ __('messages.forcedelete_form_title',['form'=>  __('messages.booking') ]) }}"
           data-message='{{ __("messages.forcedelete_msg") }}'
           data-datatable="reload"
           class="mr-2">
            <i class="far fa-trash-alt text-danger"></i>
        </a>
    @endif

    {{-- Payment Option --}}
    <a href="{{ route('payment.create', ['booking_id' => $booking->id]) }}" class="mr-2" title="Add Payment">
        <i class="fas fa-money-bill-wave text-success"></i>
    </a>

    {{-- Payment Status --}}
    @if(auth()->user()->hasAnyRole(['admin','handyman']))
        <div class="dropdown mr-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="paymentStatusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Payment Status
            </button>
            <div class="dropdown-menu" aria-labelledby="paymentStatusDropdown">
                <a class="dropdown-item" href="{{ route('booking.changePaymentStatus', ['id' => $booking->id, 'status' => 'paid']) }}">Paid</a>
                <a class="dropdown-item" href="{{ route('booking.changePaymentStatus', ['id' => $booking->id, 'status' => 'unpaid']) }}">Unpaid</a>
            </div>
        </div>
    @endif
</div>
{{ Form::close() }}
