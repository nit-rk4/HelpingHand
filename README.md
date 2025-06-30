# HelpingHand
A web-based community help board for barangays, built with PHP, MySQL, HTML, and CSS. This repo is only for the development team.

---

## Team Roles
### Frontend (3)
Each member handles both:
- The visual design (HTML/CSS)
- The PHP integration for their assigned page

- **Deanne – User Menu**  
  Handles user dashboard, request form, request status, and fulfillment

- **Tavi – Admin Menu**  
  Handles admin dashboard, approvals, filters, reports, and interviews

- **Ysabel – Help Board**  
  Handles request browsing, help buttons, reports, proof of help

### Backend (2)
- **Ezekiel – Login + Submission Logic**  
  Handles registration, login, request submission, request expiration

- **Denise – Admin + Helper Logic**  
  Handles approvals, fulfillment, helper tracking, reporting system

--- 

## Folder Guide

| Folder | Description |
|--------|-------------|
| `/css/` | All CSS files. Use `style.css` with clear sections and prefixes |
| `/php/` | Backend logic files (e.g., `login.php`, `submit_request.php`) |
| `/pages/` | Main site pages (e.g., `user_dashboard.php`, `help_board.php`) |
| `/db/` | Our MySQL database export file (`helpinghand.sql`) |
| `/assets/` | Optional folder for images, icons, proof uploads |
| `index.php` | Main entry file — can redirect to login or homepage |

---

## Git Workflow

1. **Clone** the repo to your computer/laptop
2. **Create a branch** with your name or role (e.g., `deanne-usermenu`, `backend-logic`)
3. **Commit** and **push** your changes to *your* branch
4. Only **merge to `main`** when your changes are working and you're done
5. NEVER push directly to `main` without checking

---

## Final Notes

- Always communicate big changes (especially database changes)
- Comment your code and keep it readable
- Ask for help whenever you're stuck

---
