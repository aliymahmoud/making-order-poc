# Greetings!

This application was built on top of Laravel 10 and containerized by Laravel sail

## Getting Started

1. You must have docker running on your machine, [install Docker Compose](https://docs.docker.com/compose/install/).
2. Run `./vendor/bin/sail up`.
3. the endpoint for creating order is `/api/order` (POST)

## POC Challenges:
#### Making Order:
* The main challenge is creating an order that could be related to different types of products and each product has different ingredients, orders can be made with a concurrent request to the backend service.
* There are different approaches to handle concurrent request
  - Database Transactions
  - table-level locks
  - row-level locks
  - Queues
 
each one has its Pros and Cons,
database approach can cause deadlocks and transactions aren't enough to solve the issue,
queues may be running on concurrent channels also may not solve the issue,
table-level lock applies restrictions on the whole table,
row-level lock can cause deadlocks but it could seem the most reasonable approach

* in this Proof Of Concept (POC) the row-level lock is applied along with the database transaction with several attempts in case of a deadlock. 
#### Notifying when one of the ingredients reaches below a certain level:
* The other part is notified when the stock reaches limits defined for every ingredient (the ingredients stock level has a default value of 50% to send the email, and can be modified for each ingredient).

## ERD
![Database Structure](https://file.io/2DDoPOuugYy5)
* The order has a polymorphic relationship with the order items (orderables table) so the order can include different things than products.
* Each ingredient has a custom limit for triggering the notification but it has a default value of 50% and it can be a fixed number.

## Enhancements
* use value objects for quantity, money, and prices
* add feature tests
