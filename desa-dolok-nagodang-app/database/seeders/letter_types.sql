INSERT INTO desa.letter_types
(id, name, code, description, template_file, is_active, created_at, updated_at)
VALUES
(4, 'Surat Domisili', 'DOM', NULL, 'admin.letters.pdf.domisili', 1, NOW(), NOW()),

(5, 'Surat Keterangan Tidak Mampu', 'SKTM', NULL, 'admin.letters.pdf.sktm', 1, NOW(), NOW()),

(6, 'Surat Yatim', 'YTM', NULL, 'admin.letters.pdf.yatim', 1, NOW(), NOW()),

(7, 'Surat Keterangan Penghasilan Orang Tua', 'SKOT', NULL, 'admin.letters.pdf.skot', 1, NOW(), NOW()),

(8, 'Surat Keterangan Usaha', 'SKU', NULL, 'admin.letters.pdf.usaha', 1, NOW(), NOW());




-- php artisan db:seed --class=AdminUserSeeder