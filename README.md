<div align="center">
🚀 CRM System
Modern Customer Relationship Management Platform
Show Image
Show Image
Show Image
Show Image
Streamline your customer relationships with elegance and efficiency
Features • Installation • Documentation • Contributing
</div>

📋 Table of Contents

About
Features
Tech Stack
Prerequisites
Installation
Configuration
Usage Examples
API Documentation
Testing
Contributing
License
Support


🎯 About
CRM System is a powerful, modern customer relationship management platform built with Laravel. It helps businesses manage contacts, track deals, monitor sales pipelines, and analyze customer interactions all in one place.
Why Choose Our CRM?
✅ Easy to Use - Intuitive interface designed for productivity
✅ Fully Customizable - Adapt it to your business needs
✅ Open Source - Free to use and modify
✅ Scalable - Grows with your business
✅ Secure - Built with Laravel's robust security features
✅ API First - RESTful API for integrations

✨ Features
👥 Contact Management

Complete customer profiles
Custom fields and tags
Import/Export contacts (CSV, Excel)
Advanced search and filtering
Bulk operations

💼 Deal Pipeline

Visual Kanban board
Drag-and-drop stages
Deal value tracking
Win probability calculator
Sales forecasting

📊 Analytics & Reports

Real-time dashboard
Sales performance metrics
Conversion rate tracking
Custom report builder
Export to PDF/Excel

📧 Email Integration

Send emails directly from CRM
Email templates
Activity tracking
Automated follow-ups
SMTP/API support

📅 Activity Management

Schedule calls and meetings
Task reminders
Activity timeline
Team collaboration
Calendar integration

🔐 Security & Permissions

Role-based access control
User permissions
Audit logs
Two-factor authentication
Data encryption


🛠️ Tech Stack

Backend: Laravel 11.x
Frontend: Blade Templates, Alpine.js, Livewire
Styling: Tailwind CSS
Database: MySQL 8.0+ / PostgreSQL
Authentication: Laravel Sanctum
Real-time: Laravel Echo, Pusher
Cache: Redis
Queue: Redis, Database


📦 Prerequisites
Before installation, ensure you have:

PHP >= 8.2
Composer >= 2.5
Node.js >= 18.x and NPM
MySQL >= 8.0 or PostgreSQL >= 14
Redis (optional, for caching and queues)
Git


🚀 Installation
Follow these steps to get your CRM system up and running:
Step 1: Clone Repository
bashgit clone https://github.com/yourusername/crm-system.git
cd crm-system
Step 2: Install PHP Dependencies
bashcomposer install
Step 3: Install Node Dependencies
bashnpm install
Step 4: Environment Configuration
bashcp .env.example .env
php artisan key:generate
Step 5: Configure Database
Edit your .env file with your database credentials:
envDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_database
DB_USERNAME=root
DB_PASSWORD=your_password
Step 6: Run Migrations
bashphp artisan migrate --seed
This will create all necessary tables and seed demo data.
Step 7: Build Assets
For development:
bashnpm run dev
For production:
bashnpm run build
Step 8: Start Development Server
bashphp artisan serve
Visit http://localhost:8000 in your browser! 🎉

⚙️ Configuration
Default Admin Credentials
After seeding, you can login with:
Email: admin@crm.com
Password: password

⚠️ Security Warning: Change these credentials immediately in production!

Email Configuration
Configure email settings in .env:
envMAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourcrm.com
MAIL_FROM_NAME="${APP_NAME}"

💻 Usage Examples
Creating a Contact
phpuse App\Models\Contact;

$contact = Contact::create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
    'phone' => '+1234567890',
    'company' => 'Acme Corporation',
    'position' => 'CEO',
    'status' => 'active'
]);
Managing Deals
phpuse App\Models\Deal;

