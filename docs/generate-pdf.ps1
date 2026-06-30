# Generate PDF from documentation (requires Node.js)
# Usage: .\docs\generate-pdf.ps1

Set-Location $PSScriptRoot\..

Write-Host "Generating PDF from docs/WEEKLY-REWARD-DRAW-SYSTEM.md ..."
Write-Host "This may take a few minutes on first run (downloads Chromium)."

npx --yes md-to-pdf "docs/WEEKLY-REWARD-DRAW-SYSTEM.md"

if (Test-Path "docs/WEEKLY-REWARD-DRAW-SYSTEM.pdf") {
    Write-Host "Success: docs/WEEKLY-REWARD-DRAW-SYSTEM.pdf"
} else {
    Write-Host "PDF not created. Alternative: open the .md file in VS Code, preview, and Print to PDF."
}
