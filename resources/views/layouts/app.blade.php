 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>AdminLTE 3 | Blank Page</title>
     @include('partials.head')
     @stack('custom-styles')
 </head>

 <body class="hold-transition sidebar-mini">
     <div class="wrapper">
         @include('layouts.navbar')
         @include('layouts.sidebar')

         <div class="content-wrapper">
             <section class="content-header">
                 <div class="container-fluid">
                     <div class="row mb-2">
                         <div class="col-sm-6">
                             {{-- <h1>@yield('title', 'Blank Page')</h1> --}}
                         </div>
                         <div class="col-sm-6">
                             <ol class="breadcrumb float-sm-right">
                                 @yield('breadcrumb') {{-- Yield for breadcrumb --}}
                             </ol>
                         </div>
                     </div>
                 </div>
             </section>

             <section class="content">
                 <div class="card card-default color-palette-box">
                     <div class="card-body">
                         @yield('content')
                     </div>
                 </div>
             </section>
         </div>
         @include('layouts.footer')
         @include('layouts.aside')
     </div>
     @include('partials.scripts')
     @stack('custom-scripts')
    </body>
 </html>
