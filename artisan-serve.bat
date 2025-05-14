@echo off
echo =============================================
echo Starting Laravel Development Server (Windows)
echo =============================================
echo.

REM Find PHP executable
where php >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo PHP not found in PATH. Please specify the full path to php.exe
    echo Edit this batch file if needed.
    goto :error
)

echo Using PHP from:
where php

echo.
echo Starting Laravel development server...
echo.

REM Execute artisan serve directly
php artisan serve

echo.
echo ============================================
echo Server stopped
echo ============================================

goto :end

:error
echo Failed to start Laravel server.

:end
pause 