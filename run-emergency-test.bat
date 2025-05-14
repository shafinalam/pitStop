@echo off
echo ==========================================
echo EMERGENCY EMAIL TEST (Windows)
echo ==========================================
echo.

REM Get email address from user if not provided
set EMAIL=%1
if "%EMAIL%"=="" (
    set /p EMAIL=Enter email address to test (or press Enter for test@example.com): 
    if "%EMAIL%"=="" set EMAIL=test@example.com
)

echo.
echo Running emergency email test to %EMAIL%
echo.

php emergency-mailtrap-test.php "%EMAIL%"

echo.
echo ==========================================
echo Test complete. Check Mailtrap inbox.
echo ==========================================

pause 