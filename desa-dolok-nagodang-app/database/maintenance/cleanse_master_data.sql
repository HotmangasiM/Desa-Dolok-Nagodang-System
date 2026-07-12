-- Cleansing master data untuk modul:
-- 1. Penduduk (citizens)
-- 2. Berita (news)
-- 3. Inventaris (assets)
-- 4. Infrastruktur / aset pembangunan (infrastructures)
--
-- Catatan:
-- - letters dan letter_details ikut dibersihkan karena letters memiliki foreign key ke citizens.
-- - letter_types, users, complaints, visitor_logs, dan tabel sistem lainnya tidak disentuh.

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM letter_details;
DELETE FROM letters;
DELETE FROM citizens;
DELETE FROM news;
DELETE FROM assets;
DELETE FROM infrastructures;

ALTER TABLE letter_details AUTO_INCREMENT = 1;
ALTER TABLE letters AUTO_INCREMENT = 1;
ALTER TABLE citizens AUTO_INCREMENT = 1;
ALTER TABLE news AUTO_INCREMENT = 1;
ALTER TABLE assets AUTO_INCREMENT = 1;
ALTER TABLE infrastructures AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;
