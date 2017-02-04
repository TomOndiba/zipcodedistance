@extends('layout')

@section('content')

        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
                margin-bottom: 40px;
            }

            .quote {
                font-size: 24px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
            <br>
                <div class="title">Darwin Miguel Rocha Guerrero</div>
                    <div class="form-group">
                        <div class="col-md-16">
                            <a href="{{ url('cargarcsv') }}" class="btn btn-success"> Add CSV </a>
                            <a href="{{ url('cargaragents') }}" class="btn btn-primary"> Add agents </a>
                            <a href="{{ url('match') }}" class="btn btn-warning"> MATCH IN BICI</a>
                             <a href="{{ url('matchDistance') }}" class="btn btn-warning"> MATCH DISTANCE</a>
                            <a href="{{ url('showcontacts') }}" class="btn btn-info"> Show Contacts </a>
                        </div>
                    </div>
                </div>
           </div>
        </div>

      </body>

     @endsection
