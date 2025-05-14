```markdown
# 🌐 Dynamic Portfolio System

This is a dynamic portfolio website hosted on **Nginx**, featuring:

- 🌗 **Light/Dark Theme Toggle**
- 🧑‍💻 Personal Information dynamically fetched from a **MySQL database**
- 🖼️ Profile picture, bio, skills, and experience
- 🌍 Hosted at: `http://portfolio.auca.ac.rw`

---



---

## 🛠️ Setup Instructions

### 1. 📦 Install Required Software

Ensure the following are installed:

- Nginx
- PHP & PHP-MySQL
- MySQL or MariaDB

```bash
sudo apt update
sudo apt install nginx php php-mysql mysql-server
````

---

### 2. 🛠️ Configure the MySQL Database

Login to MySQL and run:

```sql
CREATE DATABASE portfolio;

USE portfolio;

CREATE TABLE profile (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100),
    profession VARCHAR(100),
    bio TEXT,
    profile_pic VARCHAR(255),
    skills TEXT,
    experience TEXT
);

INSERT INTO profile (full_name, profession, bio, profile_pic, skills, experience)
VALUES (
    'Mugabo Andre',
    'Full-Stack Developer',
    'Passionate about building impactful web applications...',
    'assets/img/profile.jpg',
    'HTML,CSS,JavaScript,PHP,MySQL',
    '3+ years of experience in freelance and academic projects.'
);
```

---

### 3. 🚀 Deploy Files to Web Server

Copy the `portfolio/` directory to your Nginx root (e.g., `/var/www/portfolio`):

```bash
sudo cp -r portfolio /var/www/
```

---

### 4. 🌐 Configure Nginx Virtual Host

Create Nginx config:

```bash
sudo nano /etc/nginx/sites-available/portfolio.auca.ac.rw
```

Add:

```nginx
server {
    listen 80;
    server_name portfolio.auca.ac.rw;

    root /var/www/portfolio;
    index index.html index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Then enable it:

```bash
sudo ln -s /etc/nginx/sites-available/portfolio.auca.ac.rw /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

### 5. 🌗 Light/Dark Theme Toggle

Handled via JavaScript in `script.js`. Toggle changes `data-theme` on the `<html>` element.

```javascript
toggle.addEventListener("change", () => {
  const isDark = toggle.checked;
  document.documentElement.setAttribute("data-theme", isDark ? "dark" : "light");
});
```

---



## 🧑‍💻 Author

**Mugabo Andre**
Software Engineering @ AUCA
GitHub: \[https://github.com/andremugabo]
Email: \[andremugabo@yahoo.fr]

---

## 📄 License

This project is licensed under the MIT License.

if you'd like the README in PDF format, include screenshots, or generate a sample ZIP for submission.