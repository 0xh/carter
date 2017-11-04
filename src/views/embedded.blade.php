@extends('launch::master')

@section('head')
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <script>
        ShopifyApp.init({
            apiKey: "{{ config('launch.client_id') }}",
            shopOrigin: "{{ ($user = auth()->user()) ? "https://{$user->shopify_domain}" : '' }}",
            debug: {{ app()->environment('production') ? 'false' : 'true' }},
        });
    </script>
@stop

@section('body')
    @yield('content')

    @yield('script')
@stop