# Simple Payment

## How to install and run the project

- With the following command, having installed docker and docker-compose,
the project will be built and started.
```shell
docker-compose up --build
```
- By default, it runs the server on port 9511 and the database on port 3599.


## API Documentation
- The API documentation is available in the OpenAPI format, in the file openapi.yaml at the root of the project.

- f you're using an IDE from the JetBrains family, you can use the plugin OpenAPI Specification to view the documentation. 
Normally it is installed by default.

## How to consume the API
1. The API can be used either importing the openapi.yaml file into a client like Postman or Insomnia.

2. If you're using an IDE from the JetBrains family, you can use the files located in the `http` folder to test the API.

## How to run the tests
- To run the tests, you can use the following command:
```shell
docker exec simplePayment-php composer test
```
