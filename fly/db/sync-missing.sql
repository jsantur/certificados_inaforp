-- Sincroniza certificados faltantes en producción (idempotente).
USE certificados_db;

INSERT INTO certificados (key_hash, codigo, student_name, course_name, issue_date, issue_location)
VALUES
    ('A11F8B633ABEBA3AE08DC76399BBD389', '405910', 'Santur Mogollón, Joseph', 'SEGURIDAD ELECTRÓNICA', '2026-04-11', 'Lima'),
    ('AA74B1B81CF3ED1AF7D00385856EF9F6', '406015', 'Santur Mogollón, Joseph', 'SEGURIDAD PATRIMONIAL', '2026-04-16', 'Lima'),
    ('17C1BFBF1BFFAB1A3B872C88EF33660A', '406110', 'Santur Mogollón, Joseph', 'SEGURIDAD CIUDADANA MUNICIPAL', '2026-04-11', 'Lima'),
    ('6CA497F86979E96FBB893F06DBB60A46', '406810', 'Santur Mogollón, Joseph', 'USO DE LA VIDEOVIGILANCIA EN LA SEGURIDAD CIUDADANA', '2026-05-14', 'Lima'),
    ('C5311E4CABECB4B70FF6C0C4BA8F840A', '406920', 'Santur Mogollón, Joseph', 'SEGURIDAD, SALUD OCUPACIONAL Y MEDIO AMBIENTE (SSOMA)', '2026-05-16', 'Lima')
ON DUPLICATE KEY UPDATE
    student_name = VALUES(student_name),
    course_name = VALUES(course_name),
    issue_date = VALUES(issue_date),
    issue_location = VALUES(issue_location);
