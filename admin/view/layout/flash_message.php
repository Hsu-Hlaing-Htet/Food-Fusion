<?php
function display_flash_message()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        // unset($_SESSION['flash']);
        $type = $flash['type'];
        $message = $flash['message'];

        $styles = [
            'success' => [
                'color' => 'green',
                'icon' => '<svg class="w-5 h-5 text-green-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.293a1 1 0 10-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                          </svg>'
            ],
            'error' => [
                'color' => 'red',
                'icon' => '<svg class="w-5 h-5 text-red-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                          </svg>'
            ],
            'info' => [
                'color' => 'blue',
                'icon' => '<svg class="w-5 h-5 text-blue-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 112 0v3a1 1 0 01-1 1h-1a1 1 0 110-2h1V9z" clip-rule="evenodd" />
                          </svg>'
            ]
        ];

        if (isset($styles[$type])) {
            $color = $styles[$type]['color'];
            $icon = $styles[$type]['icon'];

            echo '<div class="flash-message w-auto fixed top-4 right-4 animate-fade-in-up transition-all duration-300 border-l-4 border-' . $color . '-500 bg-' . $color . '-50 p-4 shadow-lg rounded-lg z-50">
            <div onclick="this.parentElement.remove()" class="flex items-center cursor-pointer">
                ' . $icon . '
                <p class="text-sm text-' . $color . '-700 ml-2">' . htmlspecialchars($message) . '</p>
            </div>
        </div>';


            // Automatically remove the flash message after 5 seconds
            echo '<script>
                    setTimeout(function() {
                        document.querySelector(".flash-message").style.opacity = 0;
                        setTimeout(function() { document.querySelector(".flash-message").remove(); }, 500);
                    }, 3000);
                </script>';
        }
        unset($_SESSION['flash']);
    }
}
