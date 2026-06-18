CREATE DATABASE IF NOT EXISTS certificados_db;
USE certificados_db;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS certificados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_hash VARCHAR(64) NOT NULL UNIQUE,
    codigo VARCHAR(20) NOT NULL,
    student_name VARCHAR(255) NOT NULL,
    course_name VARCHAR(255) NOT NULL,
    issue_date DATE NOT NULL,
    issue_location VARCHAR(100) DEFAULT 'Lima',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert the dummy data used in the project
INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    '6FD2D9B4CFE23B8BA7A3D564313D8881',
    '406394',
    'Santur Mogollón, Joseph',
    'FUNCIONES Y RESPONSABILIDADES DEL OPERADOR CCTV',
    '2026-04-30',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    '91B86BE358ABF400D2A8A003D1D7BE8C',
    '406245',
    'Santur Mogollón, Joseph',
    'MONITOREO Y GPS',
    '2026-04-23',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    '279729107C9657E850DB9C9FA22EF1D4',
    '406340',
    'Santur Mogollón, Joseph',
    'VIGILANCIA Y SEGURIDAD CON DRONES',
    '2026-04-25',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    '72D9C27847579233E6AC4CE8831F872C',
    '406636',
    'Santur Mogollón, Joseph',
    'GERENCIA EN SEGURIDAD CIUDADANA',
    '2026-05-02',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    '0469A9DC4F08F2B02421D78B45651C1A',
    '407020',
    'Santur Mogollón, Joseph',
    'PRIMEROS AUXILIOS PARA PERSONAL DE SEGURIDAD',
    '2026-05-21',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    'D0F06A06670C92B8692E9C48BD380418',
    '405077',
    'Santur Mogollón, Joseph',
    'OPERACIONES EN CENTRO DE CONTROL',
    '2026-03-14',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    'A11F8B633ABEBA3AE08DC76399BBD389',
    '405910',
    'Santur Mogollón, Joseph',
    'SEGURIDAD ELECTRÓNICA',
    '2026-04-11',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    'AA74B1B81CF3ED1AF7D00385856EF9F6',
    '406015',
    'Santur Mogollón, Joseph',
    'SEGURIDAD PATRIMONIAL',
    '2026-04-16',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    '17C1BFBF1BFFAB1A3B872C88EF33660A',
    '406110',
    'Santur Mogollón, Joseph',
    'SEGURIDAD CIUDADANA MUNICIPAL',
    '2026-04-11',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    '6CA497F86979E96FBB893F06DBB60A46',
    '406810',
    'Santur Mogollón, Joseph',
    'USO DE LA VIDEOVIGILANCIA EN LA SEGURIDAD CIUDADANA',
    '2026-05-14',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES (
    'C5311E4CABECB4B70FF6C0C4BA8F840A',
    '406920',
    'Santur Mogollón, Joseph',
    'SEGURIDAD, SALUD OCUPACIONAL Y MEDIO AMBIENTE (SSOMA)',
    '2026-05-16',
    'Lima'
)
ON DUPLICATE KEY UPDATE
    codigo = VALUES(codigo),
    student_name = VALUES(student_name),
    course_name = VALUES(course_name);
