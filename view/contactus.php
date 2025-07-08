<?php include '../layouts/header.php'; ?>

<section>
    <!-- Banner Section -->

    <div class="relative w-full h-[500px] bg-cover bg-center overflow-hidden" style="background-image: url('../assets/Images/banner/banner3.svg');">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white lg:w-[800px] mx-auto">
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-red-900 animate-fade-in-down animation-delay-200 opacity-0">
                    Every Bite is an Adventure.
                </h2>

                <p class="text-lg mt-2 text-stone-600 px-4 animate-fade-in-up animation-delay-600 opacity-0">
                    Dive into our menu and experience flavor like never before.
                </p>

                <div class="animate-fade-in-up animation-delay-600 opacity-0">
                    <a href="#contactus" class="inline-block font-bold animate-pulse text-red-900 mt-4 transition-all duration-300 hover:scale-105">
                        Contact us
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contactus" class="flex flex-col md:flex-row justify-between w-full bg-[#EBE6DA] p-8 rounded-lg shadow-lg overflow-hidden">
        <!-- Left Content -->
        <div class="md:w-1/2 mb-6 md:mb-0 animate-slide-in-left animation-delay-500 opacity-0">
            <p class="text-red-900 font-semibold uppercase tracking-wide">LET'S MEET AND TALK</p>
            <h2 class="text-3xl font-bold text-gray-900 mt-2">Get in Touch with Us</h2>
            <p class="text-gray-600 mt-4 leading-relaxed">
                Have any questions, special requests, or feedback? We're here to help!
                Reach out to us and we’ll get back to you shortly. We value your feedback
                and are always looking for ways to improve your dining experience.
            </p>
        </div>

        <!-- Right Form -->
        <div class="md:w-1/2 bg-[#f4f4f4] p-6 rounded-lg shadow-md hover-scale animate-slide-in-right animation-delay-500 opacity-0">
            <form method="POST" action="../include/contact_us.php" id="contact-form" class="space-y-4">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name"
                        class="w-full px-4 py-3 bg-white rounded border-2 border-gray-200 transition-colors focus:border-red-900 transition-all duration-300 focus:outline-none"
                        required>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address"
                        class="w-full px-4 py-3 bg-white rounded border-2 border-gray-200  transition-colors focus:border-red-900 transition-all duration-300 focus:outline-none"
                        required>
                </div>

                <div class="form-group">
                    <select name="subject"
                        class="w-full px-4 py-3 bg-white rounded border-2 border-gray-200  transition-colors focus:border-red-900 transition-all duration-300 focus:outline-none">
                        <option value="" disabled selected>Select a Subject</option>
                        <option>Recipe Request</option>
                        <option>General Inquiry</option>
                        <option>Feedback</option>
                    </select>
                </div>

                <div class="form-group">
                    <textarea name="message" rows="4" placeholder="Your Message"
                        class="w-full px-4 py-3 bg-white rounded border-2 border-gray-200  transition-colors focus:border-red-900 transition-all duration-300 focus:outline-none"
                        required></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-red-900 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-800 transition-all duration-300 transform hover:scale-[1.02]">
                    Send Message
                </button>
            </form>
        </div>
    </div>
    <!-- Contact Details Section -->
    <div class="bg-[#f4f4f4] py-10 px-4">
        <div class="container mx-auto flex flex-col md:flex-row items-center gap-8">
            <!-- Map -->
            <div class="w-full md:w-1/2 p-4 hover-scale">
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.617539259258!2d-73.9854284845942!3d40.748440479327915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1658953397414!5m2!1sen!2sus"
                        class="w-full h-80 border-0" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>

            <!-- Contact Cards -->
            <div class="w-full md:w-1/2 p-4 space-y-6">
                <div class="text-center">
                    <p class="text-red-900 font-semibold uppercase tracking-wide">YOUR DIRECT LINE WITH US</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">Contact Details</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Contact Cards -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover-scale transition-transform">
                        <i class="fas fa-map-marker-alt text-red-900 text-2xl mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Location</h3>
                        <p class="text-gray-600">123 Food Street, New York, NY</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md hover-scale transition-transform">
                        <i class="fas fa-clock text-red-900 text-2xl mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Opening Hours</h3>
                        <p class="text-gray-600">Mon - Fri: 9 AM - 9 PM</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md hover-scale transition-transform">
                        <i class="fas fa-phone-alt text-red-900 text-2xl mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Contact</h3>
                        <p class="text-gray-600">+1 234 567 890</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md hover-scale transition-transform">
                        <i class="fas fa-envelope text-red-900 text-2xl mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Email</h3>
                        <p class="text-gray-600">contact@foodfusion.com</p>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="flex justify-center gap-4 mt-6">
                    <a href="#" class="text-gray-600 hover:text-red-900 transition-colors duration-300 transform hover:scale-125">
                        <i class="fab fa-facebook-f text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-red-900 transition-colors duration-300 transform hover:scale-125">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-red-900 transition-colors duration-300 transform hover:scale-125">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- team member  -->
    <section class="min-h-screen bg-[#EBE6DA] p-8">
        <div class="container mx-auto">
            <h2 class="text-5xl font-bold text-center mb-20 font-playfair">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-stone-700 via-red-900 to-stone-700">
                    Meet Our Team Members
                </span>
            </h2>
            <?php
            include('../include/db.php');

            // Fetch team members from database
            $team_result = $conn->prepare("SELECT * FROM team_members ORDER BY created_at ASC LIMIT 3");
            $team_result->execute();
            $result = $team_result->get_result();

            $team_members = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $team_members[] = $row;
                }
            }
            ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <?php foreach ($team_members as $member):
                    $skills = explode(',', $member['skills']);
                ?>
                    <div class="group relative h-[580px] perspective-1000">
                        <!-- Layered Backgrounds -->
                        <div class="absolute inset-0 bg-red-900 rounded-3xl transform group-hover:rotate-3 transition duration-500 shadow-lg"></div>
                        <div class="absolute inset-0 bg-stone-700 rounded-3xl transform group-hover:-rotate-3 transition duration-500 shadow-lg"></div>

                        <!-- Main Card -->
                        <div class="relative h-full bg-[#f4f4f4] rounded-3xl overflow-hidden shadow-2xl transition-all duration-500 group-hover:scale-[0.98]">
                            <!-- Image Container with Pattern Overlay -->
                            <div class="relative h-80 overflow-hidden">
                                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0D0iMTAwJSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0dGVybiBpZD0ic3RyaXBlcyIgd2lkdGg9IjEwIiBoZWlnaHQ9IjEwIiBwYXR0ZXJuVHJhbnNmb3JtPSJyb3RhdGUoNDUpIj48cmVjdCB3aWR0aD0iMSIgaGVpZ2h0PSIxMCIgZmlsbD0icmdiYSgwLDAsMCwwLjA1KSIvPjwvcGF0dGVybj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0D0iMTAwJSIgZmlsbD0idXJsKCNzdHJpcGVzKSIvPjwvc3ZnPg==')]"></div>
                                <img src="<?= htmlspecialchars($member['image_url']) ?>" alt="<?= htmlspecialchars($member['name']) ?>"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500 mix-blend-multiply">
                            </div>

                            <!-- Content -->
                            <div class="p-6 relative">
                                <!-- Name & Title -->
                                <div class="mb-4 border-l-4 border-red-900 pl-4">
                                    <h3 class="text-2xl font-bold text-stone-700 mb-1"><?= htmlspecialchars($member['name']) ?></h3>
                                    <p class="text-red-900 font-semibold text-sm"><?= htmlspecialchars($member['title']) ?></p>
                                </div>

                                <!-- Description -->
                                <p class="text-stone-700 text-sm mb-6 line-clamp-3 italic">
                                    <?= htmlspecialchars($member['description']) ?>
                                </p>

                                <!-- Skill Chips -->
                                <?php if (!empty($skills)): ?>
                                    <div class="flex flex-wrap gap-2 mb-6">
                                        <?php foreach ($skills as $skill): ?>
                                            <span class="px-3 py-1 bg-red-900/20 text-red-900 rounded-full text-xs font-medium">
                                                <?= htmlspecialchars(trim($skill)) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Social Links -->
                                <div class="flex justify-center space-x-4 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                                    <a href="#" class="social-icon">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.6.113.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                                        </svg>
                                    </a>
                                    <a href="#" class="social-icon">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19.633 7.997c.013.175.013.349.013.523 0 5.325-4.053 11.5-11.5 11.5-2.31 0-4.452-.675-6.262-1.827a8.148 8.148 0 0 0 5.978-1.674 4.077 4.077 0 0 1-3.8-2.828 4.098 4.098 0 0 0 1.843-.069 4.076 4.076 0 0 1-3.27-3.996v-.052a4.09 4.09 0 0 0 1.846.511 4.075 4.075 0 0 1-1.26-5.445 11.558 11.558 0 0 0 8.39 4.254 4.077 4.077 0 0 1 1.187-3.896 4.13 4.13 0 0 1 5.806.183 8.195 8.195 0 0 0 2.59-.988 4.073 4.073 0 0 1-1.792 2.252 8.14 8.14 0 0 0 2.343-.645 8.263 8.263 0 0 1-2.02 2.107z" />
                                        </svg>
                                    </a>
                                    <a href="#" class="social-icon">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Decorative Elements -->
                            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-900 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </section>

    <!-- end team member  -->
</section>

<?php include '../layouts/footer.php'; ?>