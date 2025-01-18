# liveblog


## Uruchomienie Środowiska Deweloperskiego
- Sklonuj repozytorium
- Skopiuj .env do .env.local i dostosuj wartości
- Uruchom
  ```docker-compose up -d```
- Zainstaluj zależności: 
```composer install```

## liveblog-api [Dokumentacja](relation-api/README.md)

# LiveBlog Relation API

System zarządzania relacjami z obsługą aktualizacji w czasie rzeczywistym przy użyciu Mercure. Aplikacja zbudowana jest w oparciu o framework Symfony.

## Architektura Systemu

System wykorzystuje następujące kluczowe komponenty:
- Framework Symfony
- MongoDB jako baza danych
- RabbitMQ do kolejkowania wiadomości
- Mercure do aktualizacji w czasie rzeczywistym
- Docker do konteneryzacji

#### messanger
```
php bin/console messenger:consume async -vv
```

#### phpstan
```
php vendor/bin/phpstan analyse
```
#### behat
```
APP_ENV=test vendor/bin/behat
```

## Główne Funkcjonalności


### 1. Przepływ Zarządzania Relacjami

### Dodawanie relacji

#### Tworzenie Relacji
```mermaid
sequenceDiagram
    participant Klient
    participant API
    participant CommandBus
    participant Handler
    participant MongoDB
    participant Mercure

    Klient->>API: POST /api/relations
    API->>CommandBus: CreateRelationCommand
    CommandBus->>Handler: Obsługa Komendy
    Handler->>MongoDB: Zapis Relacji
    Handler->>Mercure: Publikacja Aktualizacji
    Mercure-->>Klient: Aktualizacja w czasie rzeczywistym
    API-->>Klient: 201 Created
```


### Zmiana statusu
```mermaid
sequenceDiagram
    participant Klient
    participant API
    participant CommandBus
    participant Handler
    participant MongoDB
    participant Mercure

    Klient->>API: POST /api/relations/{id}/change_status
    API->>CommandBus: RelationChangeStatusCommand
    CommandBus->>Handler: Obsługa Komendy
    Handler->>MongoDB: Aktualizacja Statusu
    Handler->>Mercure: Publikacja Zmiany Statusu
    Mercure-->>Klient: Aktualizacja w czasie rzeczywistym
    API-->>Klient: 200 OK
 ```

### Usuwanie relacji

```mermaid
sequenceDiagram
participant Klient
participant API
participant CommandBus
participant Handler
participant MongoDB
participant Mercure

    Klient->>API: DELETE /api/relations/{id}
    API->>CommandBus: RelationDeleteCommand
    CommandBus->>Handler: Obsługa Komendy
    Handler->>MongoDB: Usunięcie Relacji
    Handler->>Mercure: Publikacja Usunięcia
    Mercure-->>Klient: Aktualizacja w czasie rzeczywistym
    API-->>Klient: 204 No Content
```

### Pobieranie relacji

```mermaid
sequenceDiagram
    participant Klient
    participant API
    participant QueryBus
    participant Handler
    participant MongoDB

    Klient->>API: GET /api/relations/{id}
    API->>QueryBus: GetOneRelationQuery
    QueryBus->>Handler: Obsługa Zapytania
    Handler->>MongoDB: Pobranie Relacji
    MongoDB-->>Handler: Zwrot Danych
    Handler-->>API: Zwrot DTO
    API-->>Klient: 200 OK z Danymi
```

### Przepływ Zdarzeń
```mermaid
graph LR
    A[Żądanie Klienta] --> B[Kontroler API]
    B --> C{Komenda/Zapytanie}
    C -->|Komenda| D[Command Bus]
    C -->|Zapytanie| E[Query Bus]
    D --> F[Command Handler]
    E --> G[Query Handler]
    F --> H[Zdarzenie Domenowe]
    H --> I[Event Bus]
    I --> J[Handlery Zdarzeń]
    J --> K[Hub Mercure]
    K --> L[Subskrybujący Klienci]
```

## Autorzy
Wojciech Borek

## Licencja
Ten projekt jest licencjonowany na warunkach licencji MIT.
