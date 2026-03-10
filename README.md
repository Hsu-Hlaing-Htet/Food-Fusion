#  FoodFusion – Culinary Community Web Application

FoodFusion is a culinary platform built to inspire home cooking and creative food experiences. This full-featured web application serves as a central hub for recipe sharing, community interaction, and culinary education.

##  Project Overview

This project was developed for FoodFusion to promote culinary creativity through a responsive, user-friendly website. Users can explore global recipes, contribute to a community cookbook, and access downloadable culinary resources.

---

##  Features
-  **Fully Responsive Design**: Works seamlessly across desktops, tablets, and smartphones.  
-  **Cookie Consent Banner**: Ensures compliance with data privacy policies.  
-  **Social Media Integration**: Links to platforms like Facebook, YouTube, and Instagram.  
-  **Privacy Policy Page**: Transparency in how user data is handled.

##  Key Features

- **Responsive Design:** Optimized for desktops, tablets, and mobile devices for seamless user experience.  
- **Community Cookbook:** Allows users to submit, share, and discover recipes from diverse cuisines.  
- **User Authentication & Security:** Secure registration and login system with account lockout after multiple failed login attempts.  
- **Interactive Homepage:** Features a dynamic news feed showcasing recipes and an event carousel.  
- **Comprehensive Resource Library:** Includes downloadable recipe cards, cooking tutorials, and educational materials on sustainable cooking.  
- **Admin Dashboard:** Provides administrators with tools to manage users, recipes, and site content effectively.  
- **Privacy Compliance:** Cookie consent banner and dedicated privacy policy page to ensure transparency and legal compliance.  

###  General
- Fully responsive and accessible design
- Cookie consent notification and privacy policy display
- Integrated social media links

###  Core Pages
- **Homepage**
  - Mission statement
  - "Join Us" pop-up form (First Name, Last Name, Email, Password)
  - Featured recipe news feed
  - Carousel of upcoming cooking events

- **About Us**
  - Details about FoodFusion’s philosophy, values, and team

- **Recipe Collection**
  - Curated recipes from around the world
  - Filters by cuisine, dietary preferences, and difficulty level

- **Community Cookbook**
  - Members can submit and share recipes and tips

- **Contact Us**
  - Interactive contact form for inquiries or feedback

- **Culinary Resources**
  - Downloadable recipe cards, cooking tutorials, kitchen hacks

- **Educational Resources**
  - Infographics and videos on renewable energy topics

###  Security
- User registration and login system
- Account lockout after 3 failed login attempts (auto-unlock after 3 minutes)

---

##  Tech Stack

| Layer      | Technology       |
|------------|------------------|
| Frontend   | HTML, CSS, JavaScript |
| Backend    | PHP              |
| Database   | MySQL            |
| Auth       | Session-based login/logout |

---

### Installation

To run this project locally:

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/foodfusion.git
    ```

2. Set up your local web server (XAMPP, MAMP, etc.):
   Place the project folder inside the htdocs (for XAMPP) or appropriate directory.

3. Create the database:
   Import the provided database.sql file into your MySQL server.

4. Import the provided database.sql file into your MySQL server.
   Open config.php and update your DB host, username, password, and database name.

5. Run the application:
   Visit ```http://localhost/foodfusion``` in your browser.

## Project Structure
```
FoodFusion/
├── assets/                   # Static assets like CSS, JS, fonts, images
│   ├── css/
│   │   ├── style.css         # Tailwind generated styles
│   │   ├── main.css          # Tailwind setup
│   │   ├── animation.css     # Custom animations
│   │   └── fontawesomev5.14.4.all.min.css  # Icons
│   ├── js/
│   │   └── scripts.js        # Custom JavaScript files
│   ├── font/                 # Fonts and SVGs
│   └── images/
│       └── banner/
│           └── burger.png    # Example image
│
├── include/                  # Backend processing files
│   └── login.php             # Login handling
│
├── layouts/                  # Reusable layout components
│   ├── header.php
│   └── footer.php
│
├── view/                     # Public-facing pages
│   ├── index.php             # Homepage
│   └── contactus.php         # Contact page
│
├── auth/                     # Authentication and user panel files
│   ├── register.php
│   ├── login.php
│   ├── forgot_password.php
│   ├── dashboard.php         # User/admin dashboard
│   ├── recipe.php            # Recipe management
│   ├── user.php              # User management
│   ├── subscriber.php        # Newsletter or subscription management
│   ├── header.php            # Auth panel header layout
│   ├── sidebar.php           # Auth panel sidebar menu
│   ├── footer.php            # Auth panel footer
│   └── flash_messages.php    # Notification messages
│
├── admin/                    # (If exists) Separate admin panel files & views
│   ├── view/
│   │   └── ...               # Admin-specific pages
│   └── assets/               # Admin-specific assets (images, css, js)
│
├── postcss.config.js         # PostCSS config for Tailwind CSS
├── tailwind.config.js        # Tailwind CSS configuration
├── package.json              # Node.js dependencies and scripts
├── database.sql              # Database schema & initial data
├── config.php                # Configuration settings (DB, paths, etc.)
└── README.md                 # Project documentation
```

##  Admin Side Description

The admin panel provides tools for managing the platform content and users:

- Secure login for administrators.
- Dashboard overview of platform statistics.
- User management (view, edit, delete users).
- Recipe management (approve, edit, or remove community submissions).
- Content management for educational and culinary resources.
- Subscriber and newsletter management.
- Flash message system for admin notifications.
- Separate asset folder for admin-specific styling and scripts.

The admin area is located under the `/admin/` directory and is accessible only to authorized users.

## License

This project is licensed under the MIT License.
You are free to use, modify, and distribute this software with proper attribution.

## Contact
For any inquiries or support, feel free to reach out:

- Email: hsuhtet562@gmail.com
- GitHub: https://github.com/Hsu-Hlaing-Htet
