# XKCD Comic Digest System 📬

This project fetches a random comic from the [XKCD API](https://xkcd.com/json.html) and sends it to subscribed users via email. Users can subscribe using their email ID and receive a verification code. A scheduled cron job ensures a comic is sent to all subscribers daily at 9:00 AM.

---

## 🚀 Features

- 🔐 Email verification system using unique 6-digit codes  
- 📩 Sends HTML-formatted emails containing XKCD comics  
- 💌 Local testing with MailHog (no real email server required)  
- ❌ Secure unsubscription flow with code-based verification  
- ⏰ Automated daily sending using cron + bash  
- 🗂️ File-based user management (lightweight, no database)

---

## 🧰 Tech Stack

| Tech              | Use Case                                  |
|-------------------|--------------------------------------------|
| **PHP**           | Core application logic                     |
| **MailHog**       | Local email testing                        |
| **Bash**          | Automating cron job setup                  |
| **Cron**          | Schedule email digest daily                |
| **HTML/CSS**      | Email formatting and basic frontend forms  |

---

## 📁 Project Structure

```
xkcd-project/
│
├── src/
│   ├── index.php               # Registration form (subscribe)
│   ├── unsubscribe.php         # Unsubscribe + verification form
│   ├── functions.php           # Core logic: mail, verification, XKCD API
│   └── codes/                  # Temporary files storing verification codes
│
├── registered_emails.txt       # Stores list of subscribers
├── cron.php                    # Sends XKCD comic to all subscribers
├── setup_cron.sh               # Bash script to set up the cron job
```

---

## 🖥️ How to Run Locally

1. **Install XAMPP** or any PHP server
2. **Clone this repo** and place it in your `htdocs` folder (if using XAMPP)
3. **Install MailHog**  
   - Run MailHog:  
     ```
     mailhog
     ```
   - Visit: [http://localhost:8025](http://localhost:8025)
4. **Open project in browser**  
   - Go to: [http://localhost/xkcd-project/src/index.php](http://localhost/xkcd-project/src/index.php)
5. **Set up cron job (Linux/macOS)**  
   ```bash
   bash setup_cron.sh
   ```

---

## 🧪 Testing

- After subscribing, check MailHog inbox for the verification code.
- Enter the code to confirm your subscription.
- Cron will trigger `cron.php` daily at 9:00 AM (or run it manually to test).

---

## ❓ Future Improvements

- Replace file-based storage with a database (MySQL or PostgreSQL)
- Dockerize the entire stack
- Add admin panel to view or remove subscribers
- UI improvements and animations

---

## 📬 Contact

If you liked this project or want to contribute, feel free to connect:

- [LinkedIn](https://linkedin.com/in/snarip)
- [GitHub](https://github.com/thequantumn)

---

> Inspired by the humor and simplicity of XKCD — bringing comics to your inbox.
