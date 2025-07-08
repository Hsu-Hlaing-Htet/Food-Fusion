<!--start footer -->
<footer class="bg-[#EBE6DA] text-[#800020] pt-16 pb-8">
    <div class="container mx-auto px-6">
        <!-- Top Section -->
        <div class="grid gap-10 lg:grid-cols-4 mb-12">
            <!-- Newsletter -->
            <div class="lg:col-span-2">
                <div class="max-w-md">
                    <h3 class="text-2xl font-bold mb-4">Join Our Culinary Community</h3>
                    <p class="mb-4 text-lg">Get weekly recipes, cooking hacks, and exclusive offers!</p>
                    <form id="subscribeForm" action="../include/subscribe.php" method="POST" class="flex gap-3">
                        <input type="email" name="email" placeholder="Your email address" required
                            class="w-full px-5 py-3 rounded-full border-2 border-[#800020]/20 focus:border-[#800020] focus:ring-0 focus:outline-none">
                        <button type="submit" class="px-6 py-3 bg-[#800020] text-white rounded-full hover:bg-[#600018] transition-colors">
                            Subscribe
                        </button>
                    </form>


                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-2 gap-6 lg:grid-cols-3 lg:col-span-2">
                <div>
                    <h4 class="text-xl font-semibold mb-4">Explore</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-[#600018] transition-colors">Seasonal Recipes</a></li>
                        <li><a href="#" class="hover:text-[#600018] transition-colors">Cooking Classes</a></li>
                        <li><a href="#" class="hover:text-[#600018] transition-colors">Chef's Corner</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xl font-semibold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="../view/aboutus.php" class="hover:text-[#600018] transition-colors">About Us</a></li>
                        <li><a href="../view/contactus.php" class="hover:text-[#600018] transition-colors">Contact</a></li>
                        <li><a href="../view/faq.php" class="hover:text-[#600018] transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xl font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="../view/terms&condition.php" class="hover:text-[#600018] transition-colors">Terms</a></li>
                        <li><a href="../view/privacy.php" class="hover:text-[#600018] transition-colors">Privacy</a></li>
                        <li><a href="../view/cookiepolicy.php" class="hover:text-[#600018] transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="border-[#800020]/20 my-8">

        <!-- Bottom Section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Social Media -->
            <div class="flex space-x-6">
                <a href="https://www.facebook.com" class="p-2 bg-[#800020]/10 rounded-full hover:bg-[#800020]/20 transition-colors">
                    <i class="fab fa-facebook-f text-lg w-6 h-6 flex items-center justify-center"></i>
                </a>
                <a href="https://www.instagram.com" class="p-2 bg-[#800020]/10 rounded-full hover:bg-[#800020]/20 transition-colors">
                    <i class="fab fa-instagram text-lg w-6 h-6 flex items-center justify-center"></i>
                </a>
                <a href="https://www.pinterest.com" class="p-2 bg-[#800020]/10 rounded-full hover:bg-[#800020]/20 transition-colors">
                    <i class="fab fa-pinterest-p text-lg w-6 h-6 flex items-center justify-center"></i>
                </a>
                <a href="https://www.youtube.com" class="p-2 bg-[#800020]/10 rounded-full hover:bg-[#800020]/20 transition-colors">
                    <i class="fab fa-youtube text-lg w-6 h-6 flex items-center justify-center"></i>
                </a>
            </div>

            <!-- Copyright -->
            <div class="text-center md:text-right">
                <p class="text-sm text-[#800020]/80">
                    © 2025 FoodFusion. All rights reserved.<br>
                    <span class="block mt-1">Crafted with ♥ in New York</span>
                </p>
            </div>
        </div>

        <!-- Disclaimer -->
        <p class="text-xs text-[#800020]/60 mt-6 text-center">
            Disclaimer: Recipes may vary based on ingredient availability. Always consult a nutritionist for dietary needs.
        </p>
    </div>
</footer>
<!-- end footer -->
</body>

</html>