# AntNinjaCrypter
Antware NinjaCrypter is an experimental username and password cookie string encrypter class for PHP meant to encrypt user informations stored on session cookies.
For study case this encrypter is based on password crypting ideology but can also encrypt username and password for storing cookie string that way your login details will not be exposed by hackers that search through cookie string.

#### Functionality
1. The process starts with the accessCreator method which takes in two argument containing the username (email address) and password (string)
The accessCreator method builds the string and returns an encrypted username and password string mash.

2. Second method processing the encrypted string is the accessValidator which works as a validator to check if the crypt string is built properly
If it returns true the string is well encrypted and can now be parsed.

3. Final method is the accessParser which parses the encrypted cookie string containing username and password, returns a seperate strings of both in an array
which you can noww use in your code to automatically remember the user.

#### Method Lists
1. accessCreator
2. accessValidator
3. accessParser

#### Base Class
```new AntNinjaCrypter();```

#### Usage

##### Creating Encrpted String with Username & Password

```
	$minutes = 1440;
	$ninjaCrypter = new NinjaCrypter();
	$encrypted = $ninjaCrypter->accessCreator($user->email, $user->raw_password);
	Cookie::queue(Cookie::make('antuser', $encrypted, $minutes, null, '.antware.com'));
```
	
##### Getting Encrypted Username & Password

```
	$access = Cookie::get('antuser');
	$ninjaCrypter = new NinjaCrypter();
	$userpass = $ninjaCrypter->accessParser($access);
	$username = $userpass[0];
	$password = $userpass[1];

