@extends('layouts.myLibraryMaster') <!-- Menggunakan layout master yang benar -->

@section('content')
<main>
    <!-- Home Section -->
    <section id="home" class="home-section text-center h-screen" style="background-image: url('https://wallpapercave.com/wp/wp12420332.jpg'); background-size: cover; background-position: center;">
        <div class="flex justify-center items-center h-full bg-black bg-opacity-50">
            <div>
                <h1 class="text-5xl font-semibold text-white">Welcome to Our Library</h1>
                <p class="text-xl text-white mb-6">Your gateway to knowledge and discovery</p>
                <a href="{{route('dashboard.mahasiswa.home')}}" class="btn btn-primary text-white bg-blue-600 py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300">Explore Services</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-8">Our Services</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="service-card p-6 border rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <i class="fas fa-book-open fa-3x text-blue-600 mb-4"></i>
                    <h4 class="text-xl font-semibold mb-2">Book Lending</h4>
                    <p>Borrow books for various genres, including fiction, non-fiction, and educational materials.</p>
                </div>
                <div class="service-card p-6 border rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <i class="fas fa-users fa-3x text-blue-600 mb-4"></i>
                    <h4 class="text-xl font-semibold mb-2">Community Events</h4>
                    <p>Join our events for book clubs, author meet-ups, and workshops.</p>
                </div>
                <div class="service-card p-6 border rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <i class="fas fa-laptop fa-3x text-blue-600 mb-4"></i>
                    <h4 class="text-xl font-semibold mb-2">Digital Library</h4>
                    <p>Access digital books, journals, and e-learning resources online.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Books Section -->
    <section id="books" class="books-section py-16 bg-gray-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-8">Popular Books</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="book-card border rounded-lg shadow-md p-4">
                    <div class="image-container h-48 bg-gray-300 mb-4"></div>
                    <h5 class="font-semibold mb-2">Book Title 1</h5>
                    <p class="text-gray-600">Author: Author Name</p>
                </div>
                <div class="book-card border rounded-lg shadow-md p-4">
                    <div class="image-container h-48 bg-gray-300 mb-4"></div>
                    <h5 class="font-semibold mb-2">Book Title 2</h5>
                    <p class="text-gray-600">Author: Author Name</p>
                </div>
                <div class="book-card border rounded-lg shadow-md p-4">
                    <div class="image-container h-48 bg-gray-300 mb-4"></div>
                    <h5 class="font-semibold mb-2">Book Title 3</h5>
                    <p class="text-gray-600">Author: Author Name</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="events-section py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-8">Upcoming Events</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="event-card border rounded-lg shadow-md p-6">
                    <h4 class="text-xl font-semibold mb-4">Book Club Meetup</h4>
                    <p>Join us for a discussion of the latest bestseller.</p>
                    <p><strong>Date:</strong> 15th December, 2024</p>
                </div>
                <div class="event-card border rounded-lg shadow-md p-6">
                    <h4 class="text-xl font-semibold mb-4">Author Meet & Greet</h4>
                    <p>Meet your favorite author and ask questions about their works.</p>
                    <p><strong>Date:</strong> 20th December, 2024</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section py-16 bg-gray-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-8">Contact Us</h2>
            <form class="max-w-lg mx-auto">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <input type="text" class="form-input w-full p-4 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" placeholder="Your Name" required>
                    </div>
                    <div>
                        <input type="email" class="form-input w-full p-4 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="mt-4">
                    <textarea class="form-textarea w-full p-4 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500" rows="4" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="mt-6 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300">Send Message</button>
            </form>
        </div>
    </section>

</main>
@endsection
