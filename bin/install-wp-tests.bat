@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0install-wp-tests.sh
sh "%BIN_TARGET%" %*
