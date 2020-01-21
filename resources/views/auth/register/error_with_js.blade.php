<?php
$errorsArray = $errors->toArray();
?>

@if( $errors->any() )
        @if( 
            !($errors->first('country') 
            || 
            $errors->first('state') 
            || 
            $errors->first('city') 
            || 
            $errors->first('email') 
            || 
            $errors->first('password')
            ))
            ID("tab1").style.display="none";
            ID("loading").style.display="none";
            ID("nextBtn").innerHTML = "Submit";
            ID("prevBtn").style.display = "inline";
            ID("tab2").style.display="block";
            ID("line").style.opacity = "1";
            ID("step2").style.opacity = "1";
            currentTab = 1;
        @endif
        @foreach( $errorsArray as $errors => $error )
            server_validation( '{{ $errors }}', '{{ $error[0] }}' )
        @endforeach

@endif
