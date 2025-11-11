# ZK Futuristic Theme

An ultra-rich, futuristic, gradient animated WordPress theme featuring particle effects, glassmorphism design, and smooth animations throughout. Perfect for developers, designers, and creative professionals who want a cutting-edge portfolio website.

## Features

### Visual Design
- **Animated Gradient Background** - Constantly shifting color gradients that create a dynamic atmosphere
- **Particle Animation System** - Interactive particles that connect and move across the screen
- **Glassmorphism UI** - Modern frosted-glass effect on all cards and elements
- **Smooth Animations** - Fade-in effects, hover animations, and scroll-triggered animations
- **Neon Gradient Typography** - Eye-catching text effects with animated gradients

### Theme Capabilities
- Fully responsive design (desktop, tablet, mobile)
- Custom navigation with smooth scrolling
- Mobile-friendly hamburger menu
- Featured image support for posts and pages
- Widget-ready footer areas (3 columns)
- Custom post thumbnails with multiple sizes
- Comment system support
- Full Gutenberg/Block Editor support
- Custom page templates
- SEO-friendly markup
- Translation ready

### Performance
- Minimal external dependencies
- Optimized animations
- Responsive images
- Clean, semantic HTML5 code

## Installation

### Method 1: Upload via WordPress Admin
1. Download the `zk-futuristic-theme` folder
2. Create a ZIP file of the entire theme folder
3. Go to WordPress Admin → Appearance → Themes → Add New
4. Click "Upload Theme" and select your ZIP file
5. Click "Install Now"
6. Activate the theme

### Method 2: FTP Upload
1. Download the `zk-futuristic-theme` folder
2. Connect to your WordPress site via FTP
3. Upload the theme folder to `/wp-content/themes/`
4. Go to WordPress Admin → Appearance → Themes
5. Activate "ZK Futuristic Theme"

## Setup & Configuration

### 1. Create Your Homepage
1. Go to Pages → Add New
2. Title it "Home" (or any name you prefer)
3. Add your content using the block editor
4. Publish the page

### 2. Set Static Front Page
1. Go to Settings → Reading
2. Select "A static page"
3. Choose your homepage for "Homepage"
4. Save changes

### 3. Configure Navigation Menu
1. Go to Appearance → Menus
2. Create a new menu (e.g., "Primary Menu")
3. Add your pages to the menu
4. Assign it to "Primary Menu" location
5. Save the menu

### 4. Customize Site Identity
1. Go to Appearance → Customize → Site Identity
2. Set your site title (will appear as abbreviated logo in nav)
3. Add a tagline (appears in homepage hero)
4. Upload a custom logo (optional)
5. Publish changes

### 5. Add Widgets (Optional)
1. Go to Appearance → Widgets
2. Add widgets to "Footer Widget Area 1", "Footer Widget Area 2", or "Footer Widget Area 3"
3. Configure as needed

## Theme Templates

The theme includes the following templates:

- **front-page.php** - Homepage with hero section and typing animation
- **index.php** - Blog index with card grid layout
- **page.php** - Standard page template
- **single.php** - Single post template with full meta information
- **archive.php** - Archive pages (categories, tags, dates)
- **header.php** - Header with animated navigation
- **footer.php** - Footer with widget areas

## Customization

### Colors
The theme uses CSS custom properties (variables) for easy color customization. Edit `style.css`:

```css
:root {
    --primary: #00f5ff;     /* Cyan/Turquoise */
    --secondary: #ff00ff;   /* Magenta */
    --accent: #ff6b00;      /* Orange */
    --dark: #0a0a0f;        /* Dark Background */
    --text: #ffffff;        /* White Text */
    --text-muted: #a0a0b0;  /* Muted Text */
}
```

### Typography
The theme uses:
- **Space Grotesk** for headings and body text
- **JetBrains Mono** for code and monospace elements

These are loaded from Google Fonts in `functions.php`.

### Particle Settings
Modify particle behavior in `/js/animations.js`:
- `particleCount` - Number of particles (default: 100)
- Connection distance - Change `150` in the distance check
- Particle size - Adjust in the `Particle` class constructor

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Opera (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Modern browser with JavaScript enabled

## Credits

- **Theme Author:** Zechariah Kasina
- **Font:** Space Grotesk & JetBrains Mono (Google Fonts)
- **Icons:** Bootstrap Icons (inline SVG)

## License

This theme is licensed under the GNU General Public License v2 or later.

## Support

For questions, issues, or feature requests, please visit:
- Website: https://zechariahk.com
- GitHub: https://github.com/zechariahkasina

## Changelog

### Version 1.0.0 - Initial Release
- Ultra-rich futuristic design with animated gradients
- Particle animation system
- Glassmorphism UI elements
- Responsive design for all devices
- Full WordPress theme functionality
- Widget-ready footer areas
- Custom navigation with smooth scrolling
- Mobile hamburger menu
- SEO-friendly markup
