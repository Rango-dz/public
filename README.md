```
 _               _       _                 _ _            
(_)_      ____ _| |_ ___| |__   ___  _ __ | (_)_ __   ___ 
| \ \ /\ / / _` | __/ __| '_ \ / _ \| '_ \| | | '_ \ / _ \
| |\ V  V / (_| | || (__| | | | (_) | | | | | | | | |  __/
|_| \_/\_/ \__,_|\__\___|_| |_|\___/|_| |_|_|_|_| |_|\___|
                                                                                                                                    
```

## Table of Contents

- [Introduction](#introduction)
- [Tools & Versions](#tools--versions)
- [Installation](#installation)
    * [Project Setup](#project-setup)
        + [Configuration](#configuration)
        + [Platform Setup](#platform-setup)
- [Application Links](#application-links)
    * [Portal](#portal)

## Introduction

iWatchOline is a multi-purpose movie and TV series platform.

## Tools & Versions

| Tool     | Version |
|----------|---------|
| PHP      | 8.1     |
| Laravel  | 10.0    |
| Composer | 2.6.5   |
| Node.js  | 21.2.0  |
| MySQL    | 8.1.0   |


## Installation

### Project Setup

#### Configuration

1. Add the following entries into your `/etc/hosts` file

   ```
   echo "127.0.0.1 iwatchonline.test" >> /etc/hosts
   ```

2. Create a database named `mtdb` in your local.

   ```sql
   CREATE DATABASE mtdb;
   ```

#### Platform Setup

1. Clone our repository inside your iwatchonline folder `~/iwatchonline/`

   ```
   cd ~/iwatchonline/
   ```

   ```
   git clone git@github.com:Rango-dz/public.git
   ```

2. Connect to `php81` container where the project is hosted

   ```
   cd ~/iwatchonline/public
   ```

3. Initiate `.env` file and change db connection config

   ```
   cp env.example .env
   ```

4. Install the dependencies

   ```
   composer install
   ```

5. Migrate the tables

   ```
   php artisan migrate
   ```

6. Seed the database

   ```
   php artisan db:seed
   ```

   ```
   php artisan common:seed
   ```
   
7. Generate checksums

   ```
   php artisan checksums:generate
   ```


8. Install npm dependencies

   ```
   npm install
   ```

9. Run SSR server

   ```
   npm run ssr
   ```

## Application Links

### Portal

http://iwatchonline.test
