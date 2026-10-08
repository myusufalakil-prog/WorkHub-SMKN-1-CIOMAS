-- =============================================================================
-- WORKHUB SMKN 1 CIOMAS - POSTGRESQL SCHEMA UNTUK SUPABASE
-- "Connect. Collaborate. Create."
-- 
-- CARA PENGGUNAAN:
-- 1. Buka dashboard Supabase (https://supabase.com/dashboard)
-- 2. Pilih Project Anda -> Klik menu "SQL Editor" di sidebar kiri
-- 3. Klik "+ New Query", paste seluruh kode di bawah ini, lalu klik "Run"
-- =============================================================================

-- 1. Tabel Jurusan (5 Jurusan SMKN 1 Ciomas)
CREATE TABLE IF NOT EXISTS jurusans (
    id BIGSERIAL PRIMARY KEY,
    kode VARCHAR(20) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    color_accent VARCHAR(50) DEFAULT '#111111',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel Users (Siswa, OSIS, Guru, Admin)
CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'siswa',
    nisn_nip VARCHAR(30) NULL,
    kelas VARCHAR(30) NULL,
    jurusan_id BIGINT NULL REFERENCES jurusans(id) ON DELETE SET NULL,
    jabatan VARCHAR(100) NULL,
    bio TEXT NULL,
    avatar VARCHAR(255) NULL,
    phone VARCHAR(25) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 3. Autentikasi & Sesi
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL REFERENCES users(id) ON DELETE CASCADE,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL
);

CREATE TABLE IF NOT EXISTS cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INT NOT NULL
);

CREATE TABLE IF NOT EXISTS cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);

CREATE TABLE IF NOT EXISTS jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INT NULL,
    available_at INT NOT NULL,
    created_at INT NOT NULL
);

