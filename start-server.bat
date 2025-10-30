
@echo off
echo Starting Laravel Development Server...
echo.
echo Server will be available at: http://0.0.0.0:8000
echo Press Ctrl+C to stop the server
echo.

cd /d "c:\DepDev_NEDA"
php artisan serve --host=0.0.0.0 --port=8000

pause
