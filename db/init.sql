-- Insert User Profile
INSERT INTO user_profile (name, picture, title, about, location, availability)
VALUES (
    'Mugabo Andre',
    'assets/images/profile.jpg',
    'Full Stack Developer',
    'Passionate about building scalable web applications and elegant user interfaces. I specialize in modern JavaScript frameworks and have experience working with diverse teams to deliver high-quality software solutions.',
    'Kigali Rwanda',
    'Open to new opportunities'
)
RETURNING id;



-- Contact
INSERT INTO contact (user_id, email, phone)
VALUES (1, 'andre.mugabo@andremugabo.rw', '(+250)78 316 5626');

-- Socials
INSERT INTO socials (user_id, github, linkedin, twitter, dribbble)
VALUES (
    1,
    'https://github.com/andremugabo',
    'https://www.linkedin.com/in/mugabo-andr%C3%A9-9a1a0774/',
    'https://twitter.com/andremugabo',
    'https://dribbble.com/andremugabo'
);

-- Skills (category + items)
-- Example: Frontend
INSERT INTO skills (user_id, category) VALUES (1, 'frontend') RETURNING id;
-- Suppose returned skill_id = 1
INSERT INTO skills_items (skill_id, skill_name) VALUES
(1, 'JavaScript'), (1, 'TypeScript'), (1, 'React'), (1, 'Next.js'), (1, 'Vue.js');

-- Repeat for backend, database, devops...

-- Experience
INSERT INTO experience (user_id, role, company, duration, details)
VALUES
(1, 'Senior Frontend Developer', 'MA. Coding Lab', '2022–2024',
 'Led the frontend development team in building a scalable SaaS platform. Implemented modern React patterns and optimized performance, resulting in a 40% improvement in load times.'),
(1, 'Full Stack Developer', 'InnovateSoft', '2020–2022',
 'Developed and maintained multiple client projects using the MERN stack. Collaborated with designers to implement responsive UIs and integrated RESTful APIs.'),
(1, 'Junior Web Developer', 'WebSolutions', '2018–2020',
 'Assisted in the development of e-commerce websites. Worked with HTML, CSS, JavaScript, and PHP to implement features and fix bugs.');
