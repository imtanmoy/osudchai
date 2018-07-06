<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body class="hold-transition skin-blue sidebar-mini">

<div id="wrapper">

@include('admin.partials.topbar')
@include('admin.partials.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @include('flash::message')
            @if(isset($siteTitle))
                <h3 class="page-title">
                    {{ $siteTitle }}
                </h3>
            @endif

            <div class="row">
                <div class="col-md-12">

                    @if (Session::has('message'))
                        <div class="note note-info">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    @if ($errors->count() > 0)
                        <div class="note note-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
        </section>
    </div>
</div>

{!! Form::open(['route' => 'admin.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

@include('admin.partials.javascripts')

<script>
    $('#flash-overlay-modal').modal();
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
</body>
</html>