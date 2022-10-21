@extends('layouts.app')

@section('content')
<div>
    <transition name="fade" mode="out-in">
        <route-view></route-view>
    </transition>

    <portal-target name="modals" multiple></portal-target>
</div>
@endsection
