Web Application Security - Assignment 2

Task 1: Multi-Factor Authentication (MFA)
- Install and configure Laravel Fortify.
- Implemented MFA for user login.
- Email-based 2FA with random codes sent to the user's email.
- The MFA code expires after 10 minutes, and users must enter the correct code to proceed with login.
- Files added: two-factor-code.blade.php (email template), two-factor-challenge.blade.php (code input form), TwoFactorCodeMail
- Controllers created: Two Factor Controller, Authenticated Session Controller
- Add migrations: 2 files (useful but for different systems)
- 1st; custom fields for a manually generated 6-digit code, email-based 2FA without Fortify’s built-in
- 2nd; used by Laravel Fortify’s built-in 2FA (TOTP apps like Google Authenticator)

Task 2: Strong Password Hashing
- Implemented password hashing using Argon2id.
- The password is now hashed with Argon2id after concatenating a randomly generated salt with the password.
- Files created: hashing.php (use Argon2 as default), fortify.php

Task 3: Rate Limiting for Failed Login Attempts
- Add Laravel RateLimiter library/package.
- Implemented rate limiting for failed login attempts to prevent brute-force attacks.
- The rate limiter ensures that a user can only attempt to log in 3 times within a 1-minute period.
- If a user exceeds the allowed attempts, they receive a message indicating they must wait 1 minute before retrying.
- The login attempt counter is cleared once a successful login is achieved.
- Files modified: Authenticated Session Controller
  
Task 4: Salt Implementation for Passwords
- Generated a random unique salt for each user upon registration and added it to the users table.
- The salt is used in combination with the password to generate the hashed password.
- Actually Argon2id already includes a built-in salt, but we just add our custom salt.
- The salt is stored in the salt column of the users' table and is concatenated with the password before hashing.
- Files modified; Register Controller (generate random salt), User Model (store the salt in the users table), Authenticated Session Controller (modify authentication logic to check password + salt)
