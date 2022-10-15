<!DOCTYPE html>
<html lang="en">

<!-- Header  -->
@include('partials.style')


<body class="animsition">
    <div class="page-wrapper">
        @include('partials.sidebar')

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            {{-- @include('partials.header') --}}

            @yield('content')
            <!-- END PAGE CONTAINER-->
        </div>
    </div>
    @yield('modal')
   
    @include('partials.script')
</body>
@yield('javascript')
</html>
<!-- end document-->
