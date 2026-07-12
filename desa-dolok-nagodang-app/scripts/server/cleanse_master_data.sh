#!/bin/bash

set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
SQL_FILE="$PROJECT_DIR/database/maintenance/cleanse_master_data.sql"

DB_SERVICE="${DB_SERVICE:-db}"
DB_NAME="${DB_NAME:-desa}"
DB_USER="${DB_USER:-root}"
DB_PASSWORD="${DB_PASSWORD:-root}"

echo "==================================="
echo "CLEANSING MASTER DATA DESA"
echo "==================================="
echo "Project dir : $PROJECT_DIR"
echo "SQL file    : $SQL_FILE"
echo "DB service  : $DB_SERVICE"
echo "DB name     : $DB_NAME"
echo ""
echo "Tabel yang akan dibersihkan:"
echo "- letter_details"
echo "- letters"
echo "- citizens"
echo "- news"
echo "- assets"
echo "- infrastructures"
echo ""
echo "Folder file upload yang akan dibersihkan:"
echo "- storage/app/public/news"
echo "- storage/app/public/assets"
echo "- storage/app/public/infrastructure"
echo "- storage/app/public/citizens"
echo ""

read -r -p "Lanjutkan proses cleansing? ketik YES untuk lanjut: " CONFIRM

if [[ "$CONFIRM" != "YES" ]]; then
    echo "Dibatalkan."
    exit 1
fi

cd "$PROJECT_DIR"

echo ""
echo "1. Jalankan cleansing database..."
docker compose exec -T "$DB_SERVICE" sh -lc "mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME" < "$SQL_FILE"

echo ""
echo "2. Bersihkan file upload..."
mkdir -p storage/app/public/news \
         storage/app/public/assets \
         storage/app/public/infrastructure \
         storage/app/public/citizens

find storage/app/public/news -mindepth 1 -delete
find storage/app/public/assets -mindepth 1 -delete
find storage/app/public/infrastructure -mindepth 1 -delete
find storage/app/public/citizens -mindepth 1 -delete

echo ""
echo "3. Refresh cache Laravel..."
docker compose exec -T app php artisan optimize:clear

echo ""
echo "==================================="
echo "CLEANSING SELESAI"
echo "==================================="
