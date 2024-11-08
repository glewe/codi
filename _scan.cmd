:: ============================================================================
::  SonarQube Scan
::  ---------------------------------------------------------------------------
::  Requires a local SonarQube and Sonar Scanner installation.
::  This script expects a sonar-project.properties file in the same directory.
:: ============================================================================
::
@echo off
set year=%date:~0,4%
set month=%date:~5,2%
if "%month:~0,1%" == " " set month=0%month:~1,1%
set day=%date:~8,2%
if "%day:~0,1%" == " " set day=0%day:~1,1%
set hour=%time:~0,2%
if "%hour:~0,1%" == " " set hour=0%hour:~1,1%
set min=%time:~3,2%
if "%min:~0,1%" == " " set min=0%min:~1,1%
set tstamp=%year%%month%%day%%hour%%min%

:: ----------------------------------------------------------------------------
:: Sonar Scan
::
echo ========================================================================= START
echo  %date% %time% =^> Performing a SonarQube scan...
echo -------------------------------------------------------------------------------
echo.
sonar-scanner

echo  Done
echo =========================================================================== END
echo.
echo.
