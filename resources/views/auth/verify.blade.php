@extends('layouts.app')

@section('container')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sahkan Alamat E-Mel') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Sebelum teruskan,sila sahkan pautan dalam e-mel anda') }}
                    {{ __('Jika anda tidak menerima e-mel pengesahan') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik sini untuk mohon sekali lagi') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
