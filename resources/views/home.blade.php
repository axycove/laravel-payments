@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Make a Payment') }}</div>

                    <div class="card-body">
                        <form action="{{ route('pay') }}" method="POST" id="paymentForm">
                            @csrf
                            <div class="row">
                                <div class="col-auto">
                                    <label class="control-label">How much do you want to pay?</label>
                                    <input type="number" min="5" step="0.01" class="form-control" name="value"
                                        value="{{ mt_rand(500, 100000) / 100 }}">
                                    <small class="form-text text-muted">
                                        Use values with up to two decimal positions, using a dot "."
                                    </small>
                                </div>
                                <div class="col-auto">
                                    <label class="control-label">Currency</label>
                                    <select class="form-select" name="currency" required>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->iso }}">
                                                {{ $currency->iso }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label>
                                        Select the desired payment platform
                                    </label>
                                    <div class="form-group" id="toggler">
                                        <div class="btn-group" data-bs-toggle="buttons">
                                            @foreach ($paymentPlatforms as $paymentPlatform)
                                                <label class="btn btn-outline-secondary rounded m-2 p-1"
                                                    data-bs-target="#{{ $paymentPlatform->name }}Collapse"
                                                    data-bs-toggle="collapse">
                                                    <input type="radio" name="payment_platform"
                                                        value="{{ $paymentPlatform->id }}" required>
                                                    <img class="img-thumbnail" src="{{ asset($paymentPlatform->image) }}">
                                                </label>
                                            @endforeach
                                        </div>
                                        @foreach ($paymentPlatforms as $paymentPlatform)
                                            <div id="{{ $paymentPlatform->name }}Collapse" class="collapse"
                                                data-bs-parent="#toggler">
                                                @includeIf ('components.' . strtolower($paymentPlatform->name) .
                                                '-collapse')
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-auto">
                                    <p class="border-bottom border-primary rounded">
                                        @if (!optional(auth()->user())->hasActiveSubscription())
                                            Would you like a discount every time?
                                            <a href="{{ route('subscribe.show') }}">Subscribe</a>
                                        @else
                                            You get <span class="font-weight-bold">10%</span> off as part of your
                                            subscription (this will be applied on checkout).
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary" id="payButton">Pay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