-- 4. Tabel Skills (Keahlian)
CREATE TABLE IF NOT EXISTS skills (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    category VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_skills (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    skill_id BIGINT NOT NULL REFERENCES skills(id) ON DELETE CASCADE,
    level VARCHAR(30) DEFAULT 'Menengah',
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 5. Tabel Proyek Kolaborasi
CREATE TABLE IF NOT EXISTS projects (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    lead_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    guru_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    target_members INT DEFAULT 5,
    deadline DATE NULL,
    progress INT DEFAULT 0,
    status VARCHAR(30) DEFAULT 'Sedang Berjalan',
    category VARCHAR(50) DEFAULT 'Umum',
    is_showcase BOOLEAN DEFAULT FALSE,
    notes_guru TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS project_jurusans (
    id BIGSERIAL PRIMARY KEY,
    project_id BIGINT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
    jurusan_id BIGINT NOT NULL REFERENCES jurusans(id) ON DELETE CASCADE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS project_members (
    id BIGSERIAL PRIMARY KEY,
    project_id BIGINT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    role_in_project VARCHAR(50) DEFAULT 'Member',
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 6. Tabel Tugas (Tasks) & Workspace
CREATE TABLE IF NOT EXISTS tasks (
    id BIGSERIAL PRIMARY KEY,
    project_id BIGINT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    assignee_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    priority VARCHAR(20) DEFAULT 'Sedang',
    status VARCHAR(20) DEFAULT 'todo',
    due_text VARCHAR(50) NULL,
    due_date DATE NULL,
    verified_by_guru BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS project_files (
    id BIGSERIAL PRIMARY KEY,
    project_id BIGINT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
    uploader_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NULL,
    size VARCHAR(30) DEFAULT '1.0 MB',
    type VARCHAR(30) DEFAULT 'Document',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS project_activities (
    id BIGSERIAL PRIMARY KEY,
    project_id BIGINT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    action VARCHAR(255) NOT NULL,
    target VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS project_messages (
    id BIGSERIAL PRIMARY KEY,
    project_id BIGINT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    message TEXT NOT NULL,
    attachment VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 7. Tabel Notifikasi
CREATE TABLE IF NOT EXISTS notifications (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    "desc" TEXT NOT NULL,
    icon VARCHAR(30) DEFAULT 'bell',
    status VARCHAR(20) DEFAULT 'unread',
    action_text VARCHAR(255) NULL,
    action_url VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 8. Prestasi & Portofolio Siswa
CREATE TABLE IF NOT EXISTS student_achievements (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    issuer VARCHAR(255) NOT NULL,
    year VARCHAR(10) NOT NULL,
    verified_by_guru_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS student_portfolios (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    year VARCHAR(10) NOT NULL,
    "desc" TEXT NOT NULL,
    verified_by_guru_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 9. Agenda & Event OSIS Sekolah
CREATE TABLE IF NOT EXISTS school_events (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date_text VARCHAR(255) NOT NULL,
    status VARCHAR(255) DEFAULT 'Open Registrasi',
    "desc" TEXT NULL,
    lead VARCHAR(255) NULL,
    participants_info VARCHAR(255) NULL,
    category VARCHAR(255) DEFAULT 'Festival Sekolah',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

-- 10. Tabel Migrations (Mencegah konflik saat Laravel mengecek status migrasi)
CREATE TABLE IF NOT EXISTS migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
);

INSERT INTO migrations (migration, batch) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_10_01_000001_create_jurusans_table', 1),
('2026_10_01_000002_add_role_and_profile_to_users_table', 1),
('2026_10_01_000003_create_skills_table', 1),
('2026_10_01_000004_create_projects_table', 1),
('2026_10_01_000005_create_tasks_table', 1),
('2026_10_01_000006_create_project_files_activities_messages_table', 1),
('2026_10_01_000007_create_notifications_table', 1),
('2026_10_01_000008_create_achievements_and_portfolios_table', 1),
('2026_10_01_000009_create_school_events_table', 1)
ON CONFLICT DO NOTHING;

-- =============================================================================
-- DATA AWAL (SEEDER) - 5 JURUSAN RESMI, SKILLS, & AKUN DEMO
-- Password default semua akun adalah: password
-- Hash Bcrypt: $2y$12$NqKkUjS3qQj5P9gP8pI2u.3qK0zL1E2L7mB5r4o8YkH3x1v9u6vCe
-- =============================================================================

-- Master Jurusan
INSERT INTO jurusans (id, kode, nama_lengkap, deskripsi, color_accent) VALUES
(1, 'PPLG', 'Pengembangan Perangkat Lunak dan Gim', 'Rekayasa perangkat lunak, web engineering, mobile app, dan game dev.', '#111111'),
(2, 'BCF', 'Broadcasting dan Perfilman', 'Produksi video, sinematografi, audio sound design, dan live streaming.', '#222222'),
(3, 'Animasi', 'Animasi 3D & 2D', '3D asset modeling, rigging karakter, motion graphic, dan visual effects.', '#181818'),
(4, 'TO', 'Teknik Otomotif', 'Pemeliharaan mesin kendaraan, kelistrikan otomotif, chasis, dan sistem EFI.', '#111111'),
(5, 'TPFL', 'Teknik Pengelasan dan Fabrikasi Logam', 'Pengelasan SMAW/GMAW/GTAW, perancangan plat logam, dan fabrikasi presisi.', '#181818')
ON CONFLICT (id) DO NOTHING;

-- Master Skills
INSERT INTO skills (id, name, category) VALUES
(1, 'Frontend Web & UI', 'Code'),
(2, 'Backend & Database', 'Code'),
(3, 'Game Development', 'Code'),
(4, 'Sinematografi & Kamera', 'Media'),
(5, 'Video Editing & Audio', 'Media'),
(6, '3D Blender & Rigging', 'Design'),
(7, '2D Motion & Animasi', 'Design'),
(8, 'Diagnosis Mesin Otomotif', 'Teknik'),
(9, 'Kelistrikan & EFI Otomotif', 'Teknik'),
(10, 'Pengelasan SMAW / GMAW', 'Manufaktur'),
(11, 'Fabrikasi Logam & Desain CAD', 'Manufaktur')
ON CONFLICT (id) DO NOTHING;

-- Akun User Utama (Password: password)
-- Password Hash di bawah valid untuk Laravel bcrypt: 'password'
INSERT INTO users (id, name, email, password, role, kelas, jurusan_id, jabatan, bio, phone) VALUES
(1, 'Super Administrator', 'admin@gmail.com', '$2y$10$oOGsXCmsDDtV3qUrAjDch.GDA5uH1Q7tV4EZ2PKk7NgQA57n9/3Zm', 'admin', 'Staff IT', 1, 'Administrator Sistem', 'Akun administrator dengan hak akses penuh ke portal Siswa dan OSIS.', '081122334455'),
(2, 'Pengurus OSIS', 'osis@gmail.com', '$2y$10$oOGsXCmsDDtV3qUrAjDch.GDA5uH1Q7tV4EZ2PKk7NgQA57n9/3Zm', 'osis', 'XI PPLG 2', 1, 'Divisi IT & Acara OSIS', 'Pengurus OSIS SMK. Mengoordinasikan event festival tahunan dan kurasi showcase proyek kolaborasi.', '081298765432'),
(3, 'Raka Pratama', 'raka@gmail.com', '$2y$10$oOGsXCmsDDtV3qUrAjDch.GDA5uH1Q7tV4EZ2PKk7NgQA57n9/3Zm', 'siswa', 'XII PPLG 1', 1, 'Fullstack Developer', 'Siswa PPLG antusias berkolaborasi membangun aplikasi nyata dengan teman lintas jurusan Animasi, BCF, TO, dan TPFL.', '081234567890')
ON CONFLICT (id) DO NOTHING;

-- Hubungkan Skill Siswa Raka
INSERT INTO user_skills (user_id, skill_id, level, is_verified) VALUES
(3, 1, 'Mahir', true),
(3, 2, 'Menengah', true)
ON CONFLICT DO NOTHING;

-- Event Awal OSIS
INSERT INTO school_events (title, date_text, status, "desc", lead, participants_info, category) VALUES
('Ciomas Tech & Creative Expo 2026', '24 - 26 Oktober 2026', 'Open Registrasi', 'Pameran karya inovasi lintas keahlian siswa SMKN 1 Ciomas.', 'Pengurus OSIS SMKN 1 Ciomas', 'Terbuka untuk Semua Jurusan', 'Festival Tahunan Sekolah')
ON CONFLICT DO NOTHING;

-- Reset Sequence PostgreSQL agar ID baru tidak bentrok
SELECT setval('jurusans_id_seq', (SELECT MAX(id) FROM jurusans));
SELECT setval('skills_id_seq', (SELECT MAX(id) FROM skills));
SELECT setval('users_id_seq', (SELECT MAX(id) FROM users));
