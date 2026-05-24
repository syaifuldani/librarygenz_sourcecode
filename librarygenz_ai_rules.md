# LibraryGenz — AI Development Rules & PRD

## Project Identity
**Project Name:** LibraryGenz

LibraryGenz is a modern web-based library management system built for intermediate-level full-stack development using Laravel and Tailwind.

---

# Core Tech Stack

## Backend
- Laravel
- PHP

## Frontend
- Tailwind CSS
- Blade Template Engine

## Database
- MySQL

## Authentication
- Laravel Breeze

---

# Design System Rules
Reference visual inspiration from the uploaded design system.
Use its warm editorial aesthetic as inspiration, with adaptive implementation suitable for LibraryGenz. Use colors contextually and choose harmonious combinations where appropriate.

## Visual Direction
- Warm cream primary canvas
- Coral accent for CTA and interactive actions
- Dark navy surfaces for dashboards and data panels
- Editorial/minimalist modern dashboard feel
- Clean spacing and generous white space

## Typography Style
- Elegant serif for major headings (if available)
- Clean sans-serif for body and dashboard content

## UI Components
Must include:
- Sidebar navigation
- Top navbar
- Dashboard statistic cards
- Responsive data tables
- Status badges
- Modal/dialog confirmations

---

# Roles & Permissions

## 1. Admin
Permissions:
- Manage all users
- Manage librarians
- Manage members
- Configure system settings
- Configure fine rules
- Access all reports
- Monitor analytics

---

## 2. Librarian
Permissions:
- Manage books
- Manage inventory
- Approve/reject borrowing requests
- Verify returns
- Process fines
- Monitor overdue books

---

## 3. Member
Permissions:
- Browse catalog
- Search books
- Submit borrowing requests
- Submit return requests
- View borrowing history
- View fines

---

# Borrowing Workflow

## Step 1 — Borrow Request
Member submits borrowing request.
Status: `Pending`

## Step 2 — Review
Librarian approves or rejects.
Statuses:
- `Approved`
- `Rejected`

## Step 3 — Active Borrowing
After approval:
- stock decreases
- due date assigned
Status: `Borrowed`

## Step 4 — Return Request
Member submits return.
Status: `Returning`

## Step 5 — Verification
Librarian verifies and finalizes return.
Status: `Returned`

If overdue:
Status: `Overdue`

---

# Fine Rules
Flat fine system:

**Rp2.000 / day late**

Formula:
Fine = Late Days × 2000

Automatically calculated during return verification.

---

# Core Features

## Authentication
- Login
- Register member
- Logout
- Role-based redirect

## Book Management
- Create book
- Update book
- Delete book
- Upload cover image
- Search books
- Category filter
- Stock management

## Category Management
- Add category
- Edit category
- Delete category

## Borrowing Management
- Request borrowing
- Approval workflow
- Return verification
- Fine generation

## Dashboard Analytics
Admin:
- User statistics
- Transaction charts
- Borrowing trends

Librarian:
- Pending approvals
- Overdue books

Member:
- Active loans
- Borrowing history
- Fine status

## Reporting
- Most borrowed books
- Overdue report
- Borrowing history logs

---

# Database Tables
- users
- books
- categories
- borrowings
- fines
- activity_logs

---

# Non-Scope (STRICT)
Do NOT implement:
- Payment gateway
- Email notification system
- Barcode scanner
- AI recommendation engine
- Mobile application
- Chat system
- External integrations

---

# AI Implementation Rules

## Scope Control
AI must:
- Build only requested features
- Never add features outside PRD
- Never rewrite unrelated files
- Ask for clarification if ambiguous

## Development Style
AI must:
- Follow Laravel best practices
- Use modular architecture
- Use RESTful controllers
- Use migrations properly
- Use Eloquent relationships
- Keep code clean and readable

## Output Format for Development Tasks
Always provide:
1. File structure changes
2. Exact files to create/update
3. Complete implementation code
4. Brief explanation
5. Migration instructions if needed

---

# Development Phases

## Phase 1
Project setup

## Phase 2
Authentication + Roles

## Phase 3
Book CRUD

## Phase 4
Borrowing workflow

## Phase 5
Fine system

## Phase 6
Dashboard analytics

## Phase 7
Reporting

---

# Final Rule
LibraryGenz must maintain:
- clean editorial aesthetic
- professional dashboard appearance
- warm modern interface
- role-based workflow clarity
- intermediate project scope only

