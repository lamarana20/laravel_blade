<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <!-- About Us -->
            <div>
                <h3 class="text-xl font-semibold mb-4">About Us</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Your trusted partner in finding the perfect property. We make real estate simple and accessible.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="/" class="hover:text-white transition duration-300">Home</a></li>
                    <li><a href="/properties" class="hover:text-white transition duration-300">Properties</a></li>
                    <li><a href="/contact" class="hover:text-white transition duration-300">Contact</a></li>
                    <li><a href="/about" class="hover:text-white transition duration-300">About</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Contact Info</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li>123 Real Estate Street</li>
                    <li>City, State 12345</li>
                    <li>Phone: <a href="tel:+11234567890" class="hover:text-white"> (123) 456-7890</a></li>
                    <li>Email: <a href="mailto:info@realestate.com" class="hover:text-white">info@realestate.com</a></li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300 text-xl">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300 text-xl">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300 text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300 text-xl">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright - Fix parfait du bas -->
        <div class="mt-12 border-t border-gray-800 pt-6 flex flex-col md:flex-row items-center justify-between text-gray-400 text-sm">
            <p>© <span id="year"></span> Real Estate. All rights reserved.</p>
            <p class="mt-2 md:mt-0">Designed with ❤️ by YourCompany</p>
        </div>
    </div>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</footer>
