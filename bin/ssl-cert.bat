@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0ssl-cert.sh
sh "%BIN_TARGET%" %*