# Full-Login-System-Full-CRUD

Stuff its missing atm.

my online server: http://universe6.com/Full-Login-System/registration.php
----------------------------------------------
Need help on:
1. Not displaying this only when fails: ```Registration failed. Email or Username already exits please try again.```
2. Registration accept all if you, password and email ex: fish@+1 letter is enough and just 1 letter on username and if click register it register it ( meaning rest of fields it ignore )
3. Password Hasing and rehashing missing ( atm just using sha1 )
4. class.user.php line 107 & 113 got  or die($this->db->error); i believe thats bad.
5. errror message need to be showed if username taken
6. email: i dont want that automatic popup saying you need @ on your email, i want it to just follow my error message.

Important files atm is: 

registration.php
class.user.php
