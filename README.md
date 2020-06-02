# Seobiro

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]



Natural language processing applied to search engine optimization

### Dataforseo (Get urls for keyword in Google)
```php
$dataforseo = new \aitor\seobiro\Dataforseo({EMAIL},{KEY});
$results = $dataforseo->get_organic_results("aitor rodriguez");
```

### Google Cloud (NLP)
```php
// No need to initiate, just place the key.json in the main directory.
```


### Usage
```php
$seobiro = new \aitor\seobiro\Seobiro();
```

### Get url contents
```php
$url = "https://aitor.me";
$content = $seobiro->getUrl($url);
```

### Get plain_text from content object
```php
$text = $seobiro->getText($content);
```

### Get language from plain_text
```php
$language = $seobiro->getLanguage($text);
```

### Get Tokens from plain_text
```php
$tokens = $seobiro->getTokens($text);
```

### Get Normalized Tokens
```php
$normalized = $seobiro->getNormalizedTokens($tokens);
```

### Get Stemmed Tokens
```php
  $tokens = $seobiro->getStemmedTokens($tokens);
```

### Remove Stopwords from token list
```php
$seobiro->removeStopWords($normalized,$language);
```

### Get Frequency Distribution from tokens
```php
$frequency = $seobiro->getFrequencyDistribution($normalized)
$frequency->getKeyValuesByWeight();
```

### Get Meta Description from content
```php
$description = $seobiro->getDescription($content);
```

### Get Meta Title from content
```php
$title = $seobiro->getTitle($content);
```

### Get Headers (h1-h6) from content
```php
$headers = $seobiro->getHeaders($content);
```

### Get Google Cloud NLP Entities
```php
$GoogleEntities = $seobiro->getGoogleEntities($text);
```

### Get Google Cloud NLP Sentiment
```php
$GoogleSentiment = $seobiro->getGoogleSentiment($text);
```



## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
src/        
example/
```


## Install

Via Composer

``` bash
$ composer require aitor/seobiro
```


## Security

If you discover any security related issues, please email soy[at]aitor.me instead of using the issue tracker.

## Credits

- [Aitor Rodríguez](https://aitor.me)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/aitor/seobiro.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/aitor/seobiro/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/aitor/seobiro.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/aitor/seobiro.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/aitor/seobiro.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/aitor/seobiro
[link-travis]: https://travis-ci.org/aitor/seobiro
[link-scrutinizer]: https://scrutinizer-ci.com/g/aitor/seobiro/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/aitor/seobiro
[link-downloads]: https://packagist.org/packages/aitor/seobiro
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
