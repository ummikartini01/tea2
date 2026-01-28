# 🚀 Railway Deployment Guide for Tea Reminder App

## 📋 STEP-BY-STEP DEPLOYMENT

### ✅ STEP 1: PREPARE YOUR REPOSITORY
1. Make sure all your code is committed to Git
2. Push your latest changes to GitHub
3. Ensure you have the railway.toml file

### ✅ STEP 2: CREATE RAILWAY ACCOUNT
1. Go to [railway.app](https://railway.app)
2. Click "Sign up with GitHub"
3. Authorize Railway to access your GitHub
4. You'll get $5 free credit automatically

### ✅ STEP 3: CREATE NEW PROJECT
1. In Railway dashboard, click "New Project"
2. Click "Deploy from GitHub repo"
3. Find your tea2 repository
4. Click "Import Repo"

### ✅ STEP 4: CONFIGURE SERVICES
Railway will automatically detect your Laravel app and create:
- **Web Service**: Your main application
- **PostgreSQL Database**: Built-in database
- **Worker Service**: Background tea reminders

### ✅ STEP 5: SET UP ENVIRONMENT VARIABLES
Add these environment variables in Railway:

#### Database Variables:
```
DB_CONNECTION=pgsql
DB_HOST=${RAILWAY_PRIVATE_DOMAIN}
DB_PORT=5432
DB_DATABASE=${RAILWAY_ENVIRONMENT}
DB_USERNAME=${RAILWAY_ENVIRONMENT}
DB_PASSWORD=${RAILWAY_ENVIRONMENT}
```

#### App Variables:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-app-key-here
APP_URL=${RAILWAY_PUBLIC_DOMAIN}
TELEGRAM_BOT_TOKEN=your-telegram-bot-token
```

### ✅ STEP 6: RUN MIGRATIONS
1. Go to your web service in Railway
2. Click "Logs" tab
3. Click "Exec" button
4. Run: `php artisan migrate --force`
5. Run: `php artisan db:seed --force` (if you have seeders)

### ✅ STEP 7: VERIFY DEPLOYMENT
1. Your app will be available at: `https://your-app-name.up.railway.app`
2. Test health check: `https://your-app-name.up.railway.app/health`
3. Should return: `{"status":"healthy","app":"Tea Reminder App"}`

### ✅ STEP 8: SET UP WORKER FOR AUTOMATIC REMINDERS
The worker service will automatically run:
- Command: `php artisan tea:continuous-reminders`
- Runs 24/7 in background
- Sends automatic tea reminders

## 🎯 WHAT WORKS ON RAILWAY

### ✅ Automatic Features:
- **Database**: PostgreSQL with automatic backups
- **SSL**: HTTPS certificate included
- **Domain**: Free subdomain provided
- **Workers**: Background processes for reminders
- **Logging**: Built-in log viewing
- **Monitoring**: Health checks and metrics

### ✅ Your Tea App Features:
- **User registration/login**
- **Tea timetable creation**
- **Automatic reminders** (via worker)
- **Telegram notifications**
- **5-minute notification window**
- **All existing functionality**

## 🚨 TROUBLESHOOTING

### ❌ If Migration Fails:
1. Check database connection string
2. Verify environment variables
3. Run `php artisan config:clear`

### ❌ If Worker Doesn't Start:
1. Check worker logs
2. Verify ContinuousReminders command exists
3. Ensure all dependencies are installed

### ❌ If App Doesn't Load:
1. Check web service logs
2. Verify health check endpoint
3. Check APP_URL configuration

## 🎉 SUCCESS INDICATORS

### ✅ When Everything Works:
- Web service shows "Running" status
- Database shows "Running" status  
- Worker shows "Running" status
- Health check returns "healthy"
- Automatic reminders send to Telegram

## 📊 COST BREAKDOWN

### ✅ Free Tier ($5/month credit):
- Web service: ~$2/month
- Database: ~$1/month  
- Worker: ~$1/month
- **Total: $0 (covered by free credit)**

## 🎯 NEXT STEPS AFTER DEPLOYMENT

1. **Test your app** thoroughly
2. **Create test tea timetables**
3. **Verify automatic reminders work**
4. **Check Telegram notifications**
5. **Monitor worker logs**

## 🎊 CONGRATULATIONS!

Your tea reminder app is now:
- ✅ Live on the internet
- ✅ Working 24/7 automatically
- ✅ Sending tea reminders
- ✅ Professional hosting
- ✅ Completely free

Enjoy your deployed tea reminder app! 🍵✨
