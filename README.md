#### **Stage 2,3**

[Mind Map](Phase 3/mindmap.pdf)


1. Objective of the project:
    1. Make an online catalog of books for the library of the SDU University
    2. Automate internal processes (work) of the library and librarians
    3. User service: a service for issuing books
2. Problems and solutions:
    1. Unavailability of the book catalog during quarantine
        a. Make an online catalog for users with a list of all books and resources from the library
    2. Routine work of librarians:
        a. Buying books and registering them
        b. Entering book information into the database
        c. Issuance and control of books
        d. Process reports, books
        e. Automate processes (picking, cataloging)



---
1. Scope and functions of the project:
    1. Starting from 1.07.2020 to the current date, the project is under development
    2. The project consists of modules such as:
        a. Landing
        b. Administration
    
            1. Cataloging
            2. Picking
            3. Service
            4. Reports
          
    3. Functions: 
    
   a. Landing
    
            a. Provide complete information about books
                1. Title, authors, year of issue, image, description, etc.    
            b. Search for books by keywords
                1. Simple search
                2. Advanced Search
            c. Search for resources and other materials other than books
            d. Filtering by languages, dates, types of materials
    
   b. Administration 
    
       a. Cataloging  
                a. Book registration:  
                    a. Filling in information about incoming books 
                    b. Fill in all fields according to the format and standard  MARC21
                    c. Checking for the correctness of the entered data  
       b. Picking  
                a. CRUD operations and search for:
                    a. Batch of books (Batch)
                    b. Instance and copy (Item)
                    c. Publisher (Publisher)
                    d. The supplier (Supplier)
   c. Service
    
                a. Finding Users and Customers (Students and Staff)
                b. Displaying user data
                c. Issuing books to users
                d. Control of the period of issue and the date of return of books
   d. Reports
    
                a. Output of reports in .pdf, .csv format
                   a. Inventory books
                   b. Frequently read books
                   c. Attendance (Virtual and Offline)
                   d. History of books
                   e. KSU and Stat. report

---




1. Interface and reasons for choosing:
    *   Project interface - Web application
2. We decided to make it a web application, since quarantine measures against covid-19 are currently underway around the world. To access the library remotely, the web version of the project is the most suitable option for both users and librarians.



---




1. Programming language and database
*   Programming language:
    *   Backend part - PHP, Laravel
    *   Front end part - JS, Vue js
*   Database - Oracle database

Description:



*   We chose this stack for project implementations, since all projects within the university have the same stacks.
*   Database: University uses Oracle database
1. The database server works separately from the server where the project is deployed
    *   Database connections go through hostname / ip-address: port: sid using username, password, database name.
    *   Since the project is implemented on the Laravel framework, we use the ready-made yajra / oracle-oci8 library and php oci8 extension to connect to the Oracle database and build sql queries using the ORM built into the framework itself (Query builder, Eloquent builder)



---



#### 
**Stage 3**

Questions:



1. What information does our library contain about books? \
[dataset1.csv](Phase 3/dataset1.csv)
2. Are there other types of materials besides books in the library? \
[dataset2.csv](Phase 3/dataset2.csv) \
[dataset3.csv](Phase 3/dataset3.csv)
3. How are the books themselves and copies of books stored? \
[dataset4.csv](Phase 3/dataset4.csv)
4. What keywords are used to search for books?
    1. Title
    2. Author
    3. ISBN/ISSN
    4. Publisher
    5. Call Number
5. What are Book Batches? \
[dataset5.csv](Phase 3/dataset5.csv)
6. How are logs saved from each action in the library? \
[dataset6.csv](Phase 3/dataset6.csv)
7. How is attenuation controlled in the library? \
[dataset7.csv](Phase 3/dataset7.csv)
8. Library service: Book lending \
[dataset8.csv](Phase 3/dataset8.csv)
9. What are copies of books? \
[dataset4.csv](Phase 3/dataset4.csv)
10. What is the difference between batches and instances? \
A batch of books is the book itself with additional. information. A copy is a copy of a book. For example: The library received one batch of books with 100 copies.
11. What reports does the library have? \
[dataset9.csv](Phase 3/dataset9.csv)
12. What are book publishers? \
[dataset10.csv](Phase 3/dataset10.csv)
13. What are book providers? \
[dataset11.csv](Phase 3/dataset11.csv)
14. Who are our users?
    6. Students
    7. Employees
15. What roles and accesses (permissions) does the library have?
    8. User (Only has access to Landing)
    9. Admin - Librarian (Has access to the Admin)
