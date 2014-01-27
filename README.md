# Разбор эсперанто слов

Эпохальная в своей бессмысленности тулза.

Пытается произвести синтаксический разбор слова на эсперанто.

Например: `malfermiĝis`: `(mal)ferm<iĝ>[is]`, корень `fermi` (закрывать), приставка `mal-` (противоположность), `-is` - глагол в прошедшем времени, суффикс `-iĝ` - становиться.
Додумать смысл слова оставляется пользователю.
В примере, это, по-видимому, "закрылось".

[Работающий пример](http://blgo.ru/tools/esperanto/).

Для русского языка используется словарь на три тысячи корней, основанный на [этом](http://www.natalimak1.narod.ru/esper/erslovar.htm).

Для протестированных текстов (несколько книг) определяет около 80% уникальных слов, покрывая при этом до 95% текста.
Большинство пропущенных слов - имена и названия.

На данный момент не справляется с составными словами.

### Требования, установка и всё такое

Требования: PHP 5.4+

Установка: компосер (`go/ewp`) или руками (всё в PSR-4).

Все нижеописанные классы находятся в пространстве имён `go\ewp`.

### Формат текста

Большинство методов понимают только нормализованную форму текста, то есть:

* Вся диакритика должна быть приведена к `x`-форме. То есть `ĝ` - `gx` и т.д.
* `ŭ` - также `ux` (а не `u~`).
* Все буквы приведены к нижнему регистру.

Произвольная форма (которую понимают меньшинство методов) подразумевает:

* Возможно наличие диакритики.
* Также рядом с ней могут содержаться буквы в `x`-форме.
* Заодно может быть `u~` и `U~`.
* Регистр может быть любым.
* Допустимы знаки пунктуации.

Конвертация:

* `Diacritic::diacritic2latin($text)` - текст в произвольной форме в нормализованную.
* `Diacritic::latin2diacritic($text)` - обратно.

### `Locale`: локаль

Локаль указывает на какой язык переводим.
Пока определена только русская.
Большинство сервисов доступно через локаль.

* `Locale::getSysLocale(string)` - получить системную локаль (определённую в библиотеке, доступна только `ru`).
* `new Locale(string $dir)` - создать локаль из каталога (формат каталога описан ниже).

### `Parser`: анализатор

Парсер доступен через локаль:

```php
use go\ewp\Locale;

$parser = Locale::getSysLocale('ru')->getParser();
```

Метод `parse()` получает слово и возвращает результат его анализа.

```php
echo $parser->parse('malfermigxis'); // (mal)ferm<igx>[is]
```

На выходе экземпляр класса `Result` или `NULL` если корень не определён.

### `Result`: результат разбора

Объект со следующими полями:

* `root`: основа слова (в примере `ferm`)
* `prefixes`: массив найденных приставок (в примере [`mal`])
* `suffixes`: массив найденных суффиксов (в примере [`igx`])
* `part`: часть речи в виде окончания (`is`, может быть `NULL`)
* `accus`: аккузатив (винительный падеж) (`TRUE/FALSE`)
* `plural`: множественное число (`TRUE/FALSE`)

Всё в нормализованной форме.

`__toString()` выводит объект в виде `(mal)ferm<igx>[is]`.

### Перевод

Полученные части слова можно перевести на язык локали.

##### Перевод корня

Сначала нужно привести основу к базовому корню, потом перевести.

```php
$dict = $locale->getDict();
$root = $dict->getRoot($result->root); // ferm --> fermi
echo $dict->translate($root); // fermi --> закрывать
```

##### Перевод приставки

```php
echo $locale->getPrefixes()->translate('mal'); // противоположность
```

##### Перевод суффикса

```php
echo $locale->getPrefixes()->translate('igx'); // становиться
```

##### Фонетика

Можно даже немного фонетикой побаловаться:

```php
$phonetics = $locale->getPhonetics();
echo $phonetics('malfermigxis'); // малфэрмиджис
```

### Структура локали

Локаль хранится в каталоге.
Предустановленные локали хранятся в `source/locals/$locale`.

* `roots.txt` - корни
* `prefixes.txt` - приставки
* `suffixes.txt` - суффиксы
* `phonetics.txt` - произношение букв

Все файлы представляют собой список элементов по одному на каждой строке, сначала элемент на эсперанто, потом, через двоеточие, перевод:

```plain
abelo        : пчела
abismo       : пропасть, пучина
abnegacio    : самоотверженность
aboli        : отменять, уничтожать
abolicii     : отменять, уничтожать
abomeno      : отвращение
```

В приставках и суффиксах, более длинные должны идти раньше более коротких.

### `Freq`: частотный словарь

Приблуда, позволяющая проверить, насколько успешно анализатор разбирает слова.

```php
use go\ewp\Freq;

$freq = new Freq('file1.txt');
$freq->appendFile('file2.txt');
$freq->appendFile('file3.txt');
$freq->appendContent('Tio estas iom da enhavo');
```

Словарю скармливаются тексты (в произвольной форме).
Можно посмотреть их статистику:

```php
$freq->getWords();
```

Возвращает упорядоченный словарь всех найденных слов (в нормализованной форме) и их количество.
Например:

```plain
[la] => 7218
[mi] => 3342
[kaj] => 3156
[de] => 2010
[en] => 1289
[al] => 1215
[li] => 1204
[ne] => 1168
[estis] => 1136
[vi] => 847
```

`$freq->getCount()` - возвращает общее количество найденных слов (не уникальных, которых можно получить из размера предыдущего массива), а именно всех слов.

```php
$res = $freq->passParser($parser);
```

Этот метод пропускает все слова через переданный ему анализатор.
Возвращает объект со следующими полями:

* `success` - массив всех успешно разобранных слов (в формате `'malfermigxis' => '(mal)ferm<igx>[is]'`).
* `fail` - порядковый массив всех слов, которые не удалось разобрать (упорядоченный от самых частотных).
* `uniq` - всего уникальных слов.
* `words` - общее количество слов.
* `puniq` - разобранных слов.
* `pwords` - какое количество составляют разобранные слова.
* `peruniq` - процент разбора уникальных.
* `perwords` - процент разбора среди общего количества.

Пример разбора текста.
Успешные слова:

```plain
[la] => la
[mi] => mi
[kaj] => kaj
[de] => de
[estis] => est[is]
[ne] => ne
[li] => li
[al] => al
[en] => en
[vi] => vi
[por] => por
[estas] => est[as]
[ni] => ni
[ke] => ke
[sed] => sed
...
```

Обломные слова:

```plain
muro, kapjesis, finfine, fortikajxo, spukavatem, lizbeta, reen, konstruajxo, samtempe, ekstaris ...
```

Статистика:

```plain
uniq : 11433
count: 65009
p uniq: 8636 (75%)
p count: 60130 (92%)
```

