Registration & Login Pages

When user's enter the URL, first-time user need to register meanwhile other users can login which will direct them to the login page.

Implement input validation for Registration (resources/views/auth/register.blade.php) and Login (resources/views/auth/login.blade.php) Pages using Laravel Form Request Classes 
- Created two request classes; LoginRequest and RegisterRequest at different files (stored in app/Http/Requests)
- Using Laravel regex validation rules as a whitelist for the required inputs (email, name and password) to improve security and data consistency
- Using this regex validation at the rules() method and removed the default validation
- When user submits their form to register, it will be validate to satisfy data type and min/max rules;
      Name- string, max 255
      Email- email, must be unique
      Password- string, min 8, match with password_confirmation
      & all these are required/ cannot be NULL

Profile Page
- Created a new view (resources/views/profile/editprofile.blade.php) for users to update their profile
- Added its dropdown option in the top navigation bar to access the editprofile
- Modify the users model (User Table in the Database) by adding the following attributes; 
      Nickname, Avatar/Profile Picture, email, password, phone number, city (Allow user to edit all of these)
  When user submits their form, it will be validate using update function to satisfy data type and min/max rules;
      Nickname- string, max 255
      Email- email, must be unique
      Phone number- string, max 20
      City- string, max 255
      Avatar- image file, max 2048
      Password- string, min 8, match with password_confirmation
- For the nickname, it's displayed at the top navigation bar once user update their nickname to replace default name
- Added a Delete Account Function which will allow user to remove their record from the database (user model) permanently
