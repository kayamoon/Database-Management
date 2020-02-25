

-- creates database for Little Taipei Restaurant Ordering System --
-- by Kaya Chou-Kudu 12/9/19 --
-- CS 333 DBMS Final Project --

CREATE TABLE Customer(
customerID int auto_increment primary key,
firstName varchar(50),
lastName varchar(50),
phoneNumber varchar(20),
addressName varchar(100),
city varchar(30),
stateName varchar(30)
);

CREATE TABLE Menu(
menuID int auto_increment primary key,
menuDescription varchar(200)
);

CREATE TABLE Category(
categoryID int auto_increment primary key,
categoryName varchar(50)
);

CREATE TABLE MenuItem(
itemID int auto_increment primary key,
itemName varchar(100),
quantityInStock int, 
unitPrice float,
menuID int,
categoryID int
);

CREATE TABLE Orders(
orderID int auto_increment primary key,
orderDateTime datetime,
totalCost float,
numberOfItems int,
customerID int
);


ALTER TABLE MenuItem ADD
foreign key (categoryID) references
Category(categoryID);


CREATE TABLE OrderItem(
orderItemID int auto_increment primary key,
quantityBought int,
itemID int,
orderID int
);

ALTER TABLE OrderItem ADD
foreign key (itemID) references
MenuItem(itemID);

ALTER TABLE OrderItem ADD
foreign key (orderID) references
Orders(orderID);




-- test queries starts --

INSERT into Customer(firstName,lastName,phoneNumber,addressName,city,stateName)values('Kaya','Moon','7184996074','111 West St','Boston','MA');

INSERT into Orders(orderDateTime,totalCost,numberOfItems,customerID)values(now(),25.75,3,1);

INSERT into OrderItem(quantityBought,itemID,orderID)values(3,4,1); 

-- test queries ends --




-- view database queries starts --

SHOW TABLES;


DESCRIBE Customer;
DESCRIBE Menu;
DESCRIBE Category;
DESCRIBE MenuItem;
DESCRIBE Orders;
DESCRIBE OrderItem;


SELECT COUNT(*) FROM Customer;
SELECT COUNT(*) FROM Menu;
SELECT COUNT(*) FROM Category;
SELECT COUNT(*) FROM MenuItem;
SELECT COUNT(*) FROM Orders;
SELECT COUNT(*) FROM OrderItem;


SELECT customerID, firstName, lastName, stateName, phoneNumber FROM Customer;

SELECT menuID, menuDescription FROM Menu;

SELECT categoryID, categoryName FROM Category;

SELECT itemID, itemName, unitPrice, menuID, categoryID FROM MenuItem;

SELECT orderItemID, quantityBought, itemID, orderID FROM OrderItem;

SELECT orderDateTime, totalCost, numberOfItems, customerID FROM Orders;

