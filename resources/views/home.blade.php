@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <a href="/SHS" class="btn btn-primary">SHS</a>
                        <a href="http://localhost:81/fyphunting/resources/views/welcome.blade.php" class="btn btn-primary">Fatiny</a>
                        <a href="http://localhost:81/dharshini/DHARSHINI/public/" class="btn btn-primary">Manage User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
