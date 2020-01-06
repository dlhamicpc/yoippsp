@extends('outerWebsite.layouts.master')
@section('title', '- Privacy')

@section('content')

@include('outerWebsite.pages.privacy.partials.header')
@include('outerWebsite.pages.privacy.partials.tabs') 

@endsection

@section('js')
<script src="{{ asset('/vendor/easy-responsive-tabs/easy-responsive-tabs.js') }}"></script>

<script>
$(document).ready(function () {
$('#horizontalTab').easyResponsiveTabs({
type: 'default', //Types: default, vertical, accordion          
});
$('#verticalTab').easyResponsiveTabs({
type: 'vertical', //Types: default, vertical, accordion
});
});
</script>
@endsection