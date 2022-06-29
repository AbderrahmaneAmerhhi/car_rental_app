
@extends('layouts.app')

@section('title')
    Home
@endsection
@section('style')
<!-- Link Swiper's CSS -->
<link
rel="stylesheet"
href="https://unpkg.com/swiper/swiper-bundle.min.css"
/>
<link rel="stylesheet" href="{{asset('css/index/index.css')}}">
<link rel="stylesheet" href="{{asset('css/index/navbar.css')}}">
@endsection
@section('content')
<div>
  <index-componenet></index-componenet>
</div>
@endsection

@section('script')
 <!-- Swiper JS -->
 <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

 <!-- Initialize Swiper -->
 <script>
    var swiper = new Swiper(".mySwiper", {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        },
                });
 </script>
@endsection
