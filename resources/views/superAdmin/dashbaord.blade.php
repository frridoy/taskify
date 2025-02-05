@extends('setup.layout')
@section('content')

<h4>
    {{Auth::user()->name}}
    Super ADmin
</h4>


<form method="POST" action="{{ route('logout') }}">
    @csrf

    <x-dropdown-link :href="route('logout')"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
        {{ __('Log Out') }}
    </x-dropdown-link>
</form>


@endsection
