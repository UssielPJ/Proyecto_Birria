# Sidebar Menu Usage and Extraction Plan

## Information Gathered
- The admin layout (`src/plataforma/app/views/layouts/admin.php`) contains a fully functional sidebar with:
  - User info display (name, email)
  - Navigation links for admin functions
  - Collapsible functionality (desktop)
  - Mobile drawer toggle
  - Theme toggle button
  - Logout link
- Uses Tailwind CSS, Feather icons, custom CSS for animations, and JavaScript for interactivity
- A simpler `sidenav.php` partial exists but is not used in the admin layout
- Dependencies include theme.js, notifications.js, AOS library, and custom styles

## Plan
1. **Provide instructions for using the sidebar via admin layout**
   - Explain how to create new admin pages using the admin.php layout
   - Detail the required session guards and dependencies

2. **Extract the sidebar into a reusable partial**
   - Create a new partial file `admin_sidebar.php` with the sidebar code
   - Update admin.php to include the partial
   - Ensure all functionality (collapsible, mobile, theme) is preserved

3. **Document necessary dependencies**
   - List all required CSS, JS, and libraries
   - Provide setup instructions for new layouts

4. **Instructions for including the sidebar partial in other layouts**
   - Show how to include the partial in other role layouts (teacher, student, capturista)
   - Adapt user info and navigation links per role

## Followup Steps
- Test the extracted partial in admin layout
- Verify functionality (toggle, theme, mobile)
- Provide usage examples for other layouts
