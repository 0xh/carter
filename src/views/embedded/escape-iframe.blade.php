@extends('carter::embedded')

@section('script')
    <script>
        window.parent.postMessage(JSON.stringify({
            message: 'Shopify.API.remoteRedirect',
            data: { location: '{{ $redirect }}' }
        }), 'https://{{ auth()->user()->shopify_domain }}');
    </script>
@stop