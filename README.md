# Bibledoc Modern WordPress Theme

A modern, sleek WordPress theme designed for biblical studies and theological content with dark mode, mobile menu, smooth animations, and engaging user experience.

## Features

### Design & User Experience
- **Modern, Clean Design** - Professional editorial-style layout perfect for theological content
- **Dark Mode** - Toggle between light and dark themes with localStorage persistence
- **Smooth Animations** - Engaging animations including fade-ins, slides, and hover effects
- **Responsive Design** - Fully responsive from mobile to desktop
- **Mobile Menu** - Hamburger menu for mobile devices
- **Hero Section** - Eye-catching hero with customizable content

### Navigation & Discovery
- **Breadcrumb Navigation** - Help users understand their location
- **Back to Top Button** - Smooth scroll to top
- **Reading Progress Bar** - Visual progress indicator
- **Filter & Sort** - Filter by category and sort by date or popularity
- **View Toggle** - Switch between grid and list views
- **Smart Search** - Enhanced search with clear button

### Content Features
- **Post Views Tracking** - Automatic view counting
- **Reading Time Calculation** - Shows estimated reading time
- **Social Sharing** - Share to Twitter, Facebook, and LinkedIn
- **Related Posts** - Shows similar content
- **Author Bio** - Display author information
- **Category Cards** - Showcase popular categories on homepage

### Performance & SEO
- **Lazy Loading** - Images load as needed
- **Optimized Assets** - Deferred JavaScript loading
- **SEO Friendly** - Proper heading structure and semantic HTML
- **Schema Markup** - Structured data for better search visibility

### Accessibility
- **WCAG Compliant** - Meets accessibility standards
- **Keyboard Navigation** - Full keyboard support
- **Screen Reader Friendly** - Proper ARIA labels and alt texts
- **Skip Links** - Skip to main content option
- **Focus States** - Clear focus indicators

## Installation

### Method 1: Upload via WordPress Admin

1. Download the theme folder
2. Compress the `bibledoc-theme` folder into a `.zip` file
3. Go to **Appearance > Themes** in your WordPress admin
4. Click **Add New** then **Upload Theme**
5. Choose the zip file and click **Install Now**
6. Activate the theme

### Method 2: FTP Upload

1. Download the theme folder
2. Connect to your server via FTP
3. Upload the `bibledoc-theme` folder to `/wp-content/themes/`
4. Go to **Appearance > Themes** in WordPress admin
5. Activate the theme

## Setup

### Required Steps

1. **Set Permalinks**
   - Go to **Settings > Permalinks**
   - Choose "Post name" for clean URLs

2. **Create Menus**
   - Go to **Appearance > Menus**
   - Create a menu and assign it to "Primary Menu"

3. **Configure Widgets** (Optional)
   - Go to **Appearance > Widgets**
   - Add widgets to "Sidebar" or "Footer" areas

### Customization

Go to **Appearance > Customize** to configure:

#### Hero Section
- **Hero Title** - Main headline (default: "Looking for answers?")
- **Hero Subtitle** - Subheading (default: "I help friends to understand their Bibles!")
- **Hero Image** - Upload a custom hero image
- **Support Button URL** - Link for the support button

#### Site Identity
- **Site Title** - Your site name
- **Tagline** - Your site description
- **Site Logo** - Upload your logo
- **Site Icon** - Upload favicon

## Theme Features Usage

### Post Views
Post views are automatically tracked. View counts appear on:
- Post cards in archives
- Single post pages
- Admin post list (sortable column)

### Reading Time
Automatically calculated based on word count (200 words per minute). Displays on:
- Post cards in archives
- Single post pages

### Dark Mode
- Users can toggle dark mode via the moon/sun icon in navigation
- Preference is saved in browser's localStorage
- Persists across sessions

### Filtering & Sorting
On archive pages, users can:
- Filter posts by category
- Sort by newest, oldest, or most popular
- Toggle between grid and list views

### Social Sharing
Share buttons appear on:
- Post cards (hover state)
- Single post pages
Opens share dialog in popup window

## Customization

### Adding Custom CSS

Go to **Appearance > Customize > Additional CSS** and add your custom styles.

### Modifying Colors

Edit `style.css` and change the CSS variables:

```css
:root {
    --primary: #2563eb;      /* Primary blue */
    --secondary: #dc2626;    /* Secondary red */
    --dark: #111827;         /* Dark text */
    --gray: #374151;         /* Medium gray */
    --bg-light: #f9fafb;     /* Light background */
}
```

### Adding New Widget Areas

Edit `functions.php` and add:

```php
register_sidebar( array(
    'name'          => 'Your Widget Area',
    'id'            => 'widget-area-id',
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
) );
```

## Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Tips

1. **Use Caching Plugin** - Install WP Super Cache or W3 Total Cache
2. **Optimize Images** - Use WebP format and image compression
3. **Use CDN** - Serve assets from a CDN
4. **Minify CSS/JS** - Use Autoptimize or similar plugin
5. **Database Optimization** - Regularly clean up revisions and spam

## Recommended Plugins

- **Yoast SEO** - SEO optimization
- **Contact Form 7** - Contact forms
- **WP Super Cache** - Caching
- **Smush** - Image optimization
- **Akismet** - Spam protection

## Support

For support and questions:
- Visit: [ArnoldFamini.com](https://arnoldfamini.com)
- Email: pastor@arnoldfamini.com

## Credits

- **Theme Design**: Pastor Arnold Famini
- **Development**: Custom WordPress development
- **Icons**: Unicode emoji icons (accessible and lightweight)

## Changelog

### Version 1.0.0
- Initial release
- Modern design with animations
- Dark mode support
- Mobile responsive
- Filter and sort functionality
- Social sharing
- Post views tracking
- Reading time calculation
- Accessibility features

## License

This theme is licensed under the GNU General Public License v2 or later.

## About the Author

**Pastor Arnold Famini** is a Seventh-day Adventist Pastor, Theologian, and Church Planter serving with the Central Luzon Conference in the Philippines. He is the Managing Editor of Adventists Affirm theological journal and maintains ArnoldFamini.com as a resource hub for sermons, Bible studies, and theological content.

---

*Built with care for biblical studies and theological content sharing.*
