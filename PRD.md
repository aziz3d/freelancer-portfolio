
# Product Requirements Document: Job-Seeking Portfolio Website

## 📌 Project Overview

**Name:** Aziz Khan  
**Role:** 2D/3D Artist & Web Developer  
**Tech Stack:** Laravel 11+, Tailwind CSS 4+  
**Goal:** Build a personal portfolio website to showcase professional work and attract job opportunities.

---

## Image Usage

- Use images from the public/images directory
- Dont use Link:Storage method directly use public directory for images
- Add full mock data on all pages

## 🎯 Objectives

- Present skills, tools, and experience professionally.
- Highlight key projects and technical capabilities.
- Provide easy access to resume and contact info.
- Optimize for SEO and responsiveness across devices.

---

## 🧱 Tech Stack

- **Backend:** Laravel 11+
- **Frontend:** Blade templates + Tailwind CSS 4+
- **Database:** MySQL

---

## 📁 Folder Structure

/resources/views
├── layouts/
├── pages/
├── components/
└── partials/

---

## 📄 Pages & Sections

### 1. **Home Page (`/`)**

- Hero Section  
  - Name: Aziz Khan  
  - Role: "2D/3D Artist & Web Developer"  
  - CTA buttons: [View Projects], [Hire Me]
- Summary Section  
  - Brief overview of skills/tools
- Featured Projects Preview (6 max)
- Blog Section
- Testimonials Section
- Project Stats Section
- Footer Section
- With admin CRUD

---

### 2. **About Me Page (`/about`)**

- Profile summary (story, background)
- Skills & tools (icons or badges)
- Work experience timeline
- Downloadable resume button
- With admin CRUD

---

### 3. **Projects Page (`/projects`)**

- Grid/List of all projects
  - Project name
  - Short description
  - Thumbnail
  - Tags (e.g., Laravel, 3ds Max)
  - "View Details" → Modal or Separate Page
  - With admin CRUD

---

### 4. **Blog Page (`/blog`)**

- List of blog articles
  - Title, short excerpt, thumbnail, date
- Individual blog post view
  - Markdown support or rich text
- With admin CRUD

---

### 5. **Contact Page (`/contact`)**

- Contact form: name, email, message
- Email validation
- Success/failure message
- Social icons (LinkedIn, GitHub, ArtStation, etc.)

---

### 6. **Services Page (`/services`)**

- List of offered services
  - Title, description, icons
  - e.g., Web Development, 3D Modeling, UI/UX, Retopology, Rigging, Rendering
  - With admin CRUD

---

### 7. **Testimonials Page (`/testimonials`)**

- List of client/colleague testimonials
  - Name, photo, role, quote

---

## 🧩 Components

- **Navbar:** Sticky, links to all pages
- **Footer:** Social links, copyright
- **Project Card:** Thumbnail, title, tags
- **Blog Card:** Thumbnail, excerpt, link
- **Modal:** For project details (optional)

---

## 🎨 Design System

- **Tailwind CSS 4+**
- Dont use dark mode
- mColor scheme modern visually appealing colors

---

## ✅ Features

- Fully responsive design
- SEO meta tags per page
- Open Graph for social previews
- Lazy loading for images
- Accessibility best practices

---

## 📌 Future Enhancements

- Add multilingual support (Turkish, English, etc.)
- Add admin dashboard to manage blog/projects
- Add job availability banner (e.g., “Open to Work”)

---

