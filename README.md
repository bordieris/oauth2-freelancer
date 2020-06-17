# Freelancer Provider for OAuth 2.0 Client

[Freelancer](https://www.freelancer.com/) OAuth 2.0 support for the PHP League’s [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

```
$ composer require bordieris/oauth2-freelancer
```

## Usage

You can get your OAuth client credentials [here](https://accounts.freelancer.com/settings/develop).

```php
$provider = new Bordieris\OAuth2\Client\Provider\FreelancerProvider([
	'clientId' => 'client_id',
	'clientSecret' => 'client_secret',
	'redirectUri' => 'http://example.com/auth',
]);

$accessToken = $provider->getAccessToken('authorization_code', [
	'code' => $_GET['code'],
	'scope' => ['basic', 'fln:project_create', 'fln:project_manage'] // optional, defaults to ['basic']
]);
$actualToken = $accessToken->getToken();
$refreshToken = $accessToken->getRefresh();

// Once it expires

$newAccessToken = $provider->getAccessToken('refresh_token', [
	'refresh_token' => $refreshToken
]);
```
