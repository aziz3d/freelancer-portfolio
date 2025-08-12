# 🎨 Personal - Portfolio Website

Modern, feature rich portfolio website built with Laravel 11+ and Tailwind CSS 4+ to showcase my personal professional work as a 2D/3D Artist & Web Developer, you can use it regardless of your profession.

![Laravel](https://img.shields.io/badge/Laravel-11+-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4+-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## 🚀 Features

### 📄 Core Pages
- **Home Page** - Hero section with animated backgrounds, featured projects, blog preview, testimonials, and project stats
- **About Me** - Professional story, skills showcase, work experience timeline, and downloadable resume
- **Projects** - Comprehensive project gallery with filtering, detailed project views, and admin CRUD management
- **Blog** - Article management system with markdown support and rich text editing
- **Services** - Professional services showcase with descriptions and pricing
- **Contact** - Contact form with validation and social media integration
- **Testimonials** - Client testimonials and reviews management

### 🛡️ Security & Admin Features
- **Admin Dashboard** - Complete content management system
- **Session Timeout** - 30-minute auto-logout with 5-minute warning
- **CRUD Operations** - Full content management for all sections
- **Image Management** - Professional image upload and optimization
- **SEO Optimization** - Meta tags, Open Graph, and social previews

### 🎨 Design & UX
- **404 Page** - Animated error page with helpful navigation
- **Responsive Design** - Mobile-first approach with Tailwind CSS
- **Accessibility** - WCAG compliant with reduced motion support
- **Modern UI** - Clean, professional design with smooth animations
- **Performance** - Optimized images, lazy loading, and fast page loads

### 🔧 Technical Features
- **Laravel 11+** - PHP framework with modern features
- **Tailwind CSS 4+** - Utility first CSS framework
- **Vite Build System** - Fast development and optimized production builds
- **Image Processing** - Intervention Image for professional image handling
- **Markdown Support** - CommonMark for blog content
- **Database Seeding** - Mock data for development and testing

## 🛠️ Tech Stack

- **Backend:** Laravel 11+ (PHP 8.2+)
- **Frontend:** Blade Templates + Tailwind CSS 4+
- **Database:** MySQL
- **Build Tool:** Vite 6+
- **Image Processing:** Intervention Image 3+
- **Markdown:** League CommonMark 2+

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL database

### Setup Steps

1. **Clone the repository**
```bash
git clone https://github.com/aziz3d/portfolio-website.git
cd portfolio-website
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node.js dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations and seeders**
```bash
php artisan migrate --seed
```
Note: if 

7. **Create storage link**
```bash
php artisan storage:link
```

8. **Build assets**
```bash
npm run build
```

9. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to view the website.

## 🎯 Usage

### Admin Panel
Access the admin panel at `/admin/login` with the default credentials:
- **Email:** admin@portfolio.com
- **Password:** azizkhan

### Content Management
- **General Settings** - Configure hero section and animation presets
- **Projects** - Add, edit, and manage portfolio projects
- **Blog Posts** - Create and manage blog articles
- **Services** - Define offered services and pricing
- **Testimonials** - Manage client testimonials

## 📁 Project Structure

```
/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   ├── Services/            # Business logic services
│   └── Notifications/       # Email notifications
├── resources/
│   ├── views/
│   │   ├── layouts/         # Base layouts
│   │   ├── pages/           # Page templates
│   │   ├── components/      # Reusable components
│   │   └── partials/        # Partial views
│   └── css/                 # Custom styles
├── public/
│   ├── images/              # Static images
│   ├── css/                 # Compiled CSS
│   └── js/                  # JavaScript files
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
└── routes/
    └── web.php              # Application routes
```

## 🎨 Customization

### Colors & Styling
Modify `tailwind.config.js` to customize the color scheme and design system.

### Content Sections
All content is manageable through the admin panel. No code changes required for:
- Hero section content
- About page information
- Project details
- Blog posts
- Services offered
- Testimonials

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

## 📈 Performance

- **Optimized Images** - Automatic image compression and resizing
- **Lazy Loading** - Images load as needed
- **CSS Purging** - Unused CSS removed in production
- **Asset Minification** - JavaScript and CSS minified
- **Database Optimization** - Efficient queries and indexing

## 🔒 Security

- **CSRF Protection** - All forms protected against CSRF attacks
- **Input Validation** - Server-side validation for all inputs
- **Session Security** - Secure session handling with timeout
- **SQL Injection Prevention** - Eloquent ORM prevents SQL injection
- **XSS Protection** - Output escaping and content sanitization

## 📱 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🤝 Contributing

We welcome contributions to improve this portfolio website! Here's how you can help:

### Ways to Contribute
- 🐛 **Bug Reports** - Found a bug? Please open an issue
- 💡 **Feature Requests** - Have an idea? We'd love to hear it
- 🔧 **Code Contributions** - Submit pull requests for improvements
- 📖 **Documentation** - Help improve our documentation
- 🎨 **Design Improvements** - Suggest UI/UX enhancements
- 🌐 **Translations** - Help make the site multilingual

### How to Contribute
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards for PHP
- Use meaningful commit messages
- Add tests for new features
- Update documentation as needed
- Ensure responsive design compatibility

## 📄 License & Usage Terms

### 🆓 Free Portfolio Template
This portfolio website is **completely free** and open-source for personal and educational use.

### ⚠️ Important Usage Restrictions

**SELLING PROHIBITED** - This template is provided free of charge and **selling it is strictly prohibited**. Any commercial distribution of this template without explicit permission is not allowed.

**Attribution Required** - If you use this template, you must:
- Keep the original author attribution (Aziz Khan)
- Maintain the license information
- Credit the original repository in your project

**Permitted Uses:**
- ✅ Personal portfolio websites
- ✅ Educational projects
- ✅ Learning and development
- ✅ Non-commercial modifications
- ✅ Contributing back to the project

**Prohibited Uses:**
- ❌ Selling the template or derivatives
- ❌ Removing author attribution
- ❌ Commercial redistribution
- ❌ Claiming original authorship

### 📞 Contact for Commercial Use
For commercial licensing or custom development services, please contact:
- **Email:** [sunrise300@gmail.com]
- **LinkedIn:** [Your LinkedIn Profile]
- **Website:** [Your Website]

---

**Developed by Aziz Khan**

*This project is maintained and developed by Aziz Khan. For questions, suggestions, or collaboration opportunities, feel free to reach out!*

## 🌟 Show Your Support

If this project helped you, please consider:
- ⭐ Starring the repository
- 🍴 Forking for your own use
- 🐛 Reporting issues
- 💡 Suggesting improvements
- 📢 Sharing with others

---

*Last updated: January 2025*