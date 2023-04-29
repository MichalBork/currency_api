### Api do prostego zapisu walut

#### Instalacja
1. Sklonuj repozytorium
2. Zainstaluj zależności composer install
3. Wykonaj migracje php bin/console doctrine:migrations:migrate
4. Wygeneruj uzytkownika php bin/console app:create-new-user


#### Opis
API służy do zapisywania kursów walut. Poniżej przedstawiam najważniejsze informacje na jego temat:

###
##### Autoryzacja:

Autoryzacja odbywa się przez header X-API-KEY. Każda metoda HTTP ma sprawdzane swoje uprawnienia za pomocą wzorca projektowego strategii

##### Zapis do bazy:

Do bazy zapisujemy datę jako timestamp, a kwotę waluty jako int i zmieniamy na float. Powodem zapisywania kwoty jako int jest uniknięcie problemów z dokładnością wynikającymi z niedoskonałości zmiennoprzecinkowej. Floaty mogą mieć różne wartości, np. 1.2345 może być zapisane jako 1.234500001, co prowadziłoby do błędów przy porównywaniu wartości.

##### Format daty:
Timestamp jest wykorzystywany dla łatwiejszego porównania wartości i uniknięcia problemów z formatem daty. W ten sposób, każda wartość jest zapisywana jako liczba całkowita i może być łatwo porównywana z innymi wartościami.

##### Logi:
Logi sa zapisywane w pliku logs/log.txt 

#### Endpointy

##### GET /get-currency/{date} - lista kursów z danego dnia

##### GET /get-currency/{date}/{currency} - kurs waluty z danego dnia

##### POST /add-currency - dodanie kursu waluty
##### Przykładowe zapytanie:
```
curl --location --request GET 'localhost:8012/add-currency' \
--header 'X-API-KEY: 347029d6-b215-44f9-8952-6d7621f16af7' \
--header 'Content-Type: application/json' \
--data '[
{"currency": "EUR", "date": "2023-04-13", "amount": 4.66},
{"currency": "USD", "date": "2023-04-13", "amount": 4.86},
{"currency": "GBP", "date": "2023-04-13", "amount": 6.66}
]'
```

#### POST /check-token-validity - sprawdzenie ważności tokenu
##### Przykładowe zapytanie:
```
curl --location --request GET 'localhost:80/check-token-validity' \
--form 'token="347029d6-b215-44f9-8952-6d7621f16af7"'
```



