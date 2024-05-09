# Simple Payment

## How to install and run the project

- With the following command, having installed docker and docker-compose,
the project will be built and started.
```shell
docker-compose up --build
```
- By default, it runs the server on port 9511 and the database on port 3599.


## Api Documentation
- The api documentation is available in the openApi format, in the file `openapi.yaml` 
at the root of the project.

- If you're using an ide from the jetbrains family, you can use the plugin `OpenAPI Specification` 
to view the documentation. Normally its installed by default.

## How to consume the api 
1. The api can be used either importing the openapi.yaml file into a client like postman or insomnia,

2. If yre using an ide from the jetbrains family, you can the files located in the http folder to test the api.

## How to run the tests
- To run the tests, you can use the following command:
```shell
docker exec simplePayment-php composer test
```
