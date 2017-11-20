@extends('carter::embedded')

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Nunito:400|Open+Sans:300" rel="stylesheet">
    <style>
        body {
            font-size: 20px;
            height: 100vh;
            display: flex;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        div {
            margin-top: -8em;
        }

        h1 {
            background-clip: text;
            color: #dcddea;
            font-family: "Nunito";
            font-size: 6em;
            font-weight: 400;
            letter-spacing: -0.005em;
            line-height: 100%;
            margin: 0;
            text-align: center;
            text-shadow: -1px -1px 1px white,
                rgba(0, 3, 204, 0.25) 1px 1px 1px,
                rgba(28, 34, 97, 0.25) 2px 2px 8px,
                rgba(68, 71, 127, 0.1) 2px 32px 128px;
            text-transform: uppercase;
            -moz-background-clip: text;
            -webkit-background-clip: text;
        }

        h2 {
            color: #979cbf;
            font-family: "Open Sans";
            font-size: 4em;
            font-weight: 300;
            letter-spacing: 0.05em;
            line-height: 100%;
            margin: 0;
            opacity: 0.5;
            text-align: center;
        }
    </style>

    <div>
        <h1>Carter</h1>
        <h2>🚀</h2>
    </div>
@stop

@section('script')
    <script>
        ShopifyApp.ready(function () {
            ShopifyApp.Bar.loadingOff();
        });
    </script>
@stop
