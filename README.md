Internet.bs API
==============

This is an PHP Client for Internet.bs domain registrar api. 
This package is also bundled to work as an laravel 4 module, but you can use it with any framework or standalone at all.

#### Create the Api object

````php
use Softservlet\Internetbs\Api;
use Softservlet\Internetbs\Request\HttpRequest;

//The api credentials
$apiKey = 'testapi';
$passwd = 'testpass';
//We will use the test api in this example
$test = true;

$api = new Api(new HttpRequest($apiKey, $passwd, $test));
````

#### Make an simple api request

The api requests are made by the `request()` method of the api object.
It accepts as parameters the api verb and the data to be passed to the request.
It returns the response as an array.
For full documentation of the api verbs (calls) please visit the internet.bs api docs.

````php
$response = $api->request('Domain/Check', array(
		'Domain' => 'github.com'
));

echo $response['status']; //this will display 'UNAVAILABLE'
````

### Using the Command class for requests

Commands are a more organised way to make an api request.
Instead of passing lot of parameters to the `request()` method, we just can create a command to handle the request that we need.
This also helps when you have to do difficult tasks like creating a domain.

#### Create a new command

A command must implement the `Softservlet\Commands\CommandInterface` interface.

````php
use Softservlet\Internetbs\Commands\CommandInterface;

class DomainCheck implements CommandInterface
{

	protected $domain;

	public function __construct($domain) 
	{
		$this->domain = $domain;
	}


	/**
	 * This method returns the api verb (call)
	 * that should be requested/executed by the command
	 */
	public function getPath()
	{
		return 'Domain/Check';
	}
	
	/**
	 * This method returns the data that should be passed
	 * to the api call
	 */
	public function run()
	{
		return array('Domain' => $this->domain);	
	}
}
````

#### Using the command

````php
$response = $api->run(new DomainCheck('github.com'));

echo $response['status']; //this will display 'UNAVAILABLE'
````

#### The DomainCreate command

This package has implemented the task for `Domain/Create` api call. Feel free to fork this package and contribute by adding more commands.

````php
$command = new DomainCreate('the-domain-to-register.com');
````

Now let's say that the person who register the domain has the following details: 

````php
$contactPerson = array(
				'FirstName' => 'Benjamin',
				'LastName' => 'Dawson',
				'Email'	=> 'owner@name.com',
				'Street' => '1865 Shadowmar Drive',
				'CountryCode' => 'RO',
				'PostalCode' => '220099',
				'City' => 'Bucharest'	
);
````

Then we can add this person as the `Registrant` person.

```php
$command->addContact('Registrant', $contactPerson);
````

But the most of TLDs requires contact persons for roles  like `Registrant`, `Admin`, `Technical`, `Billing`, etc.
So we can use the following way to add the same person with multiple roles.

````php
$roles = array(
	'Registrant',
	'Admin',
	'Technical',
	'Billing'
);

$command->addContact($roles, $contactPerson);
````

The PhoneNumber filed requires special formatting, so you will need to call the following method for it: 

````php
$command->addPhoneNumber('Registrant', '+1', '310-716-7152');
//or
$command->addPhoneNumber($roles, '+1', '310-716-7152');
````

This commands extends the `AbstractCommand` class wich provides methods for setting and getting custom data for the api parameters, so if you need to add custom data, depending on which domain tld you want to register, just use:

````php
$command->setData('my_custom_data', 'my_value');

$command->getData('my_custom_data');
````

Finally, just run the command

````php
$api->run($command);
````

For the response documentation visit the internet.bs api website.


