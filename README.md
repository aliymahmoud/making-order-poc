# Greetings!

This application was built on top of Laravel 10 and containerized by Laravel sail

## Getting Started

1. You must have docker running on your machine, [install Docker Compose](https://docs.docker.com/compose/install/).
2. Run `./vendor/bin/sail up`.
3. the endpoint for creating order is `/api/order` (POST)

## POC Challenges:
#### Making Order:
* The main challenge is creating an order which could be related to different type of products and each product has different ingredients, orders can be made with a concurrent request to the backend service.
* There are different solutions to handle concurrent request
  - Database Transactions
  - table-level locks
  - row-level locks
  - Queues
 
each one has it's Pros and Cons,
database approach can cause deadlocks and transactions isn't enough to solve the issue,
queues may be running on a concurrent channels will also may not solve the issue,
table-level lock applies restrictions on the whole table,
row-level lock can cause dead locks but it could seem the most reasonable approach

* in this Proof Of Concept (POC) the row-level lock is applied along wth database transaction with number of attempts in case of deadlock occurred. 
#### Notifying when one of the ingredients reach below a certain level:
* The other part is notify when the stock reach limits defined for every ingredient.
