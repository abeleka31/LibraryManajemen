

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>

    <!-- Navigation Bar -->
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('dashboard.mahasiswa.home')}}">Books</a></li>
                    <!-- Authentication Links -->
                    @if (Auth::check())
                        <div class="d-flex align-items-center">
                            <span class="text-dark me-3">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark">Logout</button>
                            </form>
                        </div>
                    @else
                        <div class="d-flex align-items-center">
                            <a href="{{ route('login') }}" class="btn btn-link text-dark">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-link text-dark">Register</a>
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    <!-- Home Section -->
    <!-- Home Section -->
    <section id="home" class="home-section text-center py-5 vh-100" style="background-image: url('https://wallpapercave.com/wp/wp12420332.jpg'); background-size: cover; background-position: center;">
        <div class="container h-100 d-flex flex-column justify-content-center">
            <h1 class="text-white">Welcome to Our Library</h1>
            <p class="text-white">Your gateway to knowledge and discovery</p>
            <a href="#services" class="btn btn-primary">Explore Services</a>
        </div>
    </section>


    <!-- Services Section -->
    <section id="services" class="services-section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Our Services</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-book-open fa-3x"></i>
                        <h4>Book Lending</h4>
                        <p>Borrow books for various genres, including fiction, non-fiction, and educational materials.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-users fa-3x"></i>
                        <h4>Community Events</h4>
                        <p>Join our events for book clubs, author meet-ups, and workshops.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-laptop fa-3x"></i>
                        <h4>Digital Library</h4>
                        <p>Access digital books, journals, and e-learning resources online.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Books Section -->
    <section id="books" class="books-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Popular Books</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="book-card">
                        <div class="image-container" style="height: 200px; background-color: #ccc; margin-bottom: 15px;">
                            <!-- Image can be added here -->
                        </div>
                        <h5>Book Title 1</h5>
                        <p>Author: Author Name</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="book-card">
                        <div class="image-container" style="height: 200px; background-color: #ccc; margin-bottom: 15px;">
                            <!-- Image can be added here -->
                        </div>
                        <h5>Book Title 2</h5>
                        <p>Author: Author Name</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="book-card">
                        <div class="image-container" style="height: 200px; background-color: #ccc; margin-bottom: 15px;">
                            <!-- Image can be added here -->
                        </div>
                        <h5>Book Title 3</h5>
                        <p>Author: Author Name</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="events-section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Upcoming Events</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="event-card">
                        <h4>Book Club Meetup</h4>
                        <p>Join us for a discussion of the latest bestseller.</p>
                        <p><strong>Date:</strong> 15th December, 2024</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="event-card">
                        <h4>Author Meet & Greet</h4>
                        <p>Meet your favorite author and ask questions about their works.</p>
                        <p><strong>Date:</strong> 20th December, 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Contact Us</h2>
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <textarea class="form-control" rows="4" placeholder="Your Message" required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2024 Library. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS, Popper, and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
