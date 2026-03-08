-- WebSecService: Missing SQL for roles/access and exam storage
USE websec_db;

-- 1) Ensure users.role exists
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS role VARCHAR(50) NOT NULL DEFAULT 'student';

-- 2) Normalize existing users roles by email
UPDATE users SET role = 'admin' WHERE email IN ('admin@sut.edu.eg', 'admin@websec.com');
UPDATE users SET role = 'instructor' WHERE email IN ('instructor@sut.edu.eg', 'instructor@websec.com');
UPDATE users SET role = 'student' WHERE role IS NULL OR role = '';

-- 3) Optional: create default lab3 login accounts if not exists
INSERT INTO users (name, email, password, role, created_at, updated_at)
SELECT 'Lab3 Admin', 'admin@websec.com', '$2y$12$w0j3nRZ6Ww8r5Sg3Yv4y8eq7LQ7gV9xJk5m0JzjQ3xQ2l4K1hQ7aK', 'admin', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'admin@websec.com');

INSERT INTO users (name, email, password, role, created_at, updated_at)
SELECT 'Lab3 Instructor', 'instructor@websec.com', '$2y$12$w0j3nRZ6Ww8r5Sg3Yv4y8eq7LQ7gV9xJk5m0JzjQ3xQ2l4K1hQ7aK', 'instructor', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'instructor@websec.com');

INSERT INTO users (name, email, password, role, created_at, updated_at)
SELECT 'Lab3 Student', 'student@websec.com', '$2y$12$w0j3nRZ6Ww8r5Sg3Yv4y8eq7LQ7gV9xJk5m0JzjQ3xQ2l4K1hQ7aK', 'student', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'student@websec.com');

-- 4) Ensure exam_attempts table exists for exam scores
CREATE TABLE IF NOT EXISTS exam_attempts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    score INT UNSIGNED NOT NULL,
    total_questions INT UNSIGNED NOT NULL,
    percentage DECIMAL(5,2) NOT NULL,
    answers JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_exam_attempts_user_id (user_id)
);

-- 5) Optional quick check
SELECT id, name, email, role FROM users ORDER BY id DESC;
SELECT id, user_id, score, total_questions, percentage, created_at FROM exam_attempts ORDER BY id DESC;
