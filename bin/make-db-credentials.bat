@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0make-db-credentials.sh
sh "%BIN_TARGET%" %*
