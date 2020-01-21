<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/vendor/font-awesome/css/all.min.css') }}">

        <style>
            @media screen and (min-width:768px){
                .custom-error{margin-top:200px;}
            }
        </style>
    </head>
    <body>
        <div class="container custom-error">
        
           <!-- Main content -->
   <section class="content m-5">
      <div class="error-page">
        <h2 class="headline text-danger">
        @yield('error-type')
        </h2>

        <div class="error-content">

        @yield('error-content')

        
        </div>
      </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
        
    </div>




    </body>
    </html>
    
 