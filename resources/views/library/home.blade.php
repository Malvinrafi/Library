@extends('layouts.app')

@section('content')

<main class="container mx-auto mt-5 p-4">
    <!-- Carousel -->
    <div 
    x-data=
    "{ activeSlide: 0, 
    slides: ['{{ asset('images/libreria_style.png') }}', '{{ asset('images/study_motivation.jpeg') }}', '{{ asset('images/lesson.jpeg') }}'],
    init()  {
        setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides.length; }, 5000);}
    }" 
    class="relative w-full max-w-6xl mx-auto overflow-hidden">

    <!-- Container untuk slides -->
    <div class="relative w-full aspect-[16/9]">
    <template x-for="(slide, index) in slides" :key="index">
        <img :src="slide" 
                class="absolute top-0 left-0 w-full h-full object-cover transition-opacity duration-500 ease-in-out"
                x-show="activeSlide === index"
                x-transition:enter="opacity-0"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="opacity-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
    </template>
    </div>

    <!-- Tombol Navigasi -->
    <div class="absolute inset-0 flex justify-between items-center px-4">
    <button @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length" 
            class="bg-white text-blue-500 px-4 py-2 rounded-full shadow-md">
        &#10094;
    </button>
    <button @click="activeSlide = (activeSlide + 1) % slides.length" 
            class="bg-white text-blue-500 px-4 py-2 rounded-full shadow-md">
        &#10095;
    </button>
    </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mt-6 text-center">
        <h1 class="text-3xl font-serif mb-4">Welcome to Libreria!</h1>
        <p class="text-gray-700">- a place where books are the window to the world -</p>
    </div>


    <!-- Items for scrolling in grid layout with clickable links -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 grid-rows-1 gap-6">
        @foreach ($books as $book)
            <a href="{{ route('book.detail', ['id' => $book->id]) }}" class="bg-white p-4 rounded-lg shadow-md hover:bg-gray-100 block relative">
                <img src="{{ asset('storage/' . $book->book_cover) }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-md mb-4">
                <div class="absolute bottom-0 left-0 w-full p-4 bg-gray-300 opacity-80">
                    <h3 class="text-lg font-semibold text-center text-black">{{ $book->title }}</h3>
                </div>
            </a>
        @endforeach
    </div>
</main>

@endsection
