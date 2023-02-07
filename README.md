# Project Title

Currency API

## Description

The purpose of this porject is to provide EUR exchange rates for following conditions:

- As a client, I want to get a list of all available currencies, if not present return empty.
- As a client, I want to get all EUR-FX exchange rates at all available dates as a collection, if not present pull from external API, save it and return it.
- As a client, I want to get the EUR-FX exchange rate at particular day, if not present pull from external API, save it and return it.
- As a client, I want to get a foreign exchange amount for a given currency converted to EUR on a particular day, if not present pull from external API, save it and return it.

## Important files and folder

    .
    ├── app                                     # Codeigniter Application
    │   ├── app
    |   |   ├── Config/Routes.php               # Contain routes for API
    |   |   ├── Controllers/CurrencyRate.php    # Controller for API
    |   |   ├── Database/Migrations             # Migrations run on start up of application
    |   |   ├── Libraries/CurrencyApi.php       # Library to fetch currency rates from external API
    |   |   ├── Models/CurrencyRateModel.php    # Model to save and fetch Currency rates in MySQL DB
    │   ├── tests                               # Contains Unit tests
    │   └── public                              # Public directory containing index.php
    ├── .docker                                 # Contains files for docker to run the applications
    ├── LICENSE
    └── README.md
    └── .gitignore

## API Reference

Api will be running on `https://localhost`

#### Get all currencies

```http
  GET /currencies
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key` | `string` | **Required**. Your API key |

#### Get currency rates for a particular date

```http
  GET /currencyRates/${date}
```

| Parameter | Type     | Description                                           |
| :-------- | :------- | :---------------------------------------------------- |
| `date`    | `string` | **Required**. Date for which rates need to be fetched |

#### Get currency rates for a particular currency code

```http
  GET /currencyRates/code/${currency_code}
```

| Parameter       | Type     | Description                                                    |
| :-------------- | :------- | :------------------------------------------------------------- |
| `currency_code` | `string` | **Required**. Currency Code for which rates need to be fetched |

#### Get currency rates for a particular currency code and date

```http
  GET /currencyRates/code/${currency_code}/${date}
```

| Parameter       | Type     | Description                                                    |
| :-------------- | :------- | :------------------------------------------------------------- |
| `currency_code` | `string` | **Required**. Currency Code for which rates need to be fetched |
| `date`          | `string` | **Required**. Date for which rates need to be fetched          |

## Run Locally

Clone the project

```bash
  git clone https://github.com/shreyanshuagarwal92/CurrencyRateApi
```

Go to the docker directory in project directory

```bash
  cd CurrencyRateApi/.docker
```

Build project

```bash
  docker-compose build
```

Start the server

```bash
  docker-compose up -d
```

Stop the server

```bash
  docker-compose down --rmi all -v --remove-orphans
```

## Running Tests

To run tests, run the following command

```bash
  docker-compose exec ci4-web bash
  cd app
  ./phpunit
```
