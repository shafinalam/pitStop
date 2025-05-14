@echo off
echo ============================================
echo Running Mailtrap Connection Test (Windows)
echo ============================================
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
echo Running test script...
echo.

REM Execute the PHP file directly, avoiding any Git Bash character issues
php -f verify-mailtrap.php

echo.
echo ============================================
echo Test completed
echo Check mailtrap-test-log.txt for results
echo ============================================

goto :end

:error
echo Test failed to execute.

:end
pause 