// Create a new deal
$deal = Deal::create([
    'title' => 'Enterprise Package Sale',
    'value' => 50000,
    'currency' => 'USD',
    'stage' => 'qualification',
    'probability' => 25,
    'contact_id' => $contact->id,
    'user_id' => auth()->id(),
    'expected_close_date' => now()->addDays(30)
]);

// Move deal to next stage
$deal->moveToStage('proposal');

// Win a deal
$deal->win();
Tracking Activities
phpuse App\Models\Activity;

// Log a call
Activity::create([
    'type' => 'call',
    'subject' => 'Follow-up discussion',
    'description' => 'Discussed pricing and implementation timeline',
    'contact_id' => $contact->id,
    'deal_id' => $deal->id,
    'duration' => 30, // minutes
    'completed_at' => now()
]);

// Schedule a meeting
Activity::create([
    'type' => 'meeting',
    'subject' => 'Product Demo',
    'scheduled_at' => now()->addDays(2)->setTime(14, 0),
    'contact_id' => $contact->id,
    'location' => 'Conference Room A'
]);
Sales Reports
phpuse App\Models\Deal;
use Carbon\Carbon;

// Monthly revenue report
$monthlyRevenue = Deal::selectRaw('
        DATE_FORMAT(closed_at, "%Y-%m") as month,
        COUNT(*) as deals_won,
        SUM(value) as total_revenue,
        AVG(value) as avg_deal_size
    ')
    ->where('stage', 'won')
    ->whereBetween('closed_at', [
        Carbon::now()->subMonths(12),
        Carbon::now()
    ])
    ->groupBy('month')
    ->orderBy('month', 'desc')
    ->get();

🔌 API Documentation
Authentication
Generate API token:
php$token = auth()->user()->createToken('api-token')->plainTextToken;
Get All Contacts
bashcurl -X GET "https://yourcrm.com/api/contacts" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Accept: application/json"
Response:
json{
  "data": [
    {
      "id": 1,
      "first_name": "John",
      "last_name": "Doe",
      "email": "john@example.com",
      "company": "Acme Corp",
      "status": "active"
    }
  ]
}
Create Contact
bashcurl -X POST "https://yourcrm.com/api/contacts" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Jane",
    "last_name": "Smith",
    "email": "jane@example.com"
  }'
Update Contact
bashcurl -X PUT "https://yourcrm.com/api/contacts/1" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "+1111111111"
  }'

🧪 Testing
Run the complete test suite:
bashphp artisan test
Run with coverage report:
bashphp artisan test --coverage
Run specific test:
bashphp artisan test tests/Feature/ContactTest.php

🤝 Contributing
We welcome contributions from the community!
How to Contribute

Fork the repository
Create a feature branch

bash   git checkout -b feature/amazing-feature

Commit your changes

bash   git commit -m 'Add some amazing feature'

Push to the branch

bash   git push origin feature/amazing-feature

Open a Pull Request

Contribution Guidelines

Follow PSR-12 coding standards
Write tests for new features
Update documentation as needed
Keep commits clean and descriptive


🐛 Bug Reports
If you find a bug, please create an issue with:

Clear title and description
Steps to reproduce
Expected vs actual behavior
Screenshots (if applicable)
Environment details


🔒 Security
If you discover a security vulnerability, please send an email to:
security@yourcrm.com
Do NOT create a public GitHub issue for security vulnerabilities.

📄 License
This project is licensed under the MIT License - see the LICENSE file for details.

👥 Team

Your Name - Lead Developer - @yourusername


📞 Support
Need help? Reach out to us:

📧 Email: support@yourcrm.com
💬 Discord: Join our community
🐦 Twitter: @yourcrm
📖 Documentation: docs.yourcrm.com


🙏 Acknowledgments

Laravel - The PHP Framework for Web Artisans
Tailwind CSS - A utility-first CSS framework
Heroicons - Beautiful hand-crafted SVG icons


<div align="center">
⭐ Star this repository if you find it helpful!
Made with ❤️ by [Your Team Name]
Website • Demo • Docs
